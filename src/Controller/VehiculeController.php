<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Entity\Institution;
use App\Entity\Utilisateur;
use App\Entity\TypeVehicule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/vehicule')]
#[IsGranted('ROLE_USER')]
class VehiculeController extends AbstractController
{
    #[Route('/', name: 'vehicule.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'typesvehicules' => $entityManager->getRepository(TypeVehicule::class)->findBy(['deleteAt' => null]),
            'vehicules' => $entityManager->getRepository(Vehicule::class)->findBy(['deleteAt' => null]),
            'Institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/etat', name: 'vehicule.etat', methods: ['GET'])]
    public function etat(EntityManagerInterface $entityManager): Response
    {
        return $this->render('vehicule/etat.html.twig', [
            'typesvehicules' => $entityManager->getRepository(TypeVehicule::class)->findBy(['deleteAt' => null]),
            'vehicules' => $entityManager->getRepository(Vehicule::class)->findBy(['deleteAt' => null]),
            'Institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/new', name: 'vehicule.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);
        $file = $form->get('photoVehicule')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
             /** @var UploadedFile $file */
             if ($file) {
                $filename = 'vehicule_'.$vehicule->getMatricule().'.'.$file->guessExtension();
    
                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir').'/public/img/Vehicules',
                        $filename
                    );
                    $vehicule->setPhotoVehicule($filename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
                }
                
             }
             $vehicule->setEtat('En service');
             $vehicule->setDisponibilite('Disponible');
             $entityManager->persist($vehicule);
             $entityManager->flush();
             $this->addFlash('success', 'Ajout effectué avec succès.');
 
             return $this->redirectToRoute('vehicule.index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,

        ]);
    }

    #[Route('/{id}', name: 'vehicule.show', methods: ['GET'])]
    public function show(Vehicule $vehicule, EntityManagerInterface $entityManager, $id): Response
    {
        $vehicule = $entityManager->getRepository(Vehicule::class)->find($id);
    
        if (!$vehicule) {
            throw $this->createNotFoundException('Véhicule introuvable.');
        }
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
            'typesvehicules' => $entityManager->getRepository(TypeVehicule::class)->findBy(['deleteAt' => null]),
            'Institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]),
            'Marques' => $entityManager->getRepository(Marque::class)->findBy(['deleteAt' => null]),
        ]);
    }

    #[Route('/{id}/edit', name: 'vehicule.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        $mode = $vehicule->getId() ? 'edit' : 'add';

        $form = $this->createForm(VehiculeType::class, $vehicule, [
            'mode' => $mode, // Spécifiez le mode du formulaire
        ]);
        $form->get('photoVehiculeUrl')->setData($this->getParameter('kernel.project_dir').'/public/img/Vehicules/'.$vehicule->getPhotoVehicule());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photoVehicule')->getData();

            if ($file) {
                $date = new \DateTime();
                $formattedDate = $date->format('d-m-Y');
                $filename = $formattedDate . '_vehicule_' . $vehicule->getMatricule() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir').'/public/img/Vehicules',
                        $filename
                    );
                    $vehicule->setPhotoVehicule($filename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
                }
            }

            $entityManager->persist($vehicule);
            $entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('vehicule.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
            'mode' => $mode, // Passez la variable 'mode' à votre template Twig
        ]);
    }


    #[Route('/{id}', name: 'vehicule.delete', methods: ['POST'])]
    public function delete(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->getPayload()->get('_token'))) {
            // Vérifiez si l'enregistrement de niveau est associé à une institution
/*             $urilisateursCount = $entityManager->getRepository(Utilisateur::class)->count(['vehicule' => $vehicule]);
            if ($urilisateursCount > 0) {
                // Si des institutions sont associées, renvoyez un message d'erreur
                    $this->addFlash('error', 'Vous ne pouvez pas supprimer ce véhicule car il est associé à des demandes. ');
                // $this->addFlash('notice', 'Hello world');
            } else {
                // Sinon, supprimez l'enregistrement de niveau
                // $entityManager->remove($niveau);
                $vehicule->setDeleteAt(new \DateTimeImmutable());
                $entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            } */
            $vehicule->setDeleteAt(new \DateTimeImmutable());
            $entityManager->flush();
            $this->addFlash('success', 'Suppression effectuée avec succès.');
        }
    
        return $this->redirectToRoute('vehicule.index', [], Response::HTTP_SEE_OTHER);
    }
}
