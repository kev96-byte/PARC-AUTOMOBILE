<?php

namespace App\Controller;

use App\Entity\Dommage;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Form\DommageType;
use App\Form\DommageRepairType;
use App\Repository\DommageRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/dommage')]
class DommageController extends AbstractController
{
    #[Route('/', name: 'dommage.index', methods: ['GET'])]
    public function index(DommageRepository $dommageRepository): Response
    {
        return $this->render('dommage/index.html.twig', [
            'dommages' => $dommageRepository->findBy([
            'deleteAt' => null,
            'repare' => false, // ou 'repare' => 0
]),
        ]);
    }

    #[Route('/new', name: 'dommage.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $dommage = new Dommage();
        $form = $this->createForm(DommageType::class, $dommage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicule = $form->get('vehicule')->getData();
            $vehicule->setEtat("Endommagé");
            $entityManager->persist($dommage);
            $entityManager->flush();

            return $this->redirectToRoute('dommage.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dommage/new.html.twig', [
            'dommage' => $dommage,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'dommage.show', methods: ['GET'])]
    public function show(Dommage $dommage): Response
    {
        return $this->render('dommage/show.html.twig', [            
            'dommage' => $dommage,            
        ]);
    }


    #[Route('/dommages/affichage', name: 'dommages.liste')]
    public function afficherDommages(DommageRepository $dommageRepository): Response
    {
        $dommages = $dommageRepository->findDommagesWithChauffeurAndVehicule();

        return $this->render('dommage/affichage.html.twig', [
            'dommages' => $dommages,
        ]);
    }



    #[Route('/{id}/edit', name: 'dommage.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dommage $dommage, EntityManagerInterface $entityManager, VehiculeRepository $vehiculeRepository): Response
    {
        // Définir le mode d'édition et récupérer l'ID du véhicule initial
        $mode = 'edit';
        $vehiculeInitial = $dommage->getVehicule();
        $vehiculeInitialId = $vehiculeInitial ? $vehiculeInitial->getId() : null;
    
        // Créer le formulaire avec l'ID du véhicule initial en option
        $form = $this->createForm(DommageType::class, $dommage, [
            'mode' => $mode,
            'vehicule_initial_id' => $vehiculeInitialId,
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le véhicule sélectionné dans le formulaire
            $nouveauVehicule = $dommage->getVehicule();
    
            // Vérifier si le véhicule a été modifié
            if ($vehiculeInitialId !== $nouveauVehicule->getId()) {
                // Si un véhicule initial existait, le mettre à jour à l'état "En service"
                if ($vehiculeInitial) {
                    $vehiculeInitial->setEtat('En service');
                }
    
                // Mettre le nouveau véhicule à l'état "Endommagé"
                $nouveauVehicule->setEtat('Endommagé');
            }
    
            // Sauvegarder les modifications
            $entityManager->flush();
    
            // Redirection avec message de confirmation
            $this->addFlash('success', 'Le dommage a été mis à jour avec succès.');
    
            return $this->redirectToRoute('dommage.index');
        }
    
        return $this->render('dommage/edit.html.twig', [
            'dommage' => $dommage,
            'form' => $form->createView(),
            'mode' => $mode,
        ]);
    }

    #[Route('/dommage/{id}/reparer', name: 'dommage.reparer', methods: ['GET', 'POST'])]
    public function reparer(Request $request, Dommage $dommage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DommageRepairType::class, $dommage); // Formulaire spécifique pour la réparation
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicule = $dommage->getVehicule();
            if ($vehicule) {
                $vehicule->setEtat('En service');
            }
            $dommage->setRepare(true);  // Indiquer que le dommage est réparé
            $entityManager->flush();

            $this->addFlash('success', 'Le dommage a été marqué comme réparé.');
            return $this->redirectToRoute('dommage.index');
        }

        return $this->render('dommage/new_reparation.html.twig', [
            'form' => $form->createView(),
            'dommage' => $dommage,
        ]);
    }


    #[Route('/{id}', name: 'dommage.delete', methods: ['POST'])]
    public function delete(Request $request, Dommage $dommage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dommage->getId(), $request->request->get('_token'))) {
            // Récupérer le véhicule associé au dommage
            $vehicule = $dommage->getVehicule();

            // Vérifiez si le véhicule existe et mettez à jour son état
            if ($vehicule) {
                $vehicule->setEtat('En service');
                $entityManager->persist($vehicule);
            }
            $dommage->setDeleteAt(new \DateTimeImmutable());
            $entityManager->flush();
            $this->addFlash('success', 'Suppression effectuée avec succès.');
        }

        return $this->redirectToRoute('dommage.index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/vehicules/repares', name: 'vehicules.repares', methods: ['GET'])]
    public function dommages_repares(DommageRepository $dommageRepository): Response
    {
        // Récupérer les dommages marqués comme réparés
        $dommagesRepares = $dommageRepository->findBy(['repare' => true]);

        // Rendu de la vue avec les dommages réparés
        return $this->render('dommage/vehicules_repares.html.twig', [
            'dommages' => $dommagesRepares,
        ]);
    }

}
