<?php
// src/Controller/VidangeController.php
namespace App\Controller;

use App\Entity\Vidange;
use App\Form\VidangeType;
use App\Repository\VidangeRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/vidange')]
class VidangeController extends AbstractController
{
    #[Route('/', name: 'vidange.index', methods: ['GET'])]
    public function index(VidangeRepository $vidangeRepository): Response
    {
        return $this->render('vidange/index.html.twig', [
            'vidanges' => $vidangeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'vidange.create', methods: ['GET', 'POST'])]
    public function createVidange(Request $request, VehiculeRepository $vehiculeRepository, EntityManagerInterface $entityManager): Response
    {
        $vidange = new Vidange();
        $mode = 'add';
        $form = $this->createForm(VidangeType::class, $vidange, [
            'is_edit' => false,
            'vehicule_repository' => $vehiculeRepository
        ]);
        $form->handleRequest($request);        

        if ($form->isSubmitted() && $form->isValid()) {
            $dateVidange = $form->get('dateVidange')->getData();
            $vehicule = $vidange->getVehicule();
            $vehicule->setDateVidange($dateVidange);
            
            // Récupérer l'objet Véhicule sélectionné
            $vehicule = $vidange->getVehicule();
            $kilometrageCourant = $vehicule->getKilometrageCourant();

            // Mettre à jour le champ kilometrageInitial du véhicule
            $vehicule->setKilometrageInitial($kilometrageCourant);
            $vidange->setValeurCompteurKilometrage($kilometrageCourant);

            // Persister et flusher les changements
            $entityManager->persist($vidange);
            $entityManager->persist($vehicule); // persister les modifications sur le véhicule
            $entityManager->flush();

            // Redirection après la soumission réussie
            return $this->redirectToRoute('vidange.index');
        }

        return $this->render('vidange/new.html.twig', [
            'form' => $form->createView(),
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'vidange.show', methods: ['GET'])]
    public function show(Vidange $vidange): Response
    {
        return $this->render('vidange/show.html.twig', [
            'vidange' => $vidange,
        ]);
    }

    #[Route('/{id}/edit', name: 'vidange.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vidange $vidange, EntityManagerInterface $entityManager, VehiculeRepository $vehiculeRepository): Response
    {
        $mode = 'edit';
        $form = $this->createForm(VidangeType::class, $vidange, [
            'is_edit' => true,
            'vehicule_repository' => $vehiculeRepository
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateVidange = $form->get('dateVidange')->getData();
            $vehicule = $vidange->getVehicule();
            $vehicule->setDateVidange($dateVidange);
            /** @var UploadedFile $file */
            $file = $form->get('pieceVidange')->getData();
            if ($file) {
                $matricule = $vehicule ? $vehicule->getMatricule() : 'unknown';
                $filename = 'pieceVidange_' . $matricule . '.' . $file->getClientOriginalExtension();
                try {
                    $file->move($this->getParameter('kernel.project_dir') . '/public/img/vidanges', $filename);
                    $vidange->setPieceVidange($filename);
                } catch (FileException $e) {
                    // handle exception
                }
            }
            $entityManager->flush();

            return $this->redirectToRoute('vidange.index');
        }

        return $this->render('vidange/edit.html.twig', [
            'vidange' => $vidange,
            'form' => $form->createView(),
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'vidange.delete', methods: ['POST'])]
    public function delete(Request $request, Vidange $vidange, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vidange->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vidange);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vidange.index', [], Response::HTTP_SEE_OTHER);
    }
}
