<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Demande;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[Route('/registration')]
class RegistrationController extends AbstractController
{
    private $entityManager;
    public function __construct(private EmailVerifier $emailVerifier, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/', name: 'user.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {

        return $this->render('registration/index.html.twig', [
            'users' => $entityManager->getRepository(User::class)->findBy(['deleteAt' => null]),
        ]);
    }


    #[Route('/new', name: 'user.create')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $mode = 'add';
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout effectué avec succès.');
            return $this->redirectToRoute('user.index', [], Response::HTTP_SEE_OTHER);

            // generate a signed url and email it to the user
/*             $this->emailVerifier->sendEmailConfirmation('²&_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('meboko@gouv.bj', 'Support'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            ); */

            // do anything else you need here, like send an email

        }

        return $this->render('registration/new.html.twig', [
            'user' => $user,
            'registrationForm' => $form,
            'mode' => $mode,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('user.index');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('user.index');
    }



    #[Route('/{id}/edit', name: 'user.edit')]
    public function edit(int $id, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw new NotFoundHttpException('Cet utilisateur n\'existe pas');
        }

        // Optional: Check if the current user has permission to edit this user
        // $this->denyAccessUnlessGranted('edit', $user);

        $mode = 'edit';
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData()) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }

            $entityManager->flush();

            $this->addFlash('success', 'Modification effectuée avec succès.');

            return $this->redirectToRoute('user.index', ['id' => $user->getId()]);
        }

        return $this->render('registration/edit.html.twig', [
            'registrationForm' => $form->createView(),
            'user' => $user,
        ]);
    }




#[Route('/{id}', name: 'user.delete', methods: ['POST'])]
    public function delete(int $id, Request $request): Response
    {        
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }
        $token = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $token)) {
        // Build the query to check if the user has any associated Demande records
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('count(d.id)')
            ->from(Demande::class, 'd')
            ->where('d.demander = :user')
            ->orWhere('d.demandesValidateurs = :user')
            ->orWhere('d.demandesTraiteur = :user')
            ->setParameter('user', $user);
        
        $userInterventionCount = $qb->getQuery()->getSingleScalarResult();

        if ($userInterventionCount > 0) {
            throw new AccessDeniedHttpException('Vous ne pouvez pas supprimer un utilisateur associé à une demande de véhicule.');
        } else {
            $user->setDeleteAt(new \DateTimeImmutable());
            $this->entityManager->flush();
            $this->addFlash('success', 'Suppression effectuée avec succès.');
        }

        } else {
            $this->addFlash('error', 'Jeton CSRF invalide.');
        }
    
        return $this->redirectToRoute('demande.index', [], Response::HTTP_SEE_OTHER);
    }
    






}
