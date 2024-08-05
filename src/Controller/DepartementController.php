<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Entity\Departement;
use App\Form\DepartementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/departement')]

class DepartementController extends AbstractController
{
    #[Route('/', name: 'departement.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {

        return $this->render('departement/index.html.twig', [
            'departementx' => $entityManager->getRepository(Departement::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'departement.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($departement);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute('departement.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('departement/new.html.twig', [
            'departement' => $departement,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'departement.show', methods: ['GET'])]
    public function show(Departement $departement): Response
    {
        return $this->render('departement/show.html.twig', [
            'departement' => $departement,
        ]);
    }

    #[Route('/{id}/edit', name: 'departement.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Departement $departement, EntityManagerInterface $entityManager): Response
    {
        $mode = 'edit';
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('departement.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('departement/edit.html.twig', [
            'departement' => $departement,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'departement.delete', methods: ['POST'])]
    public function delete(Request $request, Departement $departement, EntityManagerInterface $entityManager): Response
    {
        $token = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $departement->getId(), $token)) {
            $qb = $entityManager->createQueryBuilder();
            $communesCount = $qb->select('count(i.id)')
                ->from(Commune::class, 'i')
                ->where('i.departement = :departement')
                ->andWhere('i.deleteAt IS NULL')
                ->setParameter('departement', $departement)
                ->getQuery()
                ->getSingleScalarResult();
    
            if ($communesCount > 0) {
                $this->addFlash('error', 'Vous ne pouvez pas supprimer ce departement car il est associé à des institutions.');
            } else {
                $departement->setDeleteAt(new \DateTimeImmutable());
                $entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            }
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide.');
        }
    
        return $this->redirectToRoute('departement.index', [], Response::HTTP_SEE_OTHER);
    }
    
   
}
