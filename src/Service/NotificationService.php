<?php
//namespace App\Service;
//use Doctrine\ORM\EntityManagerInterface;
//use App\Entity\User;
//use App\Entity\Notifications;
//use Symfony\Bundle\SecurityBundle\Security;
//use Symfony\Component\Notifier\Notification\Notification;
//
//
//class NotificationService
//{
//    public function __construct(EntityManagerInterface $em, Security $security){
//        $this->em = $em;
//        $this->security = $security;
//    }
//    public function sendNotification(string $role, string $message, $demande): void
//    {
//        $users = $this->em->getRepository(User::class)->findAll();
//
//        foreach ($users as $user) {
//            $notification = new Notifications();
//            $notification->setUser($user);
//            $notification->setMessage($message);
//            $notification->setRead(false);
//            $notification->setCreatedAt(new \DateTimeImmutable());
//
//            $this->em->persist($notification);
//        }
//
//        $this->em->flush();
//    }
//}


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Notifications;
use Symfony\Bundle\SecurityBundle\Security;

class NotificationService
{
    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function sendNotification(string $role, string $message, $demande): void
    {
        $demandeur = $this->security->getUser();
        if (!$demandeur) {
            return; // Assure que l'utilisateur est authentifié
        }

        $structure = $demandeur->getStructure(); // Récupère la structure de l'utilisateur demandeur

        // Trouver les utilisateurs ayant le rôle spécifié et la même structure que le demandeur
        $users = $this->em->getRepository(User::class)->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->andWhere('u.structure = :structure')
            ->setParameter('role', '%' . $role . '%')
            ->setParameter('structure', $structure)
            ->getQuery()
            ->getResult();

        foreach ($users as $user) {
            $notification = new Notifications();
            $notification->setUser($user);
            $notification->setMessage($message);
            $notification->setRead(false);
            $notification->setCreatedAt(new \DateTimeImmutable());

            $this->em->persist($notification);
        }

        $this->em->flush();
    }


}
