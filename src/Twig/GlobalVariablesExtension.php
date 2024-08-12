<?php
// src/Twig/GlobalVariablesExtension.php

namespace App\Twig;

use App\Repository\VehiculeRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GlobalVariablesExtension extends AbstractExtension
{
    private $vehiculeRepository;

    public function __construct(VehiculeRepository $vehiculeRepository)
    {
        $this->vehiculeRepository = $vehiculeRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('nombreVehiculesDisponibles', [$this, 'getNombreVehiculesDisponibles']),
        ];
    }

    public function getNombreVehiculesDisponibles(): int
    {
        return $this->vehiculeRepository->countAvailableVehicles();
    }
}
