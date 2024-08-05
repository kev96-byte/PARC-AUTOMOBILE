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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/affecter')]
class AffecterController extends AbstractController
{
    #[Route('/{demandeId}', name: 'affecter.index', methods: ['GET'], requirements: ['demandeId' => '\d+'])]
    public function index(int $demandeId, DemandeRepository $demandeRepository, EntityManagerInterface $entityManager): Response
    {
        $demande = $demandeRepository->find($demandeId);
        $numDemande = $demande->getNumDemande();
    
        if (!$demande) {
            throw $this->createNotFoundException('Demande non trouvée');
        }
    
        $affecters = $entityManager->getRepository(Affecter::class)->findBy([
            'deleteAt' => null,
            'demande' => $demandeId
        ]);
    
        return $this->render('affecter/index.html.twig', [
            'affecters' => $affecters,
            'demandeId' => $demandeId,
            'numdemande' => $numDemande
        ]);
    }


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

    #[Route('/affecter/list', name: 'affecter.list', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager, NiveauRepository $niveauRepository): Response
    {
        // Récupérer les données nécessaires pour la liste
        $affecters = $entityManager->getRepository(Affecter::class)->findAll();

        return $this->render('affecter/list.html.twig', [
            'affecters' => $affecters,
            'niveau' => $niveauRepository->findAll()
        ]);
    }

    #[Route('/create/{demandeId}', name: 'affecter.create', methods: ['GET', 'POST'])]
    public function create(Request $request, DemandeRepository $demandeRepository, EntityManagerInterface $entityManager, int $demandeId): Response
    {

        $demande = $demandeRepository->find($demandeId);
        $numDemande = $demande->getNumDemande();
        
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

            // Récupérer l'entité Vehicule sélectionnée
            $vehicule = $formData->getVehicule();

            // Récupérer l'entité Chauffeur sélectionnée
            $chauffeur = $formData->getChauffeur();

            // Mettre à jour la disponibilité du véhicule
            if ($vehicule) {
                $vehicule->setDisponibilite('En mission');
            }

            // Mettre à jour la disponibilité du chauffeur
            if ($chauffeur) {
                $chauffeur->setDisponibilite('En mission');
            }
            
            // Récupérer l'identifiant du véhicule sélectionné
            $vehiculeId = $formData->getVehicule()->getId();

            // Récupérer l'identifiant du chauffeur sélectionné
            $chauffeurId = $formData->getChauffeur()->getId();

            // Récupérer la valeur du champ 'demande_id' non mappé
            $demandeId = $form->get('demande_id')->getData();

            // Récupérer l'objet Demande correspondant à l'ID
            $demande = $entityManager->getRepository(Demande::class)->find($demandeId);
            if (!$demande) {
                throw $this->createNotFoundException('Demande not found for ID ' . $demandeId);
            }

            // Associer l'objet Demande à l'affectation
            $affecter->setDemande($demande);

            // $observation = $request->request->get('observation');

            $demande->setStatut('Validé');
            $currentUser = $this->getUser();
            $demande->setTraiterPar($currentUser);
            $demande->setDateTraitement(new \DateTimeImmutable());
            // $demande->setObservations($observation);

            $affecter->setDemande($demande);
            $affecter->setVehicule($vehicule);
            $affecter->setChauffeur($chauffeur);


            $entityManager->persist($vehicule);
            $entityManager->persist($chauffeur);
            $entityManager->persist($demande);    
            $entityManager->persist($affecter);
            $entityManager->flush();
    
            return $this->redirectToRoute('affecter.index', ['demandeId' => $demandeId]);
        }
    
        return $this->render('affecter/_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => false,
            'demandeId' => $demandeId, // Passer l'ID de la demande à la vue
            'numdemande' => $numDemande
        ]);
    }
    
    #[Route('/edit/{id}', name: 'affecter.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        // Récupérer l'affectation existante à partir de la base de données
        $affecter = $entityManager->getRepository(Affecter::class)->find($id);
    
        if (!$affecter) {
            throw $this->createNotFoundException('Affectation not found');
        }
    
        // Récupérer l'identifiant de la demande
        $demande = $affecter->getDemande();
        $demandeId = $demande ? $demande->getId() : null;
    
        // Récupérer la date de fin de mission et le nombre de véhicules (si nécessaire)
        // Assurez-vous que ces valeurs sont disponibles dans votre entité
        $dateFinMission = $demande ? $demande->getDateFinMission() : null;
        $nbreVehicules = $demande ? $demande->getNbreVehicules() : null;
        $nbreVehiculesAffectés = count($entityManager->getRepository(Affecter::class)->findBy(['demande' => $demandeId]));
    
        // Création du formulaire en passant l'entité existante
        $form = $this->createForm(AffecterType::class, $affecter, [
            'demande_id' => $demandeId,
            'date_fin_mission' => $dateFinMission,
            'nbre_vehicules' => $nbreVehicules
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement des données soumises
            $entityManager->flush();
    
            return $this->redirectToRoute('affecter.index', ['demandeId' => $demandeId]);
        }
    
        return $this->render('affecter/_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => true,
            'demandeId' => $demandeId
        ]);
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
        return $this->redirectToRoute('affecter.index', ['demandeId' => $affecter->getDemande()->getId()]);
    }
}
