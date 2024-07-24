<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[IsGranted('ROLE_USER')]
class MainController extends AbstractController
{
    #[Route('/', name: 'main.index')]

    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
/*         $user = new User();
        $user->setlastName('BOKO')
             ->setfirstName('Elodie')
             ->setUsername('meboko')
             ->setEmail('meboko@gouv.bj')
             ->setPassword($hasher->hashPassword($user,'0000'))
             ->setRoles([])
             ->setstatutCompte('INITIAL')
             ->setMatricule('112345');
             $em->persist($user);
             $em->flush();  */
                         
        return $this->render('base.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
