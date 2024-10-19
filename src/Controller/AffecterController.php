<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Affecter;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Form\AffecterType;
use App\Repository\NiveauRepository;
use App\Repository\DemandeRepository;
use App\Repository\AffecterRepository;
use App\Repository\VehiculeRepository;
use App\Repository\ChauffeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/affecter')]
class AffecterController extends AbstractController
{
  /*   #[Route('/{demandeId}', name: 'affecter.index', methods: ['GET'], requirements: ['demandeId' => '\d+'])]
    public function index(int $demandeId, Request $request, DemandeRepository $demandeRepository, VehiculeRepository $vehiculeRepository, ChauffeurRepository $chauffeurRepository, EntityManagerInterface $entityManager): Response
    {
        $demande = $demandeRepository->find($demandeId);
        $numDemande = $demande->getNumDemande();

        if (!$demande) {
            throw $this->createNotFoundException('Demande non trouvée');
        }


        $chauffeursDemandes = [];    
        foreach ($demande->getChauffeurs() as $matricule) {
            $chauffeur = $chauffeurRepository->findOneBy(['matriculeChauffeur' => $matricule]);
            if ($chauffeur) {
                $chauffeursDemandes[] = $chauffeur;
            }
        }


        $vehiculesDemandes = [];    
        foreach ($demande->getVehicules() as $matricule) {
            $vehicule = $vehiculeRepository->findOneBy(['matricule' => $matricule]);
            if ($vehicule) {
                $vehiculesDemandes[] = $vehicule;
            }
        }
    
        $affecters = $entityManager->getRepository(Affecter::class)->findBy([
            'deleteAt' => null,
            'demande' => $demandeId
        ]);

        
        $affecter = new Affecter();
        
        // Créez le formulaire en passant l'ID de la demande en option
        $form = $this->createForm(AffecterType::class, $affecter, [
            'demande_id' => $demandeId,
            'numdemande' => $numDemande
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire soumises
            $formData = $form->getData();
    
            // Récupérer l'entité Véhicule et Chauffeur sélectionnées
            $vehicule = $formData->getVehicule();
            $chauffeur = $formData->getChauffeur();
    
            // Mettre à jour la disponibilité du véhicule et du chauffeur
            if ($vehicule) {
                $vehicule->setDisponibilite('En mission');
            }
            if ($chauffeur) {
                $chauffeur->setDisponibilite('En mission');
            }
            
            // Récupérer l'objet Demande correspondant à l'ID
            $demande = $entityManager->getRepository(Demande::class)->find($demandeId);
            if (!$demande) {
                throw $this->createNotFoundException('Demande not found for ID ' . $demandeId);
            }
    
            // Associer l'objet Demande à l'affectation
            $affecter->setDemande($demande);
            $affecter->setVehicule($vehicule);
            $affecter->setChauffeur($chauffeur);
    
            $entityManager->persist($vehicule);
            $entityManager->persist($chauffeur);
            $entityManager->persist($demande);    
            $entityManager->persist($affecter);
            $entityManager->flush();
    
            // Rediriger avec un message flash
            $this->addFlash('success', 'Affectation ajoutée avec succès.');
    
            return $this->redirectToRoute('affecter.index', ['demandeId' => $demandeId]);
        }
    
        return $this->render('affecter/index.html.twig', [
            'form' => $form->createView(),
            'numdemande' => $numDemande,
            'affecters' => $affecters,
            'demandeId' => $demandeId,
            'chauffeursDemandes' => $chauffeursDemandes, // Passez la liste des objets Chauffeur demandés au template
            'vehiculesDemandes' => $vehiculesDemandes, // Passez la liste des objets Véhicules demandés au template
       
        ]);
    } */


    public function afficherDemande(int $id, DemandeRepository $demandeRepository): Response
    {
        $demande = $demandeRepository->find($id);
        if (!$demande) {
            throw $this->createNotFoundException('La demande n\'existe pas');
        }
        return $this->render('demande/afficher.html.twig', [
            'demande' => $demande,
        ]);
    }

/*     #[Route('/affecter/list', name: 'affecter.list', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager, NiveauRepository $niveauRepository): Response
    {
        // Récupérer les données nécessaires pour la liste
        $affecters = $entityManager->getRepository(Affecter::class)->findAll();

        return $this->render('affecter/list.html.twig', [
            'affecters' => $affecters,
            'niveau' => $niveauRepository->findAll()
        ]);
    } */

    #[Route('/create/{demandeId}', name: 'affecter.create', methods: ['GET', 'POST'])]
    public function create(Request $request, VehiculeRepository $vehiculeRepository, ChauffeurRepository $chauffeurRepository, DemandeRepository $demandeRepository, EntityManagerInterface $entityManager, int $demandeId): Response
    {
        $demande = $demandeRepository->find($demandeId);
        $numDemande = $demande->getNumDemande();

        if (!$demande) {
            throw $this->createNotFoundException('Demande non trouvée');
        }


        $chauffeursDemandes = [];    
        foreach ($demande->getChauffeurs() as $matricule) {
            $chauffeur = $chauffeurRepository->findOneBy(['matriculeChauffeur' => $matricule]);
            if ($chauffeur) {
                $chauffeursDemandes[] = $chauffeur;
            }
        }


        $vehiculesDemandes = [];    
        foreach ($demande->getVehicules() as $matricule) {
            $vehicule = $vehiculeRepository->findOneBy(['matricule' => $matricule]);
            if ($vehicule) {
                $vehiculesDemandes[] = $vehicule;
            }
        }
    
        $affecters = $entityManager->getRepository(Affecter::class)->findBy([
            'deleteAt' => null,
            'demande' => $demandeId
        ]);

        
        $affecter = new Affecter();
        
        // Créez le formulaire en passant l'ID de la demande en option
        $form = $this->createForm(AffecterType::class, $affecter, [
            'demande_id' => $demandeId
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire soumises
            $formData = $form->getData();

            // Récupérer l'entité Vehicule sélectionnée
            $vehicule = $formData->getVehicule();

            // Récupérer l'entité Chauffeur sélectionnée
            $chauffeur = $formData->getChauffeur();


            // Récupérer la valeur du champ 'demande_id' non mappé
            $demandeId = $form->get('demande_id')->getData();

            // Récupérer l'objet Demande correspondant à l'ID
            $demande = $entityManager->getRepository(Demande::class)->find($demandeId);
            if (!$demande) {
                throw $this->createNotFoundException('Demande not found for ID ' . $demandeId);
            }
            $dataDebutMission = $demande ? $demande->getDateDebutMission() : null;
            $dateFinMission = $demande ? $demande->getDateFinMission() : null;
            $affecter->setDemande($demande);
            $affecter->setDateDebutMission($dataDebutMission);
            $affecter->setDateFinMission($dateFinMission);
            $affecter->setVehicule($vehicule);
            $affecter->setChauffeur($chauffeur);  
            $entityManager->persist($affecter);
            $entityManager->flush();

    
            return $this->redirectToRoute('affecter.create', ['demandeId' => $demandeId]);
        }
    
        return $this->render('affecter/index.html.twig', [
            'form' => $form->createView(),
            'numdemande' => $numDemande,
            'affecters' => $affecters,
            'demandeId' => $demandeId,
            'chauffeursDemandes' => $chauffeursDemandes, // Passez la liste des objets Chauffeur demandés au template
            'vehiculesDemandes' => $vehiculesDemandes, // Passez la liste des objets Véhicules demandés au template
            'is_edit' => false, // Mode création
        ]);
    }
    
    
    #[Route('/edit/{id}', name: 'affecter.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VehiculeRepository $vehiculeRepository, ChauffeurRepository $chauffeurRepository, DemandeRepository $demandeRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        // Récupérer l'affectation existante à partir de la base de données
        $affecter = $entityManager->getRepository(Affecter::class)->find($id);
    
        if (!$affecter) {
            throw $this->createNotFoundException('Affectation not found');
        }
    
        // Récupérer l'identifiant de la demande
        $demande = $affecter->getDemande();
        $demandeId = $demande ? $demande->getId() : null;


        $demande = $demandeRepository->find($demandeId);
        $numDemande = $demande->getNumDemande();

        if (!$demande) {
            throw $this->createNotFoundException('Demande non trouvée');
        }


        $chauffeursDemandes = [];    
        foreach ($demande->getChauffeurs() as $matricule) {
            $chauffeur = $chauffeurRepository->findOneBy(['matriculeChauffeur' => $matricule]);
            if ($chauffeur) {
                $chauffeursDemandes[] = $chauffeur;
            }
        }


        $vehiculesDemandes = [];    
        foreach ($demande->getVehicules() as $matricule) {
            $vehicule = $vehiculeRepository->findOneBy(['matricule' => $matricule]);
            if ($vehicule) {
                $vehiculesDemandes[] = $vehicule;
            }
        }
    
        $affecters = $entityManager->getRepository(Affecter::class)->findBy([
            'deleteAt' => null,
            'demande' => $demandeId
        ]);

        $form = $this->createForm(AffecterType::class, $affecter, [
            'demande_id' => $demandeId,
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement des données soumises
            $entityManager->flush();
    
            return $this->redirectToRoute('affecter.create', ['demandeId' => $demandeId]);
        }
    
        return $this->render('affecter/index.html.twig', [
            'form' => $form->createView(),
            'numdemande' => $numDemande,
            'affecters' => $affecters,
            'demandeId' => $demandeId,
            'chauffeursDemandes' => $chauffeursDemandes, // Passez la liste des objets Chauffeur demandés au template
            'vehiculesDemandes' => $vehiculesDemandes, // Passez la liste des objets Véhicules demandés au template
            'is_edit' => true, // Mode édition
        ]);
    }


    #[Route('/validate/{demandeId}', name: 'affecter.validate', methods: ['POST'])]
    public function validate(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération de l'ID de la demande depuis la requête JSON
        $data = json_decode($request->getContent(), true);
        $demandeId = $data['demandeId'] ?? null;

        if ($demandeId) {

            // Récupérer l'objet Demande correspondant à l'ID
            $demande = $entityManager->getRepository(Demande::class)->find($demandeId);
            if (!$demande) {
                throw $this->createNotFoundException('Demande not found for ID ' . $demandeId);
            }

            $affecters = $entityManager->getRepository(Affecter::class)->findBy([            
                'demande' => $demandeId
            ]);

            // Parcourir chaque enregistrement trouvé et mettre à jour le champ 'statut'
            foreach ($affecters as $affecter) {
                $affecter->setStatut('Traité');
            }
            $demande->setStatut('Traité');
            $currentUser = $this->getUser();
            $demande->setTraiterPar($currentUser);
            $demande->setDateTraitement(new \DateTimeImmutable());

            // Persister les changements en base de données
            $entityManager->flush();


            // Ajout d'un message flash
            $this->addFlash('success', 'Traitement réussie !');

            return new JsonResponse(['success' => true]);
        }
 
        return new JsonResponse(['success' => false], 400);
     }
    
    

    #[Route('/delete/{id}', name: 'affecter.delete', methods: ['POST'])]
    public function delete(Request $request, Affecter $affecter, EntityManagerInterface $entityManager): Response
    {
        // Vérification du token CSRF
        if ($this->isCsrfTokenValid('delete' . $affecter->getId(), $request->request->get('_token'))) {
            // Suppression de l'entité
            $entityManager->remove($affecter);
            $entityManager->flush();

            // Message flash de succès
            $this->addFlash('success', 'Affectation supprimée avec succès');
        } else {
            throw new AccessDeniedException('Token CSRF invalide.');
        }

        // Redirection après suppression, en récupérant l'identifiant de la demande
        return $this->redirectToRoute('affecter.create', ['demandeId' => $affecter->getDemande()->getId()]);
    }
}
