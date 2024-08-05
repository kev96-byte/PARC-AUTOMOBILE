<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Form\CommuneType;
use App\Entity\Departement;
use App\Repository\CommuneRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/commune')]
#[IsGranted('ROLE_USER')]
class CommuneController extends AbstractController
{
    #[Route('/', name: 'commune.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('commune/index.html.twig', [
            'communes' => $entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'departements' => $entityManager->getRepository(Departement::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'commune.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $commune = new Commune();
        $form = $this->createForm(CommuneType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commune);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');

            return $this->redirectToRoute('commune.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commune/new.html.twig', [
            'commune' => $commune,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'commune.show', methods: ['GET'])]
    public function show(Commune $commune, DepartementRepository $departementRepository): Response
    {
        return $this->render('commune/show.html.twig', [
            'commune' => $commune,
        ]);
    }

    #[Route('/{id}/edit', name: 'commune.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commune $commune, EntityManagerInterface $entityManager): Response
    {
        $mode = 'edit';
        $form = $this->createForm(CommuneType::class, $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('commune.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commune/edit.html.twig', [
            'commune' => $commune,
            'form' => $form,
            'mode' => $mode,
        ]);
    }


    #[Route('/{id}', name: 'commune.delete', methods: ['POST'])]
    public function delete(Request $request, Commune $commune, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commune->getId(), $request->getPayload()->get('_token'))) {
            $commune->setDeleteAt(new \DateTimeImmutable());
            $entityManager->flush();
            $this->addFlash('success', 'Suppression effectuée avec succès.');
        }

        return $this->redirectToRoute('commune.index', [], Response::HTTP_SEE_OTHER);
    }

/*     #[Route('/{id}', name: 'commune.delete', methods: ['POST'])]
    public function delete(Request $request, Commune $commune, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commune->getId(), $request->getPayload()->get('_token'))) {
            // Vérifiez si l'enregistrement de niveau est associé à une institution
            $demandesCount = $entityManager->getRepository(Departement::class)->count(['commune' => $commune]);
            if ($demandesCount > 0) {
                // Si des institutions sont associées, renvoyez un message d'erreur
                    $this->addFlash('error', 'Vous ne pouvez pas supprimer cette commune car elle est associé à des demandes de véhicule. ');
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
    } */
}
