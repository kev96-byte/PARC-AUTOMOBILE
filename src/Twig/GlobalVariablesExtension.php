<?php
// src/Twig/GlobalVariablesExtension.php

namespace App\Twig;

use App\Repository\DemandeRepository;
use App\Repository\VehiculeRepository;
use http\Client\Curl\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GlobalVariablesExtension extends AbstractExtension
{
    private $vehiculeRepository;
    private $demandeRepository;

    public function __construct(VehiculeRepository $vehiculeRepository, DemandeRepository $demandeRepository)
    {
        $this->vehiculeRepository = $vehiculeRepository;
        $this->demandeRepository = $demandeRepository;
    }




    public function getFunctions(): array
    {
        return [
            new TwigFunction('nombreVehiculesDisponibles', [$this, 'getNombreVehiculesDisponibles']),
            new TwigFunction('nombreTotalVehicules', [$this, 'getNombreTotalVehicules']),
            new TwigFunction('nombreDemandes', [$this, 'getNombreDemandes']),
            new TwigFunction('nombreDemandeVehiculesParUtilisateur', [$this, 'getNombreDemandeVehiculesParUtilisateur']),
        ];
    }

    public function getNombreVehiculesDisponibles(): int
    {
        return $this->vehiculeRepository->countAvailableVehicles();
    }

    public function getNombreTotalVehicules(): int
    {
        return $this->vehiculeRepository->countAllAvailableVehicles();
    }

    public function getNombreDemandes() : int
    {
      return $this->demandeRepository->countAllDemandes();
    }

    public function getNombreDemandeVehiculesParUtilisateur(int $idUtilisateur) : int
    {
       return $this->demandeRepository->countAllDemandesByUser($idUtilisateur);
    }
}
