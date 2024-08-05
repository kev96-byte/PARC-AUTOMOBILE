<?php

namespace App\Controller;

use App\Entity\Parc;
use App\Entity\Institution;
use App\Entity\Utilisateur;
use App\Form\ParcType;
use App\Entity\TypeParc;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/parc')]
#[IsGranted('ROLE_USER')]
class ParcController extends AbstractController
{
    #[Route('/', name: 'parc.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('parc/index.html.twig', [
/*             'typeparcs' => $entityManager->getRepository(Parc::class)->findBy(['deleteAt' => null]),
            'institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]), */
            'parcs' => $entityManager->getRepository(Parc::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'parc.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $parc = new Parc();
        $form = $this->createForm(ParcType::class, $parc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parc);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');

            return $this->redirectToRoute('parc.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parc/new.html.twig', [
            'parc' => $parc,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'parc.show', methods: ['GET'])]
    public function show(Parc $parc): Response
    {
        return $this->render('parc/show.html.twig', [
            'parc' => $parc,

        ]);
    }

    #[Route('/{id}/edit', name: 'parc.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parc $parc, EntityManagerInterface $entityManager): Response
    {
        $mode = 'edit';
        $form = $this->createForm(ParcType::class, $parc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('parc.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parc/edit.html.twig', [
            'parc' => $parc,
            'form' => $form,
            'mode' => $mode,
        ]);
    }


    #[Route('/{id}', name: 'parc.delete', methods: ['POST'])]
    public function delete(Request $request, Parc $parc, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parc->getId(), $request->getPayload()->get('_token'))) {

            $parc->setDeleteAt(new \DateTimeImmutable());
            $entityManager->flush();
            $this->addFlash('success', 'Suppression effectuée avec succès.');

        }
    
        return $this->redirectToRoute('parc.index', [], Response::HTTP_SEE_OTHER);
    }
}
