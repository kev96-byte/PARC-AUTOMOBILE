<?php
namespace App\Controller;
use App\Entity\Notifications;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Routing\Attribute\Route;


class NotificationsController extends AbstractController{

    #[Route('/notifications', name: 'notifications', methods: ['GET'])]
    public function listNotifications(EntityManagerInterface $em): Response
    {
        // Récupérer les notifications non lues pour l'utilisateur connecté
        $notifications = $em->getRepository(Notifications::class)
            ->findBy(['user' => $this->getUser(), 'isRead' => false], ['createdAt' => 'DESC']);
        
        // Compter le nombre de notifications non lues
        $unreadCount = count($notifications);

        // Passer les notifications et le compte au template
        return $this->render('base.html.twig', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

}

