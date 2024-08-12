<?php
// src/Controller/DashboardController.php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(VehiculeRepository $vehiculeRepository): Response
    {
        $nombreVehiculesDisponibles = $vehiculeRepository->countAvailableVehicles();

        return $this->render('base.html.twig', [
            'nombreVehiculesDisponibles' => $nombreVehiculesDisponibles,
        ]);
    }
}
