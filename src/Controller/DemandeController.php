<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Snappy\Pdf;
use App\Entity\User;
use RuntimeException;
use App\Entity\Commune;
use App\Entity\Demande;
use App\Entity\Affecter;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Form\DemandeType;
use App\Entity\TamponAffecter;
use App\Service\DemandeService;
use App\Repository\ParcRepository;
use App\Repository\UserRepository;
use App\Repository\DemandeRepository;
use Symfony\Component\Form\FormError;
use App\Repository\AffecterRepository;
use App\Repository\ChauffeurRepository;
use App\Repository\StructureRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InstitutionRepository;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\TamponAffecterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


#[Route('/demande')]
class DemandeController extends AbstractController
{
    private $knpSnappy;
    private $entityManager;
    private $demandeRepository;
    private $institutionRepository;
    private $affecterRepo;

    public function __construct(Pdf $knpSnappy, InstitutionRepository $institutionRepository,  AffecterRepository $affecterRepo, DemandeRepository $demandeRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->demandeRepository = $demandeRepository;

        $this->institutionRepository = $institutionRepository;
        $this->affecterRepo = $affecterRepo;

        $this->knpSnappy = $knpSnappy;

    }

    #[Route('/', name: 'demande.index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository, StructureRepository $structureRepository, ParcRepository $parcRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }

        $roles = $user->getRoles();

        if ((in_array('ROLE_POINT_FOCAL', $roles, true) || in_array('ROLE_POINT_FOCAL_AVANCE', $roles, true) ) && (!in_array('ROLE_ADMIN', $roles, true))) {
            $demandes = $demandeRepository->findPointFocalDemandesInitiales($user);

        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $structure = $user->getStructure();  // Récupération de la structure de l'utilisateur connecté 
            $demandes = $demandeRepository->findApprobateurDemandesEnAttente($structure);   // Récupération des demandes associées à cette structure

        } elseif (in_array('ROLE_CHEF_PARC', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $structuresFinales = []; // Initialisation du tableau pour accumuler les structures
            $parcs = $parcRepository->findByChefParc($user->getId());

            if (!empty($parcs)) {
                // Récupérer toutes les structures associées aux parcs
                foreach ($parcs as $parc) {
                    $structuresParc = $structureRepository->findStructuresByParc($parc);
                    $structuresFinales = array_merge($structuresFinales, $structuresParc);
                }
            }

            // Récupérer toutes les demandes associées aux structures finales
            $demandes = [];
            if (!empty($structuresFinales)) {
                foreach ($structuresFinales as $structure) {
                    if ($structure) {
                        $structuresDemandes = $demandeRepository->findChefParcDemandesEnAttente($structure);
                        $demandes = array_merge($demandes, $structuresDemandes);
                    }
                }
            }  
        } elseif (in_array('ROLE_VALIDATEUR', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $structuresFinales = []; // Initialisation du tableau pour accumuler les structures
            $parcs = $parcRepository->findByValidateur($user->getId());
            dump($parcs);
            if (!empty($parcs)) {
                // Récupérer toutes les structures associées aux parcs
                foreach ($parcs as $parc) {
                    $structuresParc = $structureRepository->findStructuresByParc($parc);
                    $structuresFinales = array_merge($structuresFinales, $structuresParc);
                }
            }
            

            // Récupérer toutes les demandes associées aux structures finales
            $demandes = [];
            if (!empty($structuresFinales)) {
                foreach ($structuresFinales as $structure) {
                    if ($structure) {
                        $structuresDemandes = $demandeRepository->findValidateurDemandesEnAttente($structure);
                        $demandes = array_merge($demandes, $structuresDemandes);
                    }
                }
            }  

        } else {
            $institution = $user->getInstitution();
            $demandes = $demandeRepository->findAllDemandesForOneInstitution($institution);
        }

        return $this->render('demande/index.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,

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
 
// Ici on affiche la liste des demandes rejetées

    #[Route('/demandes/rejetees', name: 'demande.rejetees', methods: ['GET'])]
    public function rejetees(DemandeRepository $demandeRepository, StructureRepository $structureRepository, ParcRepository $parcRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }
        $roles = $user->getRoles();

        if ((in_array('ROLE_POINT_FOCAL', $roles, true) || in_array('ROLE_POINT_FOCAL_AVANCE', $roles, true) ) && (!in_array('ROLE_ADMIN', $roles, true))) {
            $demandes = $demandeRepository->findBy([
                'demander' => $user,
                'statut' => 'Rejeté',
            ]);
        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
            $demandes = $demandeRepository->findBy([
                'validateurStructure' => $user,
                'statut' => 'Rejeté',
            ]);
        }elseif (in_array('ROLE_CHEF_PARC', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true))) {
            $demandes = $demandeRepository->findBy([
                'traiterPar' => $user,
                'statut' => 'Rejeté',
            ]);
              
        } elseif (in_array('ROLE_CHEF_PARC', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true))) {
            $demandes = $demandeRepository->findBy([
                'traiterPar' => $user,
                'statut' => 'Rejeté',
            ]);
              
        } elseif (in_array('ROLE_VALIDATEUR', $roles, true)) {
            $demandes = $demandeRepository->findBy([
                'validatedBy' => $user,
                'statut' => 'Rejeté',
            ]);            
        } else {
            $institution = $user->getInstitution();
            $demandes = $demandeRepository->findBy([
                'institution' => $institution,
                'statut' => 'Rejeté'
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
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }

        $roles = $user->getRoles();

        if ((in_array('ROLE_POINT_FOCAL', $roles, true) || in_array('ROLE_POINT_FOCAL_AVANCE', $roles, true) ) && (!in_array('ROLE_ADMIN', $roles, true))) {
            $demandes = $demandeRepository->findPointFocalDemandesApprouveesByResponsable($user);

        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $structure = $user->getStructure();  // Récupération de la structure de l'utilisateur connecté 
            $demandes = $demandeRepository->findDemandesApprouveesByResponsable($user);   // Récupération des demandes associées à cette structure

        } elseif (in_array('ROLE_CHEF_PARC', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $demandes = []; // Initialisation du tableau pour accumuler les demandes            
            $parc = $user->getStructure()->getParc();   // Récupération du parc du chef de parc          
            $structures = $parc->getStructure();        // Récupération des structures associées à ce parc

            // Parcourir chaque structure pour récupérer les demandes
            foreach ($structures as $structure) {
                $structuresdemandes = $demandeRepository->findChefParcDemandesEnAttente($structure);                
                $demandes = array_merge($demandes, $structuresdemandes);   // Ajouter ces demandes au tableau accumulatif
            }

        } elseif (in_array('ROLE_VALIDATEUR', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $demandes = []; // Initialisation du tableau pour accumuler les demandes            
            $parc = $user->getStructure()->getParc();  // Récupération du parc du chef de parc            
            $structures = $parc->getStructure();       // Récupération des structures associées à ce parc

            // Parcourir chaque structure pour récupérer les demandes
            foreach ($structures as $structure) {
                $structuresdemandes = $demandeRepository->findChefParcDemandesEnAttente($structure);                
                $demandes = array_merge($demandes, $structuresdemandes);   // Ajouter ces demandes au tableau accumulatif
            }

        } else {
            $institution = $user->getInstitution();
            $demandes = $demandeRepository->findAllDemandesApprouveesForOneInstitution($institution);
        }

        return $this->render('demande/approuvees.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
        ]);
    }

    // Ici fin affichage de la liste des demandes approuvées


    // Ici on affiche la liste des demandes traitées
    #[Route('/traitees', name: 'demande.traitees', methods: ['GET'])]
    public function traitees(DemandeRepository $demandeRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }

        $roles = $user->getRoles();

        if ((in_array('ROLE_POINT_FOCAL', $roles, true) || in_array('ROLE_POINT_FOCAL_AVANCE', $roles, true) ) && (!in_array('ROLE_ADMIN', $roles, true))) {
            $demandes = $demandeRepository->findPointFocalDemandesTraiteesByChefParc($user);

        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $structure = $user->getStructure();  // Récupération de la structure de l'utilisateur connecté 
            $demandes = $demandeRepository->findDemandesApprouveesByResponsableAndTraiteByChefParc($user);   // Récupération des demandes associées à cette structure

        } elseif (in_array('ROLE_CHEF_PARC', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $demandes = $demandeRepository->findDemandesTraiteesByChefParc($user);   

        } elseif (in_array('ROLE_VALIDATEUR', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $demandes = []; // Initialisation du tableau pour accumuler les demandes            
            $parc = $user->getStructure()->getParc();  // Récupération du parc du chef de parc            
            $structures = $parc->getStructure();       // Récupération des structures associées à ce parc

            // Parcourir chaque structure pour récupérer les demandes
            foreach ($structures as $structure) {
                $structuresdemandes = $demandeRepository->findValidateurDemandesEnAttente($structure);                
                $demandes = array_merge($demandes, $structuresdemandes);   // Ajouter ces demandes au tableau accumulatif
            }
        } else {
            $institution = $user->getInstitution();
            $demandes = $demandeRepository->findAllDemandesTraiteesForOneInstitution($institution);
        }

        return $this->render('demande/traitees.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
            'type' => 'traitees'
        ]);
    }

    // Ici fin affichage de la liste des demandes traitées

    // Ici on affiche la liste des demandes validées
    #[Route('/validees', name: 'demande.validees', methods: ['GET'])]
    public function validees(DemandeRepository $demandeRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }

        $roles = $user->getRoles();

        if ((in_array('ROLE_POINT_FOCAL', $roles, true) || in_array('ROLE_POINT_FOCAL_AVANCE', $roles, true) ) && (!in_array('ROLE_ADMIN', $roles, true))) {
            $demandes = $demandeRepository->findPointFocalDemandesValideesByValidateur($user);            
        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $structure = $user->getStructure();  // Récupération de la structure de l'utilisateur connecté 
            $demandes = $demandeRepository->findDemandesApprouveesByResponsableAndValideesByValidateur($user);   // Récupération des demandes associées à cette structure

        } elseif (in_array('ROLE_CHEF_PARC', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $demandes = $demandeRepository->findDemandesTraiteesByChefParcValideesByValidateur($user);   

        } elseif (in_array('ROLE_VALIDATEUR', $roles, true) && (!in_array('ROLE_ADMIN', $roles, true)) ) {
            $demandes = []; // Initialisation du tableau pour accumuler les demandes            
            $parc = $user->getStructure()->getParc();  // Récupération du parc du chef de parc            
            $structures = $parc->getStructure();       // Récupération des structures associées à ce parc

            // Parcourir chaque structure pour récupérer les demandes
            foreach ($structures as $structure) {
                $structuresdemandes = $demandeRepository->findDemandesValideesByValidateur($structure);                
                $demandes = array_merge($demandes, $structuresdemandes);   // Ajouter ces demandes au tableau accumulatif
            }
        } else {
            $institution = $user->getInstitution();
            $demandes = $demandeRepository->findAllDemandesValideesForOneInstitution($institution);
        }

        return $this->render('demande/traitees.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
            'type' => 'traitees'
        ]);
    }

    // Ici fin affichage de la liste des demandes validées


    // Ici début création demandes

    #[Route('/new', name: 'demande.create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_POINT_FOCAL')]
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }


        // Vérifie si l'utilisateur a le rôle ROLE_POINT_FOCAL mais pas le rôle ROLE_ADMIN
        if (!$this->isGranted('ROLE_POINT_FOCAL') || $this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à accéder à cette ressource.');
            return $this->redirectToRoute('app_login');
        }
        
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { // Vérifie si le formulaire est soumis et valide
            // Vérifiez si l'utilisateur a le rôle ROLE_POINT_FOCAL_AVANCE
            if ($this->isGranted('ROLE_POINT_FOCAL_AVANCE') && !$this->isGranted('ROLE_ADMIN')) {
                $vehicules = $form->get('vehicules')->getData();
                $chauffeurs = $form->get('chauffeurs')->getData();
                $nbreVehicules = $form->get('nbreVehicules')->getData();
                
                // Vérifier si le nombre de véhicules et de chauffeurs est égal
                if (count($vehicules) !== count($chauffeurs)) {
                    // Ajouter une erreur au champ 'vehicules'
                    $form->get('vehicules')->addError(new FormError('Le nombre de véhicules sélectionnés doit être égal au nombre de chauffeurs sélectionnés.'));
                }


                // Validation : le nombre de véhicules sélectionnés ne doit pas dépasser nbreVehicules
                if (!empty($vehicules) && count($vehicules) > $nbreVehicules) {
                    $form->get('vehicules')->addError(new FormError('Le nombre de véhicules sélectionnés ne doit pas dépasser le nombre de véhicules saisi dans le champ "Nombre de véhicules".'));
                }
            }

            $nbreParticipants = $form->get('nbreParticipants')->getData();
            $nbreVehicules = $form->get('nbreVehicules')->getData();

            // Validation : nbreVehicules doit être inférieur ou égal à nbreParticipants
            if ($nbreVehicules > $nbreParticipants) {
                $form->get('nbreVehicules')->addError(new FormError('Le nombre de véhicules doit être inférieur ou égal au nombre de participants.'));
            }elseif ($form->isValid()) {    
                $structure = $user->getStructure();
                $institution = $user->getInstitution();
                $demande->setStructure($structure);
                $demande->setInstitution($institution);
                $demande->setDemander($user);

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
/*         else {
            // Si le formulaire n'est pas valide, récupérer les erreurs
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        } */

        return $this->render('demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(), // Assurez-vous d'appeler createView()
        ]);
    }


    #[Route('/{id}', name: 'demande.show', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(Demande $demande, ChauffeurRepository $chauffeurRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $demande = $entityManager->getRepository(Demande::class)->find($id);
    
        if (!$demande) {
            $this->addFlash('error', 'Demande introuvable.');
            return $this->redirectToRoute('app_login');
        }

        $chauffeurs = [];    
        foreach ($demande->getChauffeurs() as $matricule) {
            $chauffeur = $chauffeurRepository->findOneBy(['matriculeChauffeur' => $matricule]);
            if ($chauffeur) {
                $chauffeurs[] = $chauffeur;
            }
        }
    
        // Vérification des conditions
        if ($demande->getAffecters()->count() > 0 &&
            ($demande->getStatut() === 'Traité') &&
            $demande->getDateTraitement() !== null)
        {
            $details = $entityManager->getRepository(Affecter::class)->findBy(['demande' => $demande]);
   
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
            'chauffeurs' => $chauffeurs, // Passez la liste des objets Chauffeur au template
        ]);
    }

    #[Route('/{id}/edit', name: 'demande.edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_POINT_FOCAL')]
    public function edit(Request $request, Demande $demande): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }
    
        // Vérifier si le statut de la demande est 'Initial'
        if ($demande->getStatut() !== 'Initial') {
            $this->addFlash('error', 'Vous ne pouvez modifier une demande que si son statut est "Initial".');
            return $this->redirectToRoute('demande.index');
        }
    
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifiez si l'utilisateur a le rôle ROLE_POINT_FOCAL_AVANCE
            if ($this->isGranted('ROLE_POINT_FOCAL_AVANCE') && !$this->isGranted('ROLE_ADMIN')) {
                $vehicules = $form->get('vehicules')->getData();
                $chauffeurs = $form->get('chauffeurs')->getData();
                $nbreVehicules = $form->get('nbreVehicules')->getData();
    
                // Vérifier si le nombre de véhicules et de chauffeurs est égal
                if (count($vehicules) !== count($chauffeurs)) {
                    $form->get('vehicules')->addError(new FormError('Le nombre de véhicules sélectionnés doit être égal au nombre de chauffeurs sélectionnés.'));
                }
    
                // Validation : le nombre de véhicules sélectionnés ne doit pas dépasser nbreVehicules
                if (!empty($vehicules) && count($vehicules) > $nbreVehicules) {
                    $form->get('vehicules')->addError(new FormError('Le nombre de véhicules sélectionnés ne doit pas dépasser le nombre de véhicules saisi dans le champ "Nombre de véhicules".'));
                }
            }
    
            $nbreParticipants = $form->get('nbreParticipants')->getData();
            $nbreVehicules = $form->get('nbreVehicules')->getData();
    
            // Validation : nbreVehicules doit être inférieur ou égal à nbreParticipants
            if ($nbreVehicules > $nbreParticipants) {
                $form->get('nbreVehicules')->addError(new FormError('Le nombre de véhicules doit être inférieur ou égal au nombre de participants.'));
            }
    
            // Si le formulaire reste valide après les validations
            if ($form->isValid()) {
                $this->entityManager->flush();
                $this->addFlash('success', 'Modification effectuée avec succès.');
                return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
            }
        }
    
        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(), // Assurez-vous d'appeler createView()
        ]);
    }



    #[Route('/{id}/cancel', name: 'demande.cancel', methods: ['GET', 'POST'])]
    public function cancel(Request $request, DemandeRepository $demandeRepository, Demande $demande): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }
    
        // Vérification du rôle de l'utilisateur
        if ($this->isGranted('ROLE_POINT_FOCAL') && !$this->isGranted('ROLE_ADMIN')) {
            // Vérification du statut de la demande
            if ($demande->getStatut() == 'Initial') {
                // Récupérer la raison de l'annulation
                $reason = $request->request->get('reason');
                if ($reason) {
                    $demande->setStatut('Annulé');
                    $demande->setCancelledBy($user);
                    $demande->setCancellationReason($reason); // Assurez-vous que ce champ existe
                    $demande->setCancellationDate(new \DateTimeImmutable());
                    $this->entityManager->flush();
                    $this->addFlash('success', 'Demande annulée avec succès.');
                    return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
                } else {
                    $this->addFlash('warning', 'La raison de l\'annulation est obligatoire.');
                }
            } else {
                $this->addFlash('warning', 'Vous ne pouvez pas annuler cette demande. Formulez une demande d\'annulation.');
            }
        }
    
        return $this->redirectToRoute('demande.index'); // Rediriger en cas de problème
    }


    #[Route('/{id}/approve', name: 'demande.approve', methods: ['GET', 'POST'])]
    public function approve(Demande $demande): Response
    {
        $user = $this->getUser();
    
        // Vérifie que l'utilisateur a le rôle ROLE_RESPONSABLE_STRUCTURE mais pas le rôle ROLE_ADMIN
        if (!$this->isGranted('ROLE_RESPONSABLE_STRUCTURE') || $this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à avoir accès à cette ressource.');
            return $this->redirectToRoute('app_login');            
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
    public function dismiss(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }
        
        $roles = $user->getRoles();

        if (!(in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true) || in_array('ROLE_CHEF_PARC', $roles, true) || in_array('ROLE_VALIDATEUR', $roles, true)) ) {        
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à avoir accès à cette ressource.');
            return $this->redirectToRoute('app_login');
        } elseif (in_array('ROLE_ADMIN', $roles, true)) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à avoir accès à cette ressource.');
            return $this->redirectToRoute('app_login');
        }
    
        if ($request->isMethod('POST')) {
            $user = $this->getUser();
            if (!$user instanceof User) {
                $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
                return $this->redirectToRoute('app_login');
            }
            
            $roles = $user->getRoles();
            $raisonRejetApprobation = $request->request->get('raisonRejetApprobation');
            $demande->setRaisonRejetApprobation($raisonRejetApprobation);
            $demande->setStatut('Rejeté');
    
            // Vérifie le rôle de l'utilisateur connecté et met à jour l'entité Demande en conséquence
            if (in_array('ROLE_CHEF_PARC', $roles, true)) {
                $demande->setTraiterPar($user);
                $demande->setDateTraitement(new \DateTimeImmutable());
            } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles, true)) {
                $demande->setValidateurStructure($user);
                $demande->setdateApprobation(new \DateTimeImmutable());
            } elseif (in_array('ROLE_VALIDATEUR', $roles, true)) {
                $demande->setValidatedBy($user);                
                $demande->setValidatedAt(new \DateTimeImmutable());  
                $demandeId = $demande ? $demande->getId() : null;                
                $affecters = $entityManager->getRepository(Affecter::class)->findBy([            
                    'demande' => $demandeId
                ]);

                // Parcourir chaque enregistrement trouvé et mettre à jour le champ 'statut'
                foreach ($affecters as $affecter) {
                    $affecter->setStatut('Rejeté');
                    $affecter->setDateDebutMission(null);
                    $affecter->setDateFinMission(null);
                }
            }    
            $this->entityManager->flush();
    
            $this->addFlash('success', 'Demande rejetée avec succès.');
        }
    
        return $this->redirectToRoute('demande.rejetees');
    }


    #[Route('/valider/{id}', name: 'demande_valider', methods: ['POST'])]
    #[IsGranted('ROLE_VALIDATEUR')]
    public function traiter(Request $request, EntityManagerInterface $em, $id): Response
    {
        // Récupérer l'utilisateur actuel
        $user = $this->getUser();
        if (!$user instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }

        $roles = $user->getRoles();
        
        // Vérifier si l'utilisateur a le rôle ROLE_ADMIN
        if (!in_array('ROLE_VALIDATEUR', $roles, true) || (in_array('ROLE_ADMIN', $roles, true)) ) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à avoir accès à cette ressource.');
            return $this->redirectToRoute('app_login');
        }
        
        // Récupérer l'identifiant de la demande depuis l'URL
        $demandeId = $id;
        
        // Validation des paramètres
        if (!$demandeId) {
            $this->addFlash('error', 'Paramètres manquants ou invalides');
            return $this->redirectToRoute('demande.validees');
        }

        // Récupérer la demande depuis la base de données
        $demande = $em->getRepository(Demande::class)->find($demandeId);
        if (!$demande) {
            return $this->json(['success' => false, 'message' => 'Demande introuvable'], 404);
        }
        
        if ($demande->getStatut() != 'Traité') {
            $this->addFlash('error', 'Demande introuvable');
            return $this->redirectToRoute('demande.validees');
        }
        
        try {
            // Mettre à jour les champs de la demande
            $demande->setStatut('Validé');
            $demande->setValidatedBy($user);
            $demande->setValidatedAt(new \DateTimeImmutable());
            $affecters = $em->getRepository(Affecter::class)->findBy([            
                'demande' => $demandeId
            ]);

            // Parcourir chaque enregistrement trouvé et mettre à jour le champ 'statut'
            foreach ($affecters as $affecter) {
                $affecter->setStatut('Validé');
            }
            
            // Enregistrer les modifications dans la base de données
            $em->persist($demande);
            $em->flush();
            
            // Ajouter un message flash et rediriger vers la route demande.validees
            $this->addFlash('success', 'Demande traitée avec succès');
            return $this->redirectToRoute('demande.validees');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors du traitement de la demande : ' . $e->getMessage());
                return $this->redirectToRoute('demande.validees');
            }
    }
    
    



    #[Route('/{id}', name: 'demande.delete', methods: ['POST'])]
    #[IsGranted('ROLE_POINT_FOCAL')]
    public function delete(Request $request, Demande $demande): Response
    {
        $currentUser = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN', $currentUser)) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à avoir accès à cette ressource.');
            return $this->redirectToRoute('app_login');
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


    #[Route('/{id}/etat', name: 'demande.etat')]
    public function etatDemande($id): Response
    {
        // Récupération de l'utilisateur connecté
        /** @var \App\Entity\User $currentUser */
        $currentUser = $this->getUser();
        if (!$currentUser instanceof User) {
            $this->addFlash('error', 'L\'utilisateur n\'est pas connecté');
            return $this->redirectToRoute('app_login');
        }   

        $userInstitution = $currentUser->getInstitution();   
        if (!$userInstitution) {
            $this->addFlash('error', 'Cet utilisateur n\'est associé à aucune institution');
            return $this->redirectToRoute('app_login');
        }
        
        $institutionId = $userInstitution ? $userInstitution->getId() : null;
        $userStructure = $currentUser->getStructure();
        if (!$userStructure) {
            $this->addFlash('error', 'Cet utilisateur n\'est associé à aucune structure');
            return $this->redirectToRoute('app_login');
        }
        $structureId = $userStructure ? $userStructure->getId() : null;
        $demande = $this->demandeRepository->find($id);
        if (!$demande) {
            $this->addFlash('error', 'Demande introuvable');
            return $this->redirectToRoute('app_login');
        }
        $affectations = $this->affecterRepo->findBy(['demande' => $demande]);

        $institution = $this->institutionRepository->find($institutionId);

        if (!$institution) {
            $this->addFlash('error', 'Cet utilisateur n\'est associé à aucune institution');
            return $this->redirectToRoute('app_login');
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
            $this->addFlash('error', 'Demande introuvable');
            return $this->redirectToRoute('app_login');
        }
        $affectations = $this->affecterRepo->findBy(['demande' => $demande]);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        // Générer le contenu HTML
        $html = $this->renderView('demande/etat.html.twig', [
            'demande' => $demande,
            'affectations' => $affectations,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return new Response($dompdf->stream("demande.pdf",["Attachment" => false]));

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


