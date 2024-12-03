<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof NotFoundHttpException) {
            return;
        }

        $request = $event->getRequest();

        $request = $request->duplicate(null, null, ['_controller' => 'App\Controller\ErrorController::show']);

        $response = $event->getKernel()->handle($request, HttpKernelInterface::SUB_REQUEST, false);

        $event->setResponse($response);
    }
}

