<?php

namespace App\Controller;

use App\Entity\Parc;
use App\Entity\User;
use App\Entity\Structure;
use App\Entity\Institution;
use App\Entity\Utilisateur;
use App\Form\StructureType;
use App\Entity\TypeStructure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/structure')]
#[IsGranted('ROLE_USER')]
class StructureController extends AbstractController
{
    #[Route('/', name: 'structure.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('structure/index.html.twig', [
            'typestructures' => $entityManager->getRepository(TypeStructure::class)->findBy(['deleteAt' => null]),
            'institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]),
            'parcs' => $entityManager->getRepository(Parc::class)->findBy(['deleteAt' => null]),
            'structures' => $entityManager->getRepository(Structure::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'structure.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $structure = new Structure();
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                try {
                    $entityManager->persist($structure);
                    $entityManager->flush();
                    $this->addFlash('success', 'Ajout effectué avec succès.');                    
                    return $this->redirectToRoute('structure.index', [], Response::HTTP_SEE_OTHER);


                } catch (UniqueConstraintViolationException $e) {
                    // Ajouter un message flash pour l'erreur de contrainte d'unicité
                    $this->addFlash('error', "Cet utilisateur est déjà responsable d'une structure.");
                }
        }
        return $this->render('structure/new.html.twig', [
            'structure' => $structure,
            'form' => $form,
            'mode' => 'add',
        ]);
}

    #[Route('/{id}', name: 'structure.show', methods: ['GET'])]
    public function show(Structure $structure): Response
    {
        return $this->render('structure/show.html.twig', [
            'structure' => $structure,
        ]);
    }

    #[Route('/{id}/edit', name: 'structure.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Structure $structure, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('structure.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('structure/edit.html.twig', [
            'structure' => $structure,
            'form' => $form,
            'mode' => 'edit',
        ]);
    }

    #[Route('/{id}', name: 'structure.delete', methods: ['POST'])]
    public function delete(Request $request, Structure $structure, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$structure->getId(), $request->getPayload()->get('_token'))) {
            // Vérifiez si l'enregistrement de niveau est associé à une institution
            $urilisateursCount = $entityManager->getRepository(User::class)->count(['structure' => $structure]);
            if ($urilisateursCount > 0) {
                // Si des institutions sont associées, renvoyez un message d'erreur
                    $this->addFlash('error', 'Vous ne pouvez pas supprimer ce niveau car il est associé à des institutions. ');
                // $this->addFlash('notice', 'Hello world');
            } else {
                // Sinon, supprimez l'enregistrement de niveau
                // $entityManager->remove($niveau);
                $structure->setDeleteAt(new \DateTimeImmutable());
                $entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            }
        }
    
        return $this->redirectToRoute('structure.index', [], Response::HTTP_SEE_OTHER);
    }
}
