<?php

namespace App\Controller;

use App\Entity\Visite;
use App\Form\VisiteType;
use App\Repository\VisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/visite')]
class VisiteController extends AbstractController
{
    #[Route('/', name: 'visite.index', methods: ['GET'])]
    public function index(VisiteRepository $visiteRepository): Response
    {
        return $this->render('visite/index.html.twig', [
            'visites' => $visiteRepository->findAll(),
        ]);
    }

    #[Route('/valides', name: 'visite.valides', methods: ['GET'])]
    public function valides(VisiteRepository $visiteRepository): Response
    {
        $qb = $visiteRepository->createQueryBuilder('v')
            ->select('v')
            ->where('v.dateFinVisite >= :today') // Visite valide
            ->andWhere('v.dateFinVisite = (
            SELECT MAX(v2.dateFinVisite)
            FROM App\Entity\Visite v2
            WHERE v2.vehicule = v.vehicule
        )') // Dernière visite pour chaque véhicule
            ->setParameter('today', new \DateTime())
            ->orderBy('v.dateFinVisite', 'DESC')
            ->getQuery();

        $dernieresVisites = $qb->getResult();

        return $this->render('visite/index.html.twig', [
            'visites' => $dernieresVisites,
        ]);
    }


    #[Route('/nonvalides', name: 'visite.nonvalides', methods: ['GET'])]
    public function nonvalides(VisiteRepository $visiteRepository): Response
    {
        $qb = $visiteRepository->createQueryBuilder('v')
            ->select('v')
            ->where('v.dateFinVisite < :today') // Visite non valide
            ->andWhere('v.dateFinVisite = (
                SELECT MAX(v2.dateFinVisite)
                FROM App\Entity\Visite v2
                WHERE v2.vehicule = v.vehicule
            )') // Dernière visite pour chaque véhicule
            ->setParameter('today', new \DateTime())
            ->orderBy('v.dateFinVisite', 'DESC')
            ->getQuery();

        $visitesExpirees = $qb->getResult();

        return $this->render('visite/index.html.twig', [
            'visites' => $visitesExpirees,
        ]);
    }

    #[Route('/new', name: 'visite.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $visite = new Visite();

        $form = $this->createForm(VisiteType::class, $visite, [
            'is_edit' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateFinVisite = $form->get('dateFinVisite')->getData();
            $vehicule = $visite->getVehicule();
            $vehicule->setDateFinVisiteTechnique($dateFinVisite);
            /** @var UploadedFile $file */
            $file = $form->get('pieceVisite')->getData();
            if ($file) {
                $matricule = $vehicule ? $vehicule->getMatricule() : 'unknown';
                $filename = 'pieceVisite_' . $matricule . '.' . $file->getClientOriginalExtension();
                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir').'/public/img/Visites', $filename);
                    $visite->setPieceVisite($filename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de la pièce.');
                }

            }

            $entityManager->persist($vehicule);
            $entityManager->persist($visite);
            $entityManager->flush();


            return $this->redirectToRoute('visite.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('visite/new.html.twig', [
            'visite' => $visite,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'visite.show', methods: ['GET'])]
    public function show(Visite $visite): Response
    {
        return $this->render('visite/show.html.twig', [
            'visite' => $visite,
        ]);
    }

    #[Route('/{id}/edit', name: 'visite.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Visite $visite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VisiteType::class, $visite, [
            'is_edit' => true,
            'mode' => "edit",
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateFinVisite = $form->get('dateFinVisite')->getData();
            $vehicule = $visite->getVehicule();
            $vehicule->setDateFinVisiteTechnique($dateFinVisite);
            /** @var UploadedFile $file */
            $file = $form->get('pieceVisite')->getData();
            if ($file) {
                $matricule = $vehicule ? $vehicule->getMatricule() : 'unknown';
                $filename = 'pieceVisite_' . $matricule . '.' . $file->getClientOriginalExtension();
                $file->move($this->getParameter('kernel.project_dir') . '/public/img/visites', $filename);
                $visite->setPieceVisite($filename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('visite.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('visite/edit.html.twig', [
            'visite' => $visite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'visite.delete', methods: ['POST'])]
    public function delete(Request $request, Visite $visite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visite->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($visite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('visite.index', [], Response::HTTP_SEE_OTHER);
    }
}
