<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Entity\Institution;
use App\Entity\Utilisateur;
use App\Entity\TypeVehicule;
use App\Repository\VehiculeRepository;
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


    #[Route('/nonassurres', name: 'vehicule.nonassurres', methods: ['GET'])]
    public function nonassurres(VehiculeRepository $vehiculeRepository, EntityManagerInterface $entityManager): Response
    {
        // Requête pour récupérer les véhicules dont la dateFinAssurance est null
        $qb = $vehiculeRepository->createQueryBuilder('v')
            ->where('v.dateFinAssurance IS NULL') // Vérifie si la dateFinAssurance est null
            ->andWhere('v.deleteAt IS NULL')
            ->getQuery();

        $vehiculesNonAssures = $qb->getResult();

        return $this->render('vehicule/index.html.twig', [
            'typesvehicules' => $entityManager->getRepository(TypeVehicule::class)->findBy(['deleteAt' => null]),
            'vehicules' => $vehiculesNonAssures, // Passer les véhicules à la vue
            'Institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]),
        ]);
    }


    #[Route('/nonvisites', name: 'vehicule.nonvisites', methods: ['GET'])]
    public function nonvisites(VehiculeRepository $vehiculeRepository, EntityManagerInterface $entityManager): Response
    {
        // Requête pour récupérer les véhicules dont la dateFinAssurance est null
        $qb = $vehiculeRepository->createQueryBuilder('v')
            ->where('v.dateFinVisiteTechnique IS NULL') // Vérifie si la dateFinAssurance est null
            ->andWhere('v.deleteAt IS NULL')
            ->getQuery();

        $vehiculesNonAssures = $qb->getResult();

        return $this->render('vehicule/index.html.twig', [
            'typesvehicules' => $entityManager->getRepository(TypeVehicule::class)->findBy(['deleteAt' => null]),
            'vehicules' => $vehiculesNonAssures, // Passer les véhicules à la vue
            'Institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]),
        ]);
    }


    #[Route('/vidangevalides', name: 'vehicule.vidangevalides', methods: ['GET'])]
    public function valides(VehiculeRepository $vehiculeRepository): Response
    {
        $qb = $vehiculeRepository->createQueryBuilder('v')
            ->select('v')
            ->Where('(v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial)) > 0')
            ->getQuery();

        $vehiculesAvecVidangeAjour = $qb->getResult();

        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehiculesAvecVidangeAjour,
        ]);
    }


    #[Route('/vidangenonvalides', name: 'vehicule.vidangenonvalides', methods: ['GET'])]
    public function vidangenonvalides(VehiculeRepository $vehiculeRepository): Response
    {
        $qb = $vehiculeRepository->createQueryBuilder('v')
            ->select('v')
            ->Where('(v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial)) <= 0')
            ->getQuery();

        $vehiculesAvecVidangeNonAjour = $qb->getResult();

        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehiculesAvecVidangeNonAjour,
        ]);
    }


    #[Route('/sansvidange', name: 'vehicule.sansvidange', methods: ['GET'])]
    public function sansvidange(VehiculeRepository $vehiculeRepository, EntityManagerInterface $entityManager): Response
    {
        // Requête pour récupérer les véhicules dont la dateFinAssurance est null
        $qb = $vehiculeRepository->createQueryBuilder('v')
            ->where('v.dateVidange IS NULL') // Vérifie si la dateFinAssurance est null
            ->andWhere('v.deleteAt IS NULL')
            ->getQuery();

        $vehiculesSansVidange = $qb->getResult();

        return $this->render('vehicule/index.html.twig', [
            'typesvehicules' => $entityManager->getRepository(TypeVehicule::class)->findBy(['deleteAt' => null]),
            'vehicules' => $vehiculesSansVidange, // Passer les véhicules à la vue
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
            $vehicule->setDeleteAt(new \DateTimeImmutable());
            $entityManager->flush();
            $this->addFlash('success', 'Suppression effectuée avec succès.');
        }

        return $this->redirectToRoute('vehicule.index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/disponibles', name: 'vehicules.disponibles')]
    public function disponibles(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        // Récupérer les valeurs de filtrage depuis la requête
        $dateFinAssurance = $request->query->get('dateFinAssurance');
        $dateFinVisiteTechnique = $request->query->get('dateFinVisiteTechnique');
        $dateDebutPeriode = $request->query->get('dateDebutPeriode');
        $dateFinPeriode = $request->query->get('dateFinPeriode');

        // Requête pour récupérer les véhicules disponibles avec filtres
        $vehicules = $vehiculeRepository->findAvailableVehiclesWithFilters(
            $dateFinAssurance,
            $dateFinVisiteTechnique,
            $dateDebutPeriode,
            $dateFinPeriode
        );

        return $this->render('vehicule/disponibles.html.twig', [
            'vehicules' => $vehicules,
            'dateFinAssurance' => $dateFinAssurance,
            'dateFinVisiteTechnique' => $dateFinVisiteTechnique,
            'dateDebutPeriode' => $dateDebutPeriode,
            'dateFinPeriode' => $dateFinPeriode,
        ]);
    }



    #[Route('/nondisponibles', name: 'vehicules.nondisponibles')]
    public function nondisponibles(VehiculeRepository $vehiculeRepository): Response
    {
        // Requête pour récupérer les véhicules disponibles avec filtres
        $vehicules = $vehiculeRepository->findNOAvailableVehicles();

        return $this->render('vehicule/nondisponibles.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }

    #[Route('/mission', name: 'vehicule.mission', methods: ['GET'])]
    public function mission(EntityManagerInterface $entityManager, VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'typesvehicules' => $entityManager->getRepository(TypeVehicule::class)->findBy(['deleteAt' => null]),
            'vehicules' => $vehiculeRepository->findVehiclesInMission(),
            'Institutions' => $entityManager->getRepository(Institution::class)->findBy(['deleteAt' => null]),
            ]);
        }

}
