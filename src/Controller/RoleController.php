<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Entity\Institution;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/role')]
class RoleController extends AbstractController
{
    #[Route('/', name: 'role.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {

        return $this->render('role/index.html.twig', [
            'roles' => $entityManager->getRepository(Role::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'role.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($role);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute('role.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('role/new.html.twig', [
            'role' => $role,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'role.show', methods: ['GET'])]
    public function show(Role $role): Response
    {
        return $this->render('role/show.html.twig', [
            'role' => $role,
        ]);
    }

    #[Route('/{id}/edit', name: 'role.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Role $role, EntityManagerInterface $entityManager): Response
    {
        $mode = 'edit';
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('role.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('role/edit.html.twig', [
            'role' => $role,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'role.delete', methods: ['POST'])]
    public function delete(Request $request, Role $role, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->getPayload()->get('_token'))) {
            // Vérifiez si l'enregistrement de role est associé à une institution
            $utilisateursCount = $entityManager->getRepository(Utilisateur::class)->count(['role' => $role]);
            if ($utilisateursCount > 0) {
                // Si des institutions sont associées, renvoyez un message d'erreur
                    $this->addFlash('error', 'Vous ne pouvez pas supprimer ce role car il est associé à des utilisateurs. ');
                // $this->addFlash('notice', 'Hello world');
            } else {
                // Sinon, supprimez l'enregistrement de role
                // $entityManager->remove($role);
                $role->setDeleteAt(new \DateTimeImmutable());
                $entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            }
        }
    
        return $this->redirectToRoute('role.index', [], Response::HTTP_SEE_OTHER);
    }
    
    
}
