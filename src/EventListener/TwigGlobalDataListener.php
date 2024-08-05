<?php
// src/EventListener/TwigGlobalDataListener.php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Service\DemandeService;

class TwigGlobalDataListener implements EventSubscriberInterface
{
    private $demandeService;

    public function __construct(DemandeService $demandeService)
    {
        $this->demandeService = $demandeService;
    }

    public function onKernelView(ViewEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        // Ajoutez des données globales dans la réponse avant le rendu du template
        $response->headers->set('X-Nombre-Demandes-Validees', $this->demandeService->getNombreDemandesValidees());
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => 'onKernelView',
        ];
    }
}
