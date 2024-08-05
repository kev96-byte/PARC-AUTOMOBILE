<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Entity\TypeVehicule;
use App\Form\TypeVehiculeType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TypeVehiculeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/type/vehicule')]
#[IsGranted('ROLE_USER')]
class TypeVehiculeController extends AbstractController
{
    #[Route('/', name: 'TypeVehicule.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('type_vehicule/index.html.twig', [
            'type_vehicules' => $entityManager->getRepository(TypeVehicule::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'TypeVehicule.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $typeVehicule = new TypeVehicule();
        $form = $this->createForm(TypeVehiculeType::class, $typeVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeVehicule);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute('TypeVehicule.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_vehicule/new.html.twig', [
            'type_vehicule' => $typeVehicule,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/{id}', name: 'TypeVehicule.show', methods: ['GET'])]
    public function show(TypeVehicule $typeVehicule): Response
    {
        return $this->render('type_vehicule/show.html.twig', [
            'type_vehicule' => $typeVehicule,
        ]);
    }

    #[Route('/{id}/edit', name: 'TypeVehicule.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeVehicule $typeVehicule, EntityManagerInterface $entityManager): Response
    {
        $mode = 'edit';
        $form = $this->createForm(TypeVehiculeType::class, $typeVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('TypeVehicule.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_vehicule/edit.html.twig', [
            'type_vehicule' => $typeVehicule,
            'form' => $form,
            'mode' => $mode,
        ]);
    }

/*     #[Route('/{id}', name: 'TypeVehicule.delete', methods: ['POST'])]
    public function delete(Request $request, TypeVehicule $typeVehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeVehicule->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($typeVehicule);
            $entityManager->flush();
            $this->addFlash('success', 'Suppression effectuée avec succès.');
        }

        return $this->redirectToRoute('TypeVehicule.index', [], Response::HTTP_SEE_OTHER);
    } */





    #[Route('/{id}', name: 'TypeVehicule.delete', methods: ['POST'])]
    public function delete(Request $request, TypeVehicule $typeVehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeVehicule->getId(), $request->getPayload()->get('_token'))) {
            // Vérifiez si l'enregistrement de niveau est associé à une institution
            $vehiculesCount = $entityManager->getRepository(Vehicule::class)->count(['typeVehicule' => $typeVehicule]);
            if ($vehiculesCount > 0) {
                // Si des institutions sont associées, renvoyez un message d'erreur
                    $this->addFlash('error', 'Vous ne pouvez pas supprimer ce type de vmatériel roulant car il est associé à des matériaux roulants. ');
                // $this->addFlash('notice', 'Hello world');
            } else {
                // Sinon, supprimez l'enregistrement de niveau
                // $entityManager->remove($niveau);
                $typeVehicule->setDeleteAt(new \DateTimeImmutable());
                $entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            }
        }
    
        return $this->redirectToRoute('TypeVehicule.index', [], Response::HTTP_SEE_OTHER);
    }

}
