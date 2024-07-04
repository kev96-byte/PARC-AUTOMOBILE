<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Entity\Structure;
use App\Entity\Institution;
use App\Form\InstitutionType;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InstitutionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/institution')]
class InstitutionController extends AbstractController
{
    #[Route('/', name: 'institution.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, NiveauRepository $niveauRepository ): Response
    {
        return $this->render('institution/index.html.twig', [
            'institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]),
            'niveau' => $niveauRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'institution.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $institution = new Institution();
        $form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($institution);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');

            return $this->redirectToRoute('institution.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('institution/new.html.twig', [
            'institution' => $institution,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'institution.show', methods: ['GET'])]
    public function show(Institution $institution, NiveauRepository $niveauRepository): Response
    {
        return $this->render('institution/show.html.twig', [
            'institution' => $institution,
        ]);
    }

    #[Route('/{id}/edit', name: 'institution.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Institution $institution, EntityManagerInterface $entityManager): Response
    {
        $mode = 'edit';
        $form = $this->createForm(InstitutionType::class, $institution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('institution.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('institution/edit.html.twig', [
            'institution' => $institution,
            'form' => $form,
            'mode' => $mode,
        ]);
    }




    #[Route('/{id}', name: 'institution.delete', methods: ['POST'])]
    public function delete(Request $request, Institution $institution, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$institution->getId(), $request->getPayload()->get('_token'))) {
            // Vérifiez si l'enregistrement de niveau est associé à une institution
            $vehiculesCount = $entityManager->getRepository(Vehicule::class)->count(['institution' => $institution]);
            $structuresCount = $entityManager->getRepository(Structure::class)->count(['institution' => $institution]);
            if ($structuresCount > 0 || $vehiculesCount > 0) {
                // Si des institutions sont associées, renvoyez un message d'erreur
                    $this->addFlash('error', 'Vous ne pouvez pas supprimer cette institution car elle est associé à des structures ou à des véhicules. ');
                // $this->addFlash('notice', 'Hello world');
            } else {
                // Sinon, supprimez l'enregistrement de niveau
                // $entityManager->remove($niveau);
                $institution->setDeleteAt(new \DateTimeImmutable());
                $entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            }
        }
    
        return $this->redirectToRoute('institution.index', [], Response::HTTP_SEE_OTHER);
    }
}
