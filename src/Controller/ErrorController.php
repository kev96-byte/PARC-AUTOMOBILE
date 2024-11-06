<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error404", name="error404")
     */
    public function show(NotFoundHttpException $exception = null): Response
    {
        if (!$exception) {
            $exception = new NotFoundHttpException('Page not found');
        }

        return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
            'message' => $exception->getMessage()
        ], new Response('', 404));
    }
}