<?php

namespace App\Controller;

use App\Entity\Chauffeur;
use App\Entity\Institution;
use App\Form\ChauffeurType;
use App\Repository\AffecterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
        $file = $form->get('photoChauffeur')->getData();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photoChauffeur')->getData();
            if ($file) {
                $filename = '_chauffeur_' . $chauffeur->getMatriculeChauffeur() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir').'/public/img/Chauffeurs',
                        $filename
                    );
                $chauffeur->setPhotoChauffeur($filename);
                $chauffeur->setetatChauffeur('En service');
                $chauffeur->setDisponibilite('Disponible');
                $entityManager->persist($chauffeur);
                $entityManager->flush();
                $this->addFlash('success', 'Ajout effectué avec succès.');

                return $this->redirectToRoute('chauffeur.index', [], Response::HTTP_SEE_OTHER);
            } catch (FileException $e) {
                $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
        }
    }
        }

        return $this->render('chauffeur/new.html.twig', [
            'chauffeur' => $chauffeur,
            'form' => $form,
        ]);
    }

    
    #[Route('/chauffeur/{id}', name: 'chauffeur.show', methods: ['GET'])]
    public function show(Chauffeur $chauffeur, AffecterRepository $affecterRepository): Response
    {
        // Récupérer les affectations pour le chauffeur
        $affectations = $affecterRepository->findBy(['chauffeur' => $chauffeur]);

        // Récupérer les demandes associées à ces affectations
        $demandes = [];
        foreach ($affectations as $affectation) {
            $demandes[] = $affectation->getDemande();
        }

        return $this->render('chauffeur/show.html.twig', [
            'chauffeur' => $chauffeur,
            'demandes' => $demandes,
        ]);
    }

    #[Route('/{id}/edit', name: 'chauffeur.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chauffeur $chauffeur, EntityManagerInterface $entityManager): Response
    {
        $mode = $chauffeur->getId() ? 'edit' : 'add';

        $form = $this->createForm(ChauffeurType::class, $chauffeur, [
            'mode' => $mode, // Spécifiez le mode du formulaire
        ]);
        $form->get('photoChauffeurUrl')->setData($this->getParameter('kernel.project_dir').'/public/img/Chauffeurs/'.$chauffeur->getPhotoChauffeur());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photoChauffeur')->getData();
            if ($file) {
                $filename = '_chauffeur_' . $chauffeur->getMatriculeChauffeur() . '.' . $file->guessExtension();
                dump ($filename) ;
                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir').'/public/img/Chauffeurs',
                        $filename
                    );
                    $chauffeur->setPhotoChauffeur($filename);

                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
                }
            }

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
