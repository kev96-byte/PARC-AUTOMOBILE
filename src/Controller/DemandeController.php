<?php

namespace App\Controller;

use Date;
use DateTime;
use App\Entity\User;
use App\Entity\Commune;
use App\Entity\Demande;
use App\Form\DemandeType;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\Clock\now;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

#[Route('/demande')]
class DemandeController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }
    
    #[Route('/', name: 'demande.index', methods: ['GET'])]
    public function index(): Response
    {

        $user = $this->getUser();
        $roles = $user->getRoles();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('L\'utilisateur nest pas connecté');
        }

        if (in_array('ROLE_POINT_FOCAL', $roles)) {
            $demandes = $this->entityManager->getRepository(Demande::class)->findBy([
                'demander' => $user,
                'deleteAt' => null,
            ]);       
        } elseif (in_array('ROLE_RESPONSABLE_STRUCTURE', $roles)) {
            $structure = $user->getStructure();
            // Vérifier si la structure existe
            if (!$structure) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune structure');
            }

            $structureId = $structure->getId();

            $institution = $user->getInstitution();
            if (!$institution) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
            }

            $institutionId = $institution->getId();

            $demandes = $this->entityManager->getRepository(Demande::class)->createQueryBuilder('d')
            ->join('d.demander', 'u')
            ->join('u.structure', 's')
            ->join('u.institution', 'i')
            ->where('s.id = :structureId')
            ->andWhere('i.id = :institutionId')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('structureId', $structureId)
            ->setParameter('institutionId', $institutionId)
            ->getQuery()
            ->getResult();

        }  elseif (in_array('ROLE_CABINET', $roles)) {
            $institution = $user->getInstitution();
            if (!$institution) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
            }

            $institutionId = $institution->getId();

            $demandes = $this->entityManager->getRepository(Demande::class)->createQueryBuilder('d')
            ->join('d.demander', 'u')
            ->join('u.institution', 'i')
            ->where('i.id = :institutionId')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('institutionId', $institutionId)
            ->getQuery()
            ->getResult();

        }elseif (in_array('ROLE_CHEF_PARC', $roles)) {
            $institution = $user->getInstitution();
            if (!$institution) {
                throw $this->createNotFoundException('Cet utilisateur n\'est associé à aucune institution');
            }

            $institutionId = $institution->getId();

            $demandes = $this->entityManager->getRepository(Demande::class)->createQueryBuilder('d')
            ->join('d.demander', 'u')
            ->join('u.institution', 'i')
            ->where('i.id = :institutionId')
            ->andWhere('d.deleteAt IS NULL')
            ->andWhere('d.statut = :statut  ')
            ->setParameter('institutionId', $institutionId)
            ->setParameter('statut', 'Approuvé')
            ->getQuery()
            ->getResult();

        }
        elseif (in_array('ROLE_ADMIN', $roles)) {
            $demandes = $this->entityManager->getRepository(Demande::class)->findBy(['deleteAt' => null,]);
        } else {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette ressource.');
        }
        
        return $this->render('demande/index.html.twig', [            
            'communes' => $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]),
            'users' => $this->entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
            'demandes' => $demandes,           

        ]);
    }

    #[Route('/new', name: 'demande.create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_POINT_FOCAL')]
    public function new(Request $request): Response
    {

        $communes = $this->entityManager->getRepository(Commune::class)->findBy(['deleteAt' => null]);
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->security->getUser();

            if ($user) {
                $demande->setDemander($user);
            } else {
                // Gérer le cas où l'utilisateur n'est pas authentifié
                throw new \Exception('Utilisateur non authentifié');
            }

            // $utilisateur = $entityManager->getRepository(Utilisateur::class)->find(2);

            
            $communes = $this->entityManager->getRepository(Commune::class)->findBy(['id' => '2']);
            $dateDemandeStr = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
            $dateDemande = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dateDemandeStr);
            $demande->setDateDemande($dateDemande);
            $demande->setStatut('Initial');
            $demande->setLieuMission(["PORTO-NOVO", "GRAND POPO", "OUIDAH"]);
            $this->entityManager->persist($demande);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');

            return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demande/new.html.twig', [
            'communes' => $communes,
            'demande' => $demande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'demande.show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }

    #[Route('/{id}/edit', name: 'demande.edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_POINT_FOCAL')]
    public function edit(Request $request, Demande $demande): Response
    {
        if ($demande->getStatut() !== 'Initial') {
            $this->addFlash('error', 'Vous ne pouvez modifier une demande que si son statut est "Initial".');
            return $this->redirectToRoute('demande.index');
        }

        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }





    #[Route('/{id}/approve', name: 'demande.approve', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_RESPONSABLE_STRUCTURE')]
    public function approve(Demande $demande): Response
    {
        if ($demande->getStatut() !== 'Initial') {
            $this->addFlash('error', 'Vous ne pouvez approuver une demande que si son statut est "Initial".');
            return $this->redirectToRoute('demande.index');
        } else {
            $this->entityManager->flush();
            $this->addFlash('success', 'Modification effectuée avec succès.');
        }

        return $this->redirectToRoute('demande.index');
    }


    #[Route('/{id}/dismiss', name: 'demande.dismiss', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_RESPONSABLE_STRUCTURE')]
    public function dismiss(Request $request, Demande $demande): Response
    {
        $this->denyAccessUnlessGranted('ROLE_RESPONSABLE_STRUCTURE', null, 'Access denied.');

        if ($request->isMethod('POST')) {
            $raisonRejetApprobation = $request->request->get('raisonRejetApprobation');
            $demande->setRaisonRejetApprobation($raisonRejetApprobation);
            $demande->setStatut('Rejeté');
            $demande->setValidateurStructure($this->getUser());

            $this->entityManager->flush();

            $this->addFlash('success', 'Demande rejetée avec succès.');
        }

        return $this->redirectToRoute('demande.index');
    }





    #[Route('/{id}', name: 'demande.delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->getPayload()->get('_token'))) {
            if ($demande->getStatut() !== 'Initial') {
                $this->addFlash('error', 'Vous ne pouvez supprimer une demande que si son statut est "Initial".');
            } else {
                $demande->setDeleteAt(new \DateTimeImmutable());
                $this->entityManager->flush();
                $this->addFlash('success', 'Suppression effectuée avec succès.');
            }
        }
    
        return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
    }

}


