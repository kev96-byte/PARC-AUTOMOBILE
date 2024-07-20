<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Commune;
use App\Entity\Demande;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Entity\TraiterDemande;
use App\Form\TraiterDemandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\TraiterDemandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/traiter/demande')]
class TraiterDemandeController extends AbstractController
{

    private $entityManager;
    private $security;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    
    #[Route('/', name: 'traiterdemande.index', methods: ['GET'])]
    public function index(TraiterDemandeRepository $traiterDemandeRepository): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur nest pas connecté');
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
            ->andWhere('d.statut = :statut OR (d.statut = :statutRejete AND d.traitePar IS NOT NULL)')
            ->setParameter('institutionId', $institutionId)
            ->setParameter('statut', 'Approuvé')
            ->setParameter('statutRejete', 'Rejeté')
            ->getQuery()
            ->getResult();

        }
        return $this->render('traiter_demande/index.html.twig', [
            'traiter_demandes' => $traiterDemandeRepository->findAll(),
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,
        ]);
    }

    #[Route('/{id}', name: 'traiterdemande.show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('traiter_demande/show.html.twig', [
            'chauffeurs' => $this->entityManager->getRepository(Chauffeur::class)->findBy(['deleteAt' => null]),           
            'vehicules' => $this->entityManager->getRepository(Vehicule::class)->findBy(['deleteAt' => null]), 
            'demande' => $demande,
        ]);
    }


    #[Route('/{id}/traiter', name: 'traiterdemande.traiter', methods: ['GET', 'POST'])]

    public function traiter(Request $request, EntityManagerInterface $em): Response
    {
        $demandeId = $request->request->get('traiterdemande_id');
        $demande = $em->getRepository(Demande::class)->find($demandeId);
        if (!$demande) {
            return $this->json(['success' => false, 'message' => 'Demande introuvable'], 404);
        } elseif ($demande->getStatut() != 'Approuvé') {
            $this->addFlash('error', 'Vous ne pouvez traiter une demande que si son statut est "Approuvé".');
            return $this->redirectToRoute('traiterdemande.index');
        } else {
            $vehiculeIds = $request->request->get('vehicules');
            $chauffeurIds = $request->request->get('chauffeurs');
            $observations = $request->request->get('observations');
            $user = $this->getUser();{
        }
        try {
            $traiterDemande = new TraiterDemande();
            // Mettre à jour les champs de la demande
            $demande->setStatut('Traité');
            $demande->setTraitePar($user);
            $demande->setDateTraitement(new \DateTime());
            $demande->setObservations($observations);


            // Vérifiez si $vehiculeIds est itérable
            if (!is_iterable($vehiculeIds)) {
                // Convertissez $vehiculeIds en tableau s'il s'agit d'une chaîne avec des identifiants séparés par des virgules
                $vehiculeIds = explode(',', $vehiculeIds);
            }

            // Associer les véhicules à la demande
            foreach ($vehiculeIds as $key => $vehiculeId) {
                $vehicule = $em->getRepository(Vehicule::class)->find($vehiculeId);
                $chauffeurId = $chauffeurIds[$key];
                $chauffeur = $em->getRepository(Chauffeur::class)->find($chauffeurId);
                    
                if ($vehicule && $chauffeur) {
                    $traiterDemande->addDemandeId($vehicule);
                    $traiterDemande->addVehiculeId($vehicule);
                    $traiterDemande->addChauffeurId($chauffeur);
                }
                }

                $em->persist($demande);
                $em->flush();

                $em->persist($traiterDemande);
                $em->flush();

                return $this->json(['success' => true]);
            } catch (\Exception $e) {
                return $this->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }
    }

}