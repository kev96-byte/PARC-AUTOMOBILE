<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Entity\TypeStructure;
use App\Form\TypeStructureType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TypeStructureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/type/structure')]
#[IsGranted('ROLE_USER')]
class TypeStructureController extends AbstractController
{
    #[Route('/', name: 'TypeStructure.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('type_structure/index.html.twig', [
            'type_structures' => $entityManager->getRepository(TypeStructure::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'TypeStructure.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $typeStructure = new TypeStructure();
        $form = $this->createForm(TypeStructureType::class, $typeStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeStructure);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute('TypeStructure.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_structure/new.html.twig', [
            'type_structure' => $typeStructure,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'TypeStructure.show', methods: ['GET'])]
    public function show(TypeStructure $typeStructure): Response
    {
        return $this->render('type_structure/show.html.twig', [
            'type_structure' => $typeStructure,
        ]);
    }

    #[Route('/{id}/edit', name: 'TypeStructure.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeStructure $typeStructure, EntityManagerInterface $entityManager): Response
    {
        $mode = 'edit';
        $form = $this->createForm(TypeStructureType::class, $typeStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('TypeStructure.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_structure/edit.html.twig', [
            'type_structure' => $typeStructure,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

/*     #[Route('/{id}', name: 'TypeStructure.delete', methods: ['POST'])]
    public function delete(Request $request, TypeStructure $typeStructure, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeStructure->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($typeStructure);
            $entityManager->flush();
            $this->addFlash('success', 'Suppression effectuée avec succès.');
        }

        return $this->redirectToRoute('TypeStructure.index', [], Response::HTTP_SEE_OTHER);
    } */





    #[Route('/{id}', name: 'TypeStructure.delete', methods: ['POST'])]
    public function delete(Request $request, TypeStructure $typeStructure, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeStructure->getId(), $request->getPayload()->get('_token'))) {
            // Vérifiez si l'enregistrement de niveau est associé à une institution
            $structuresCount = $entityManager->getRepository(Structure::class)->count(['typeStructure' => $typeStructure]);
            if ($structuresCount > 0) {
                // Si des institutions sont associées, renvoyez un message d'erreur
                    $this->addFlash('error', 'Vous ne pouvez pas supprimer ce type de structure car il est associé à des structures. ');
                // $this->addFlash('notice', 'Hello world');
            } else {
                // Sinon, supprimez l'enregistrement de niveau
                // $entityManager->remove($niveau);
                $typeStructure->setDeleteAt(new \DateTimeImmutable());
                $entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            }
        }
    
        return $this->redirectToRoute('TypeStructure.index', [], Response::HTTP_SEE_OTHER);
    }

}
