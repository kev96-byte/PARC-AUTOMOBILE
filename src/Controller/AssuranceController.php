<?php

namespace App\Controller;

use App\Entity\Assurance;
use App\Form\AssuranceType;
use App\Repository\AssuranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/assurance')]
class AssuranceController extends AbstractController
{
    #[Route('/', name: 'assurance.index', methods: ['GET'])]
    public function index(AssuranceRepository $assuranceRepository): Response
    {
        return $this->render('assurance/index.html.twig', [
            'assurances' => $assuranceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'assurance.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assurance = new Assurance();
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /** @var UploadedFile $file */
             $file = $form->get('pieceAssurance')->getData();
             if ($file) {
                $vehicule = $assurance->getVehiculeId();
                $matricule = $vehicule ? $vehicule->getMatricule() : 'unknown';
                $filename = 'pieceAssurance_' . $matricule . '.' . $file->getClientOriginalExtension();    
                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir').'/public/img/Assurances', $filename);
                        $assurance->setPieceAssurance($filename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de la pièce.');
                }
                
             }
           
            $entityManager->persist($assurance);
            $entityManager->flush();
            

            return $this->redirectToRoute('assurance.index', [], Response::HTTP_SEE_OTHER);
        }

            return $this->render('assurance/new.html.twig', [
                'assurance' => $assurance,
                'form' => $form,
            ]);
        }


    #[Route('/{id}', name: 'assurance.show', methods: ['GET'])]
    public function show(Assurance $assurance): Response
    {
        return $this->render('assurance/show.html.twig', [
            'assurance' => $assurance,
        ]);
    }

    #[Route('/{id}/edit', name: 'assurance.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assurance $assurance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('pieceAssurance')->getData();
            if ($file) {
                $vehicule = $assurance->getVehiculeId();
                $matricule = $vehicule ? $vehicule->getMatricule() : 'unknown';
                $filename = 'pieceAssurance_' . $matricule . '.' . $file->getClientOriginalExtension();
                $file->move($this->getParameter('kernel.project_dir') . '/public/img/assurances', $filename);
                $assurance->setPieceAssurance($filename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('assurance.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurance/edit.html.twig', [
            'assurance' => $assurance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'assurance.delete', methods: ['POST'])]
    public function delete(Request $request, Assurance $assurance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assurance->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($assurance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('assurance.index', [], Response::HTTP_SEE_OTHER);
    }
}
