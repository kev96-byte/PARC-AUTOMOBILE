<?php

namespace App\Controller;

use Date;
use DateTime;
use App\Entity\User;
use App\Entity\Commune;
use App\Entity\Demande;
use App\Entity\Affecter;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Form\DemandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/demande')]
class DemandeController extends AbstractController
{
    private $entityManager;
    private $security;
    private $serializer;

    public function __construct(Security $security, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }




    #[Route('/', name: 'demande.index', methods: ['GET'])]
    public function index(): Response
    {

        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur nest pas connecté');
        }

        if (in_array('ROLE_POINT_FOCAL', $roles)) {
            $demandes = $this->entityManager->getRepository(Demande::class)->findBy([
                'demander' => $user,
                'deleteAt' => null,
            ]);
        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles)) {
            $structure = $user->getStructure();
            // Vérifier si la structure existe
            if (!$structure) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune structure');
            }

            $structureId = $structure->getId();

            $institution = $user->getInstitution();
            if (!$institution) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
            }

            $institutionId = $institution->getId();

            $demandes = $this->entityManager->getRepository(Demande::class)->createQueryBuilder('d')
                ->join('d.demander', 'u')
                ->join('u.structure', 's')
                ->join('u.institution', 'i')
                ->where('s.id = :structureId')
                ->andWhere('i.id = :institutionId')
                ->andWhere('d.deleteAt IS NULL')
                ->setParameter('structureId', $structureId)
                ->setParameter('institutionId', $institutionId)
                ->getQuery()
                ->getResult();

        }  elseif (in_array('ROLE_CABINET', $roles)) {
            $institution = $user->getInstitution();
            if (!$institution) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
            }

            $institutionId = $institution->getId();

            $demandes = $this->entityManager->getRepository(Demande::class)->createQueryBuilder('d')
                ->join('d.demander', 'u')
                ->join('u.institution', 'i')
                ->where('i.id = :institutionId')
                ->andWhere('d.deleteAt IS NULL')
                ->setParameter('institutionId', $institutionId)
                ->getQuery()
                ->getResult();

        }elseif (in_array('ROLE_CHEF_PARC', $roles)) {
            $institution = $user->getInstitution();
            if (!$institution) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
            }

            $institutionId = $institution->getId();

            $demandes = $this->entityManager->getRepository(Demande::class)
                ->createQueryBuilder('d')
                ->join('d.demander', 'u')
                ->join('u.institution', 'i')
                ->where('i.id = :institutionId')
                ->andWhere('d.deleteAt IS NULL')
                ->andWhere('(d.statut = :statutApprouve OR d.statut = :statutValide OR (d.statut = :statutRejete AND d.traitePar IS NOT NULL))')
                ->setParameter('institutionId', $institutionId)
                ->setParameter('statutApprouve', 'Approuvé')
                ->setParameter('statutValide', 'Validé')
                ->setParameter('statutRejete', 'Rejeté')
                ->getQuery()
                ->getResult();
        } elseif (in_array('ROLE_ADMIN', $roles)) {
            $demandes = $this->entityManager->getRepository(Demande::class)->findBy(['deleteAt' => null,]);
        } else {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette ressource.');
        }

        return $this->render('demande/index.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,

        ]);
    }

    #[Route('/demandes/rejetees', name: 'demande.rejetees', methods: ['GET'])]
    public function rejetees(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
        }

        if (in_array('ROLE_CHEF_PARC', $roles)) {
            $institution = $user->getInstitution();
            if (!$institution) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
            }

            $institutionId = $institution->getId();

            $demandes = $this->entityManager->getRepository(Demande::class)
                ->createQueryBuilder('d')
                ->join('d.demander', 'u')
                ->join('u.institution', 'i')
                ->where('i.id = :institutionId')
                ->andWhere('d.deleteAt IS NULL')
                ->andWhere('d.statut = :statutRejete')
                ->setParameter('institutionId', $institutionId)
                ->setParameter('statutRejete', 'Rejeté')
                ->getQuery()
                ->getResult();
        } elseif (in_array('ROLE_ADMIN', $roles)) {
            $demandes = $this->entityManager->getRepository(Demande::class)->findBy(['deleteAt' => null,]);
    } else {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette ressource.');
        }

        return $this->render('demande/rejetees.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
        ]);
    }

    #[Route('/approuvees', name: 'demande.approuvees', methods: ['GET'])]
    public function approuvees(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
        }

        if (in_array('ROLE_CHEF_PARC', $roles)) {
            $institution = $user->getInstitution();
            if (!$institution) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
            }

            $institutionId = $institution->getId();

            $demandes = $this->entityManager->getRepository(Demande::class)
                ->createQueryBuilder('d')
                ->join('d.demander', 'u')
                ->join('u.institution', 'i')
                ->where('i.id = :institutionId')
                ->andWhere('d.deleteAt IS NULL')
                ->andWhere('d.statut = :statutApprouve')
                ->setParameter('institutionId', $institutionId)
                ->setParameter('statutApprouve', 'Approuvé')
                ->getQuery()
                ->getResult();
        } elseif (in_array('ROLE_ADMIN', $roles)) {
            $demandes = $this->entityManager->getRepository(Demande::class)->findBy(['deleteAt' => null,]);
    } else {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette ressource.');
        }

        return $this->render('demande/approuvees.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
            'type'=>'approuvées'
        ]);
    }

    #[Route('/validees', name: 'demande.validees', methods: ['GET'])]
    public function validees(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
        }

        if (in_array('ROLE_CHEF_PARC', $roles) || in_array('ROLE_POINT_FOCAL', $roles) || in_array('ROLE_RESPONSABLE_STRUCTURE', $roles)) {
            $institution = $user->getInstitution();
            if (!$institution) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
            }

            $institutionId = $institution->getId();

            $demandes = $this->entityManager->getRepository(Demande::class)
                ->createQueryBuilder('d')
                ->join('d.demander', 'u')
                ->join('u.institution', 'i')
                ->where('i.id = :institutionId')
                ->andWhere('d.deleteAt IS NULL')
                ->andWhere('d.statut = :statutValide')
                ->setParameter('institutionId', $institutionId)
                ->setParameter('statutValide', 'Validé')
                ->getQuery()
                ->getResult();

        } elseif (in_array('ROLE_ADMIN', $roles)) {
            $demandes = $this->entityManager->getRepository(Demande::class)->findBy(['deleteAt' => null,]);
    } else {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette ressource.');
        }

        return $this->render('demande/validees.html.twig', [
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
            'type' => 'validées'
        ]);
    }



    #[Route('/new', name: 'demande.create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_POINT_FOCAL')]
    public function new(Request $request): Response
    {

        $communes = $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]);
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->security->getUser();

            if ($user) {
                $demande->setDemander($user);
            } else {
                // Gérer le cas où l'utilisateur n'est pas authentifié
                throw new \Exception('Utilisateur non authentifié');
            }

            // $utilisateur = $entityManager->getRepository(Utilisateur::class)->find(2);


            $communes = $this->entityManager->getRepository(Commune::class)->findBy(['id' => '2']);
            $dateDemandeStr = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
            $dateDemande = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dateDemandeStr);
            $demande->setDateDemande($dateDemande);
            $demande->setStatut('Initial');
            // $demande->setLieuMission(["PORTO-NOVO", "GRAND POPO", "OUIDAH"]);
            $this->entityManager->persist($demande);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');

            return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demande/new.html.twig', [
            'communes' => $communes,
            'demande' => $demande,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'demande.show', methods: ['GET'])]
    public function show(Demande $demande, EntityManagerInterface $entityManager, $id): Response
    {
        $demande = $entityManager->getRepository(Demande::class)->find($id);

        if (!$demande) {
            throw $this->createNotFoundException('Demande introuvable.');
        }

        // Vérification des conditions
        if ($demande->getAffecters()->count() > 0 &&
            // ($demande->getStatut() === 'Validé' || $demande->getStatut() === 'Approuvé') && 
            ($demande->getStatut() === 'Validé') &&
            $demande->getDateTraitement() !== null)
        {
            $details = $entityManager->getRepository(Affecter::class)->findBy(['demandeId' => $demande]);
            dump($details);

            $data = [];
            foreach ($details as $detail) {
                $vehicule = $detail->getVehiculeId();
                $chauffeur = $detail->getChauffeurId();
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
    #[IsGranted('ROLE_RESPONSABLE_STRUCTURE')]
    public function approve(Demande $demande): Response
    {
        if ($demande->getStatut() !== 'Initial') {
            $this->addFlash('error', 'Vous ne pouvez approuver une demande que si son statut est "Initial".');
            return $this->redirectToRoute('demande.index');
        } else {
            // Récupère l'utilisateur connecté
            $user = $this->getUser();
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
        } else {
            if ($request->isMethod('POST')) {
                $raisonRejetApprobation = $request->request->get('raisonRejetApprobation');
                $useroperation = $request->request->get('useroperation');
                $demande->setRaisonRejetApprobation($raisonRejetApprobation);
                $demande->setStatut('Rejeté');

                // Récupère l'utilisateur connecté
                $user = $this->getUser();

                // Vérifie le rôle de l'utilisateur connecté et met à jour l'entité Demande en conséquence
                if ($this->isGranted('ROLE_CHEF_PARC')) {
                    $demande->setTraitePar($user);
                } elseif ($this->isGranted('ROLE_RESPONSABLE_STRUCTURE')) {
                    $demande->setValidateurStructure($user);
                }

                $this->entityManager->flush();

                $this->addFlash('success', 'Demande rejetée avec succès.');
            }

            return $this->redirectToRoute('demande.index');
        }
    }

    #[Route('/{id}/traiter', name: 'demande.traiter', methods: ['POST'])]
    #[IsGranted('ROLE_CHEF_PARC')]
    public function traiter(Request $request, EntityManagerInterface $em, $id): Response
    {
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
            $user = $this->getUser();
            $demande->setStatut('Validé');
            $demande->setTraitePar($user);
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
                    $traiterDemande->setDemandeId($demande);
                    $traiterDemande->setVehiculeId($vehicule);
                    $traiterDemande->setChauffeurId($chauffeur);

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
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->getPayload()->get('_token'))) {
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
    public function availableVehiclesAndDrivers(): JsonResponse
    {

        // Récupérez l'utilisateur connecté
        $currentUser = $this->getUser();

        if (!$currentUser instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur n\'est pas connecté');
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

}