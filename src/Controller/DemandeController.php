<?php

namespace App\Controller;

use Knp\Snappy\Pdf;
use App\Entity\User;
use App\Entity\Commune;
use App\Entity\Demande;
use App\Entity\Affecter;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Form\DemandeType;
use App\Entity\TamponAffecter;
use App\Service\DemandeService;
use App\Repository\UserRepository;
use App\Repository\DemandeRepository;
use App\Repository\AffecterRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InstitutionRepository;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\TamponAffecterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use RuntimeException;

#[Route('/demande')]
class DemandeController extends AbstractController
{
    private $knpSnappy;
    private $entityManager;
    private $security;
    private $serializer;

    private $demandeRepository;
    private $tamponAffecterRepository;

    private $institutionRepository;
    private $affecterRepo;
    private $userRepo;



    public function __construct(Pdf $knpSnappy, InstitutionRepository $institutionRepository, AffecterRepository $affecterRepo, UserRepository $userRepo, DemandeRepository $demandeRepository, TamponAffecterRepository $tamponAffecterRepository, Security $security, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->demandeRepository = $demandeRepository;
        $this->tamponAffecterRepository = $tamponAffecterRepository;
        $this->institutionRepository = $institutionRepository;
        $this->affecterRepo = $affecterRepo;
        $this->userRepo = $userRepo;
        $this->knpSnappy = $knpSnappy;

    }

    #[Route('/', name: 'demande.index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
        }

        if (in_array('ROLE_POINT_FOCAL', $roles, true)) {
            $demandes = $demandeRepository->findBy([
                'demander' => $user,
                'statut' => 'Initial',
                'deleteAt' => null,
            ]);
        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
            // Récupération de la structure de l'utilisateur connecté
            $structure = $user->getStructure();
            
            // Récupération des demandes associées à cette structure
            $demandes = $demandeRepository->findBy([
                'structure' => $structure,
                'statut' => 'Initial',
                'deleteAt' => null,
            ]);
        } elseif (in_array('ROLE_CHEF_PARC', $roles, true)) {
            $demandes = []; // Initialisation du tableau pour accumuler les demandes

            // Récupération du parc du chef de parc
            $parc = $user->getStructure()->getParc();

            // Récupération des structures associées à ce parc
            $structures = $parc->getStructure();

            // Parcourir chaque structure pour récupérer les demandes
            foreach ($structures as $structure) {
                $structuresdemandes = $demandeRepository->findBy([
                    'structure' => $structure,
                    'traiterPar' => $user,
                    'statut' => 'Approuvé',
                    'deleteAt' => null
                ]);

                // Ajouter ces demandes au tableau accumulatif
                $demandes = array_merge($demandes, $structuresdemandes);
            }
        } else {
            $institution = $user->getInstitution();
            $demandes = $demandeRepository->findBy([
                'institution' => $institution,
                'deleteAt' => null
            ]);
        }

        return $this->render('demande/index.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,

        ]);
    }


// Ici on gère la finalisation des demandes pour libérer les véhicules et chaiffaurs

        // 1- Affichage de la liste des missions achevées
        #[Route('/expirees', name: 'demandes.expirees')]
        public function expiredMissions(DemandeRepository $demandeRepository): Response
        {
            $expiredMissions = $demandeRepository->findExpiredMissions();

            return $this->render('demande/expired.html.twig', [
                'expiredMissions' => $expiredMissions,
            ]);
        }




        //2-  Affichage du détail d'une mission achevée
        #[Route('/demande/{id}', name: 'demande.details', methods: ['GET', 'POST'])]
        public function detailsDemande(Request $request, Demande $demande, TamponAffecterRepository $tamponAffecterRepository): Response
        {
            $kilometragesData = [];
            foreach ($demande->getAffecters() as $affecter) {
                $kilometragesData[] = [
                    'vehiculeMatricule' => $affecter->getVehicule()->getMatricule(),
                    'chauffeurNom' => $affecter->getChauffeur()->getNomChauffeur(),
                    'chauffeurPrenom' => $affecter->getChauffeur()->getPrenomChauffeur(),
                    'kilometrageReleve' => $affecter->getVehicule()->getKilometrageCourant(),
                    'vehiculeId' => $affecter->getVehicule()->getId(),
                    'chauffeurId' => $affecter->getChauffeur()->getId(),
                ];
            }
        
            // Vider la table tampon si elle contient des données
            $tamponAffecterRepository->clearTable();
        
            // Insérer les nouvelles données dans la table tampon
            $tamponAffecterRepository->insertData($kilometragesData);
        
            // Récupérer les données de tamponAffecter pour les passer à la vue
            $tamponAffecterData = $tamponAffecterRepository->findAllAssociative();
        
            return $this->render('demande/details.html.twig', [
                'demande' => $demande,
                'tamponAffecterData' => $tamponAffecterData,
            ]);
        }
    

        //3-  Mise à jour du kilométrage
        #[Route('/update-kilometrage', name: 'demande.update_kilometrage', methods: ['POST'])]
        #[IsGranted('ROLE_CHEF_PARC')]
        public function updateKilometrage(Request $request, TamponAffecterRepository $tamponAffecterRepository): JsonResponse
        {
            $user = $this->getUser();
            if ($this->isGranted('ROLE_ADMIN', $user)) {
                return new JsonResponse(['error' => 'Accès refusé.'], 403);
            }
        
            $matricule = $request->request->get('matricule');
            $kilometrage = $request->request->get('kilometrage');
            $oldKilometrage = $request->request->get('oldKilometrage');
        
            if ($kilometrage < $oldKilometrage) {
                return new JsonResponse(['error' => 'Le nouveau kilométrage ne peut pas être inférieur ou égal à l\'ancien kilométrage.']);
            }
        
            $tamponAffecterRepository->updateKilometrage($matricule, $kilometrage);
        
            $updatedData = $tamponAffecterRepository->findAllAssociative();
        
            return new JsonResponse($updatedData);
        }


        //4-  Libération véhicules et chauffeurs
        #[Route('/finalize', name: 'demande.finalize', methods: ['POST'])]
        #[IsGranted('ROLE_CHEF_PARC')]
        public function finalize(Request $request, EntityManagerInterface $entityManager, UserInterface $currentUser)
        {
            $user = $this->getUser();
            if ($this->isGranted('ROLE_ADMIN', $user)) {
                return new JsonResponse(['error' => 'Accès refusé.'], 403);
            }

            $data = $request->request->all();
            $dateEffectiveFinMission = $data['dateEffectiveFinMission'];
            $observations = $data['commentaire'];

            // Vérifiez que la date effective de fin de mission est renseignée
            if (empty($dateEffectiveFinMission)) {
                return new JsonResponse(['error' => 'Le champ de date ne doit pas être vide.'], 400);
            }

            $demande = $entityManager->getRepository(Demande::class)->find($data['id']);

            if (!$demande) {
                return new JsonResponse(['error' => 'Demande non trouvée.'], 404);
            }

            // Mettre à jour les champs de la demande
            $demande->setDateEffectiveFinMission(new \DateTime($dateEffectiveFinMission));
            $demande->setDateFinalisationDemande(new \DateTime());
            $demande->setObservations($observations);
            $demande->setFinaliserPar($user); // Assurez-vous que cette méthode est disponible
            $demande->setStatut('Finalisé');

            // Récupérer tous les enregistrements dans TamponAffecter
            $tamponAffecters = $entityManager->getRepository(TamponAffecter::class)->findAll();
            
            foreach ($tamponAffecters as $tamponAffecter) {
                // Mettre à jour les véhicules
                $vehicule = $entityManager->getRepository(Vehicule::class)->find($tamponAffecter->getTamponVehiculeId());
                if ($vehicule) {
                    $vehicule->setDisponibilite('Disponible');
                    $vehicule->setKilometrageCourant($tamponAffecter->getTamponKilometrage());
                    $entityManager->persist($vehicule);
                }

                // Mettre à jour les chauffeurs
                $chauffeur = $entityManager->getRepository(Chauffeur::class)->find($tamponAffecter->getTamponChauffeurId());
                if ($chauffeur) {
                    $chauffeur->setDisponibilite('Disponible');
                    $entityManager->persist($chauffeur);
                }

                // Supprimer l'enregistrement du tampon après mise à jour
                $entityManager->remove($tamponAffecter);
            }

            $entityManager->flush();

            return new JsonResponse(['success' => true]);
        }
// Ici fin de la finalisation des demandes pour libérer les véhicules et chaiffaurs    




 
// Ici on affiche la liste des demandes rejetées

    #[Route('/demandes/rejetees', name: 'demande.rejetees', methods: ['GET'])]
    public function rejetees(DemandeRepository $demandeRepository): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
        }

        if (in_array('ROLE_POINT_FOCAL', $roles, true)) {
            $demandes = $demandeRepository->findBy([
                'demander' => $user,
                'statut' => 'Rejeté',
                'deleteAt' => null,
            ]);
        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
            $demandes = $demandeRepository->findBy([
                'validateurStructure' => $user,
                'statut' => 'Rejeté',
                'deleteAt' => null,
            ]);
        } elseif (in_array('ROLE_CHEF_PARC', $roles, true)) {
            $demandes = []; // Initialisation du tableau pour accumuler les demandes

            // Récupération du parc du chef de parc
            $parc = $user->getStructure()->getParc();

            // Récupération des structures associées à ce parc
            $structures = $parc->getStructure();

            // Parcourir chaque structure pour récupérer les demandes
            foreach ($structures as $structure) {
                $structuresdemandes = $demandeRepository->findBy([
                    'structure' => $structure,
                    'traiterPar' => $user,
                    'statut' => 'Rejeté',
                    'deleteAt' => null
                ]);

                // Ajouter ces demandes au tableau accumulatif
                $demandes = array_merge($demandes, $structuresdemandes);
            }
        } else {
            $institution = $user->getInstitution();
            $demandes = $demandeRepository->findBy([
                'institution' => $institution,
                'statut' => 'Rejeté',
                'deleteAt' => null
            ]);
        }
        return $this->render('demande/rejetees.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
        ]);
    }

// Ici fin affichage de la liste des demandes rejetées

// Ici on affiche la liste des demandes approuvées

    #[Route('/approuvees', name: 'demande.approuvees', methods: ['GET'])]
    public function approuvees(DemandeRepository $demandeRepository): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
        }

        if (in_array('ROLE_POINT_FOCAL', $roles, true)) {
            $demandes = $demandeRepository->findBy([
                'demander' => $user,
                'statut' => 'Approuvé',
                'deleteAt' => null,
            ]);
        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
            $demandes = $demandeRepository->findBy([
                'validateurStructure' => $user,
                'statut' => 'Approuvé',
                'deleteAt' => null,
            ]);
        } elseif (in_array('ROLE_CHEF_PARC', $roles, true)) {
            $demandes = []; // Initialisation du tableau pour accumuler les demandes

            // Récupération du parc du chef de parc
            $parc = $user->getStructure()->getParc();

            // Récupération des structures associées à ce parc
            $structures = $parc->getStructure();

            // Parcourir chaque structure pour récupérer les demandes
            foreach ($structures as $structure) {
                $structuresdemandes = $demandeRepository->findBy([
                    'structure' => $structure,
                    'statut' => 'Approuvé',
                    'deleteAt' => null
                ]);

                // Ajouter ces demandes au tableau accumulatif
                $demandes = array_merge($demandes, $structuresdemandes);
            }
        } else {
            $institution = $user->getInstitution();
            $demandes = $demandeRepository->findBy([
                'institution' => $institution,
                'statut' => 'Approuvé',
                'deleteAt' => null
            ]);
        }

        return $this->render('demande/approuvees.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
        ]);
    }

// Ici fin affichage de la liste des demandes approuvées

// Ici on affiche la liste des demandes validées


    #[Route('/validees', name: 'demande.validees', methods: ['GET'])]
    public function validees(DemandeRepository $demandeRepository): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
        }

        if (in_array('ROLE_POINT_FOCAL', $roles, true)) {
            $demandes = $demandeRepository->findBy([
                'demander' => $user,
                'statut' => 'Validé',
                'deleteAt' => null,
            ]);
        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
            $demandes = $demandeRepository->findBy([
                'validateurStructure' => $user,
                'statut' => 'Validé',
                'deleteAt' => null,
            ]);
        } elseif (in_array('ROLE_CHEF_PARC', $roles, true)) {
            $demandes = []; // Initialisation du tableau pour accumuler les demandes

            // Récupération du parc du chef de parc
            $parc = $user->getStructure()->getParc();

            // Récupération des structures associées à ce parc
            $structures = $parc->getStructure();

            // Parcourir chaque structure pour récupérer les demandes
            foreach ($structures as $structure) {
                $structuresdemandes = $demandeRepository->findBy([
                    'structure' => $structure,
                    'traiterPar' => $user,
                    'statut' => 'Validé',
                    'deleteAt' => null
                ]);

                // Ajouter ces demandes au tableau accumulatif
                $demandes = array_merge($demandes, $structuresdemandes);
            }
        } else {
            $institution = $user->getInstitution();
            $demandes = $demandeRepository->findBy([
                'institution' => $institution,
                'statut' => 'Validé',
                'deleteAt' => null
            ]);
        }
   
        return $this->render('demande/validees.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
            'type' => 'validées'
        ]);
    }

// Ici fin affichage de la liste des demandes validées

// Ici affichage de la liste des demandes finalisées

#[Route('/finalisees', name: 'demande.finalisees', methods: ['GET'])]
public function finalisees(DemandeRepository $demandeRepository): Response
{
    $user = $this->getUser();
    $roles = $user->getRoles();

    if (!$user instanceof User) {
        throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
    }

    if (in_array('ROLE_POINT_FOCAL', $roles, true)) {
        $demandes = $demandeRepository->findBy([
            'demander' => $user,
            'statut' => 'Finalisé',
            'deleteAt' => null,
        ]);
    } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
        $demandes = $demandeRepository->findBy([
            'validateurStructure' => $user,
            'statut' => 'Finalisé',
            'deleteAt' => null,
        ]);
    } elseif (in_array('ROLE_CHEF_PARC', $roles, true)) {
        $demandes = []; // Initialisation du tableau pour accumuler les demandes

        // Récupération du parc du chef de parc
        $parc = $user->getStructure()->getParc();

        // Récupération des structures associées à ce parc
        $structures = $parc->getStructure();

        // Parcourir chaque structure pour récupérer les demandes
        foreach ($structures as $structure) {
            $structuresdemandes = $demandeRepository->findBy([
                'structure' => $structure,
                'traiterPar' => $user,
                'statut' => 'Finalisé',
                'deleteAt' => null
            ]);

            // Ajouter ces demandes au tableau accumulatif
            $demandes = array_merge($demandes, $structuresdemandes);
        }
    } else {
        $institution = $user->getInstitution();
        $demandes = $demandeRepository->findBy([
            'institution' => $institution,
            'statut' => 'Finalisé',
            'deleteAt' => null
        ]);
    }

    return $this->render('demande/finalisees.html.twig', [
        'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
        'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
        'demandes' => $demandes,
        'type' => 'finalisées'
    ]);
}
// Ici fin affichage de la liste des demandes finalisées


#[Route('/new', name: 'demande.create', methods: ['GET', 'POST'])]
#[IsGranted('ROLE_POINT_FOCAL')]
public function new(Request $request): Response
{
    $user = $this->getUser();
    if (!$user instanceof User) {
        throw $this->createAccessDeniedException('L\'utilisateur nest pas connecté');
    } else {

        // Vérifie si l'utilisateur a le rôle ROLE_POINT_FOCAL mais pas le rôle ROLE_ADMIN
        if (!$this->isGranted('ROLE_POINT_FOCAL') || $this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à accéder à cette ressource.');
        }

        $communes = $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]);
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user) {
                $structure = $user->getStructure();
                $institution = $user->getInstitution();
                $demande->setStructure($structure);
                $demande->setInstitution($institution);
                $demande->setDemander($user);
            } else {
                // Gérer le cas où l'utilisateur n'est pas authentifié
                throw new \Exception('Utilisateur non authentifié');
            }

            // Générer un code aléatoire de 10 chiffres et vérifier son unicité
            do {
                $numDemande = random_int(1000000000, 9999999999); // Génère un code de 10 chiffres
                $existingDemande = $this->entityManager->getRepository(Demande::class)->findOneBy(['numDemande' => $numDemande]);
            } while ($existingDemande !== null);
            
            // Assigner le code unique au champ numDemande
                $demande->setNumDemande($numDemande);
    
            $dateDemandeStr = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
            $dateDemande = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dateDemandeStr);
            $demande->setDateDemande($dateDemande);
            $demande->setStatut('Initial');
            $this->entityManager->persist($demande);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');
    
            return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
        }
    }
    
    return $this->render('demande/new.html.twig', [
        'communes' => $communes,
        'demande' => $demande,
        'form' => $form,
    ]);
}



    #[Route('/{id}', name: 'demande.show', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(Demande $demande, EntityManagerInterface $entityManager, $id): Response
    {
        $demande = $entityManager->getRepository(Demande::class)->find($id);
    
        if (!$demande) {
            throw $this->createNotFoundException('Demande introuvable.');
        }
    
        // Vérification des conditions
        if ($demande->getAffecters()->count() > 0 &&
            ($demande->getStatut() === 'Validé') &&
            $demande->getDateTraitement() !== null)
        {
            $details = $entityManager->getRepository(Affecter::class)->findBy(['demande' => $demande]);
            dump($details);
    
            $data = [];
            foreach ($details as $detail) {
                $vehicule = $detail->getVehicule();
                $chauffeur = $detail->getChauffeur();
                if ($vehicule && $chauffeur) {
                    $data[] = [
                        'matricule' => $vehicule->getMatricule(),
                        'photoVehicule' => $vehicule->getPhotoVehicule(),
                        'nomChauffeur' => $chauffeur->getNomChauffeur(),
                        'prenomChauffeur' => $chauffeur->getPrenomChauffeur(),
                        'photoChauffeur' => $chauffeur->getPhotoChauffeur()
                    ];
                }
            }
        } else {
            // Initialiser $data à un tableau vide si les conditions ne sont pas remplies
            $data = [];
        }
    
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
            'details' => $data, // Passer toujours la variable details
        ]);
    }









    #[Route('/{id}/edit', name: 'demande.edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_POINT_FOCAL')]
    public function edit(Request $request, Demande $demande): Response
    {
        if ($demande->getStatut() !== 'Initial') {
            $this->addFlash('error', 'Vous ne pouvez modifier une demande que si son statut est "Initial".');
            return $this->redirectToRoute('demande.index');
        }

        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }










    #[Route('/{id}/approve', name: 'demande.approve', methods: ['GET', 'POST'])]
    public function approve(Demande $demande): Response
    {
        $user = $this->getUser();
    
        // Vérifie que l'utilisateur a le rôle ROLE_RESPONSABLE_STRUCTURE mais pas le rôle ROLE_ADMIN
        if (!$this->isGranted('ROLE_RESPONSABLE_STRUCTURE') || $this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à avoir accès à cette ressource.');
        }
    
        if ($demande->getStatut() !== 'Initial') {
            $this->addFlash('error', 'Vous ne pouvez approuver une demande que si son statut est "Initial".');
            return $this->redirectToRoute('demande.index');
        } else {
            $demande->setStatut('Approuvé');
            $demande->setValidateurStructure($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'Approbation réussie.');
        }
    
        return $this->redirectToRoute('demande.index');
    }
    


    #[Route('/{id}/dismiss', name: 'demande.dismiss', methods: ['GET', 'POST'])]
    public function dismiss(Request $request, Demande $demande): Response
    {
        // Vérifie si l'utilisateur a l'un des rôles requis
        if (!$this->isGranted('ROLE_RESPONSABLE_STRUCTURE') && !$this->isGranted('ROLE_CHEF_PARC')) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à avoir accès à cette ressource.');
        }
    
        // Vérifie si l'utilisateur a le rôle ROLE_ADMIN
        if ($this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous ne pouvez pas accéder à cette ressource.');
        }
    
        if ($request->isMethod('POST')) {
            $raisonRejetApprobation = $request->request->get('raisonRejetApprobation');
            $demande->setRaisonRejetApprobation($raisonRejetApprobation);
            $demande->setStatut('Rejeté');
    
            // Récupère l'utilisateur connecté
            $user = $this->getUser();
    
            // Vérifie le rôle de l'utilisateur connecté et met à jour l'entité Demande en conséquence
            if ($this->isGranted('ROLE_CHEF_PARC')) {
                $demande->setTraiterPar($user);
            } elseif ($this->isGranted('ROLE_RESPONSABLE_STRUCTURE')) {
                $demande->setValidateurStructure($user);
            }
    
            $this->entityManager->flush();
    
            $this->addFlash('success', 'Demande rejetée avec succès.');
        }
    
        return $this->redirectToRoute('demande.rejetees');
    }


    #[Route('/{id}/traiter', name: 'demande.traiter', methods: ['POST'])]
    #[IsGranted('ROLE_CHEF_PARC')]
    public function traiter(Request $request, EntityManagerInterface $em, $id): Response
    {
        // Récupérer l'utilisateur actuel
        $currentUser = $this->getUser();
    
        // Vérifier si l'utilisateur a le rôle ROLE_ADMIN
        if ($this->isGranted('ROLE_ADMIN', $currentUser)) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas accéder à cette ressource.');
        }
    
        // Récupérer l'identifiant de la demande depuis l'URL
        $demandeId = $id;
    
        // Récupérer l'observation et les paires véhicule-chauffeur depuis la requête POST
        $observation = $request->request->get('observation');
        $pairsJson = $request->request->get('pairs');
        $pairs = json_decode($pairsJson, true); // Convertir le JSON en tableau associatif
    
        // Validation des paramètres
        if (!$demandeId || empty($pairs)) {
            return $this->json(['success' => false, 'message' => 'Paramètres manquants ou invalides'], 400);
        }
    
        // Récupérer la demande depuis la base de données
        $demande = $em->getRepository(Demande::class)->find($demandeId);
        if (!$demande) {
            return $this->json(['success' => false, 'message' => 'Demande introuvable'], 404);
        }
    
        if ($demande->getStatut() != 'Approuvé') {
            return $this->json(['success' => false, 'message' => 'Vous ne pouvez traiter une demande que si son statut est "Approuvé".'], 400);
        }
    
        try {
            // Mettre à jour les champs de la demande
            $demande->setStatut('Validé');
            $demande->setTraiterPar($currentUser);
            $demande->setDateTraitement(new \DateTimeImmutable());
            $demande->setObservations($observation);
    
            foreach ($pairs as $pair) {
                $vehiculeId = $pair['vehiculeId'];
                $chauffeurId = $pair['chauffeurId'];
    
                $vehicule = $em->getRepository(Vehicule::class)->find($vehiculeId);
                $chauffeur = $em->getRepository(Chauffeur::class)->find($chauffeurId);
    
                if ($vehicule && $chauffeur) {
                    // Associer le véhicule et le chauffeur à la demande traitée
                    $traiterDemande = new Affecter();
                    $traiterDemande->setDemande($demande);
                    $traiterDemande->setVehicule($vehicule);
                    $traiterDemande->setChauffeur($chauffeur);
    
                    $em->persist($traiterDemande);
                } else {
                    return $this->json(['success' => false, 'message' => 'Véhicule ou chauffeur introuvable'], 400);
                }
            }
    
            // Enregistrer les modifications dans la base de données
            $em->persist($demande);
            $em->flush();
    
            return $this->json(['success' => true, 'message' => 'Demande traitée avec succès']);
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    



    #[Route('/{id}', name: 'demande.delete', methods: ['POST'])]
    #[IsGranted('ROLE_POINT_FOCAL')]
    public function delete(Request $request, Demande $demande): Response
    {
        $currentUser = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN', $currentUser)) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas accéder à cette ressource.');
        }

        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->request->get('_token'))) {
            if ($demande->getStatut() !== 'Initial') {
                $this->addFlash('error', 'Vous ne pouvez supprimer une demande que si son statut est "Initial".');
            } else {
                $demande->setDeleteAt(new \DateTimeImmutable());
                $this->entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            }
        }

        return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/api/available-vehicles-and-drivers', name: 'api_available_vehicles_and_drivers', methods: ['POST'])]
    #[IsGranted('ROLE_CHEF_PARC')]
    public function availableVehiclesAndDrivers(): JsonResponse
    {
        // Récupérez l'utilisateur connecté
        $currentUser = $this->getUser();
    
        if (!$currentUser instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
        }
    
        if ($this->isGranted('ROLE_ADMIN', $currentUser)) {
            return new JsonResponse(['error' => 'Accès refusé.'], 403);
        }
    
        // Récupérez l'institution de l'utilisateur
        $institution = $currentUser->getInstitution();
    
        // Vérifiez si l'institution existe pour l'utilisateur connecté
        if (!$institution) {
            throw new \RuntimeException('L\'utilisateur n\'a pas d\'institution associée.');
        }
    
        // Récupérez l'ID de l'institution
        $institutionId = $institution->getId();
    
        // Récupérez les véhicules disponibles dans l'institution de l'utilisateur avec deleteAt non nul
        $vehicles = $this->entityManager->getRepository(Vehicule::class)->createQueryBuilder('v')
            ->where('v.institution = :institutionId')
            ->andWhere('v.disponibilite = :disponibilite')
            ->andWhere('v.deleteAt IS NULL')
            ->setParameter('institutionId', $institutionId)
            ->setParameter('disponibilite', 'Disponible')
            ->getQuery()
            ->getResult();
    
        // Récupérez les chauffeurs disponibles dans l'institution de l'utilisateur avec deleteAt non nul
        $drivers = $this->entityManager->getRepository(Chauffeur::class)->createQueryBuilder('c')
            ->where('c.institution = :institutionId')
            ->andWhere('c.disponibilite = :disponibilite')
            ->andWhere('c.deleteAt IS NULL')
            ->setParameter('institutionId', $institutionId)
            ->setParameter('disponibilite', 'Disponible')
            ->getQuery()
            ->getResult();
    
        // Formattez les données pour la réponse JSON
        $formattedVehicles = array_map(function($vehicle) {
            return [
                'id' => $vehicle->getId(),
                'matricule' => $vehicle->getMatricule()
            ];
        }, $vehicles);
    
        $formattedDrivers = array_map(function($driver) {
            return [
                'id' => $driver->getId(),
                'name' => $driver->getNomChauffeur() . ' ' . $driver->getPrenomChauffeur()
            ];
        }, $drivers);
    
        // Retournez les données en JSON
        return $this->json([
            'vehicles' => $formattedVehicles,
            'drivers' => $formattedDrivers,
        ]);
    }

    #[Route('/{id}/etat', name: 'demande.etat')]
    public function etatDemande($id): Response
    {
        // Récupération de l'utilisateur connecté
        /** @var \App\Entity\User $currentUser */
        $currentUser = $this->getUser();
        if (!$currentUser instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
        }   

        $userInstitution = $currentUser->getInstitution();   
        if (!$userInstitution) {
            throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
        }
        $institutionId = $userInstitution ? $userInstitution->getId() : null;
        $userStructure = $currentUser->getStructure();
        if (!$userStructure) {
            throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune structure');
        }
        $structureId = $userStructure ? $userStructure->getId() : null;
        $demande = $this->demandeRepository->find($id);
        if (!$demande) {
            throw $this->createNotFoundException('Demande introuvable');
        }
        $affectations = $this->affecterRepo->findBy(['demande' => $demande]);

        $institution = $this->institutionRepository->find($institutionId);

        if (!$institution) {
            throw $this->createNotFoundException('Institution not found');
        }

        return $this->render('demande/etat.html.twig', [
            'demande' => $demande,
            'affectations' => $affectations,
        ]);
    }


    #[Route('/demande/{id}/pdf', name: 'demande_pdf')]
    public function generatePdf(int $id): Response
    {
        // Récupérer les données nécessaires
        $demande = $this->demandeRepository->find($id);
        if (!$demande) {
            throw $this->createNotFoundException('Demande introuvable');
        }
        $affectations = $this->affecterRepo->findBy(['demande' => $demande]);

        // Générer le contenu HTML
        $html = $this->renderView('demande/etat.html.twig', [
            'demande' => $demande,
            'affectations' => $affectations,
        ]);

        // Générer le PDF avec options
        $pdfOptions = [
            'no-outline' => true,        // Éviter les contours par défaut
            'disable-smart-shrinking' => true,  // Éviter le rétrécissement intelligent
            'margin-top' => '10mm',       // Marges pour le PDF
            'margin-right' => '10mm',
            'margin-bottom' => '10mm',
            'margin-left' => '10mm',
        ];

        try {
            $pdfContent = $this->knpSnappy->getOutputFromHtml($html, $pdfOptions);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('Erreur lors de la génération du PDF: ' . $e->getMessage());
        }

        // Retourner le PDF en réponse
        return new Response(
            $pdfContent,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="demande_'.$id.'.pdf"',
            ]
        );
    }


    #[Route('/test/pdf', name: 'test_pdf')]
    public function testPdf(): Response
    {
        $html = '<h1>Test PDF</h1>';
        $pdfContent = $this->knpSnappy->getOutputFromHtml($html);

        return new Response(
            $pdfContent,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="test.pdf"',
            ]
        );
    }



    public function renderBaseView(DemandeService $demandeService): Response
    {
        $nombreDemandes = 0; // Valeur par défaut

        try {
            // Obtenez le nombre de demandes validées
            $nombreDemandes = $demandeService->getNombreDemandesValidees();
        } catch (RuntimeException $e) {
            // Vous pouvez loguer l'erreur ou gérer le message d'erreur ici
            $this->addFlash('error', 'Erreur lors de la récupération des demandes.');
        }

        // Rendre le template avec les données
        return $this->render('base.html.twig', [
            'nombreDemandes' => $nombreDemandes,
        ]);
    }

   

}


