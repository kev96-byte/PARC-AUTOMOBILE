<?php

namespace App\Controller;

use App\Entity\Chauffeur;
use App\Entity\Institution;
use App\Form\ChauffeurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/chauffeur')]
#[IsGranted('ROLE_USER')]
class ChauffeurController extends AbstractController
{
    #[Route('/', name: 'chauffeur.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('chauffeur/index.html.twig', [ 
            'institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]),
            'chauffeurs' => $entityManager->getRepository(Chauffeur::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'chauffeur.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chauffeur = new Chauffeur();
        $form = $this->createForm(ChauffeurType::class, $chauffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chauffeur);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');

            return $this->redirectToRoute('chauffeur.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chauffeur/new.html.twig', [
            'chauffeur' => $chauffeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'chauffeur.show', methods: ['GET'])]
    public function show(Chauffeur $chauffeur): Response
    {
        return $this->render('chauffeur/show.html.twig', [
            'chauffeur' => $chauffeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'chauffeur.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chauffeur $chauffeur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChauffeurType::class, $chauffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('chauffeur.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chauffeur/edit.html.twig', [
            'chauffeur' => $chauffeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'chauffeur.delete', methods: ['POST'])]
    public function delete(Request $request, Chauffeur $chauffeur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chauffeur->getId(), $request->getPayload()->get('_token'))) {
            // Vérifiez si l'enregistrement de niveau est associé à une institution
    /*         $institutionsCount = $entityManager->getRepository(Institution::class)->count(['chauffeur' => $chauffeur]);
            if ($institutionsCount > 0) {
                // Si des institutions sont associées, renvoyez un message d'erreur
                    $this->addFlash('error', 'Vous ne pouvez pas supprimer cette institution car il est associé à des C. ');
                // $this->addFlash('notice', 'Hello world');
            } else { */
                // Sinon, supprimez l'enregistrement de niveau
                // $entityManager->remove($niveau);
                $chauffeur->setDeleteAt(new \DateTimeImmutable());
                $entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            // }
        }
    
        return $this->redirectToRoute('chauffeur.index', [], Response::HTTP_SEE_OTHER);
    }
}
