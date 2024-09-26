<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Entity\Assurance;
use App\Form\AssuranceType;
use App\Repository\VehiculeRepository;
use App\Repository\AssuranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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


    #[Route('/valides', name: 'assurance.valides', methods: ['GET'])]
    public function valides(AssuranceRepository $assuranceRepository): Response
    {
        $qb = $assuranceRepository->createQueryBuilder('a')
            ->select('a')
            ->where('a.dateFinAssurance >= :today') // Assurance valide
            ->andWhere('a.dateFinAssurance = (
            SELECT MAX(a2.dateFinAssurance)
            FROM App\Entity\Assurance a2
            WHERE a2.vehicule = a.vehicule
        )') // Dernière assurance pour chaque véhicule
            ->setParameter('today', new \DateTime())
            ->orderBy('a.dateFinAssurance', 'DESC')
            ->getQuery();

        $dernieresAssurances = $qb->getResult();

        return $this->render('assurance/index.html.twig', [
            'assurances' => $dernieresAssurances,
        ]);
    }


    #[Route('/nonvalides', name: 'assurance.nonvalides', methods: ['GET'])]
    public function nonvalides(AssuranceRepository $assuranceRepository): Response
    {
        $qb = $assuranceRepository->createQueryBuilder('a')
            ->select('a')
            ->where('a.dateFinAssurance < :today') // Assurance non valide
            ->andWhere('a.dateFinAssurance = (
            SELECT MAX(a2.dateFinAssurance)
            FROM App\Entity\Assurance a2
            WHERE a2.vehicule = a.vehicule
        )') // Dernière assurance pour chaque véhicule
            ->setParameter('today', new \DateTime())
            ->orderBy('a.dateFinAssurance', 'DESC')
            ->getQuery();

        $assurancesExpirees = $qb->getResult();

        return $this->render('assurance/index.html.twig', [
            'assurances' => $assurancesExpirees,
        ]);
    }

    #[Route('/new', name: 'assurance.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assurance = new Assurance();

        $form = $this->createForm(AssuranceType::class, $assurance, [
            'is_edit' => false,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dateFinAssurance = $form->get('dateFinAssurance')->getData();
            $vehicule = $assurance->getVehicule();
            $vehicule->setDateFinAssurance($dateFinAssurance);
            /** @var UploadedFile $file */
            $file = $form->get('pieceAssurance')->getData();
            if ($file) {
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
            $entityManager->persist($vehicule);
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
        $form = $this->createForm(AssuranceType::class, $assurance, [
            'is_edit' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateFinAssurance = $form->get('dateFinAssurance')->getData();
            $vehicule = $assurance->getVehicule();
            $vehicule->setDateFinAssurance($dateFinAssurance);
            /** @var UploadedFile $file */
            $file = $form->get('pieceAssurance')->getData();
            if ($file) {
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
