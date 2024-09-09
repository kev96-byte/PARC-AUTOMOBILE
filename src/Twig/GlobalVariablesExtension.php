<?php
// src/Twig/GlobalVariablesExtension.php

namespace App\Twig;

use AllowDynamicProperties;
use App\Repository\AffecterRepository;
use App\Repository\DemandeRepository;
use App\Repository\VehiculeRepository;
use http\Client\Curl\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

#[AllowDynamicProperties] class GlobalVariablesExtension extends AbstractExtension
{
    private $vehiculeRepository;
    private $demandeRepository;
    private $affecterRepository;

    public function __construct(VehiculeRepository $vehiculeRepository, DemandeRepository $demandeRepository, AffecterRepository $affecterRepository)
    {
        $this->vehiculeRepository = $vehiculeRepository;
        $this->demandeRepository = $demandeRepository;
        $this->affecterRepository = $affecterRepository;
    }




    public function getFunctions(): array
    {
        return [
            new TwigFunction('nombreVehiculesDisponibles', [$this, 'getNombreVehiculesDisponibles']),
            new TwigFunction('nombreTotalVehicules', [$this, 'getNombreTotalVehicules']),
            new TwigFunction('nombreDemandes', [$this, 'getNombreDemandes']),
            new TwigFunction('nombreDemandeVehiculesParUtilisateur', [$this, 'getNombreDemandeVehiculesParUtilisateur']),
            new TwigFunction('lieuVehiculeMission', [$this, 'getLieuVehiculeMission']),
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

    public function getLieuVehiculeMission(int $idVehicule) : array
    {
        $lieux = $this->affecterRepository->findLieuxByVehiculeId($idVehicule);
        return array_column($lieux, 'lieu');
    }
}
