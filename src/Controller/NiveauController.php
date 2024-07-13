<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Form\NiveauType;
use App\Entity\Institution;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/niveau')]

class NiveauController extends AbstractController
{
    #[Route('/', name: 'niveau.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {

        return $this->render('niveau/index.html.twig', [
            'niveaux' => $entityManager->getRepository(Niveau::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'niveau.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $niveau = new Niveau();
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niveau);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute('niveau.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('niveau/new.html.twig', [
            'niveau' => $niveau,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'niveau.show', methods: ['GET'])]
    public function show(Niveau $niveau): Response
    {
        return $this->render('niveau/show.html.twig', [
            'niveau' => $niveau,
        ]);
    }

    #[Route('/{id}/edit', name: 'niveau.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Niveau $niveau, EntityManagerInterface $entityManager): Response
    {
        $mode = 'edit';
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('niveau.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('niveau/edit.html.twig', [
            'niveau' => $niveau,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'niveau.delete', methods: ['POST'])]
    public function delete(Request $request, Niveau $niveau, EntityManagerInterface $entityManager): Response
    {
        $token = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $niveau->getId(), $token)) {
            $qb = $entityManager->createQueryBuilder();
            $institutionsCount = $qb->select('count(i.id)')
                ->from(Institution::class, 'i')
                ->where('i.niveau = :niveau')
                ->andWhere('i.deleteAt IS NULL')
                ->setParameter('niveau', $niveau)
                ->getQuery()
                ->getSingleScalarResult();
    
            if ($institutionsCount > 0) {
                $this->addFlash('error', 'Vous ne pouvez pas supprimer ce niveau car il est associé à des institutions.');
            } else {
                $niveau->setDeleteAt(new \DateTimeImmutable());
                $entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            }
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide.');
        }
    
        return $this->redirectToRoute('niveau.index', [], Response::HTTP_SEE_OTHER);
    }
    
   
}
