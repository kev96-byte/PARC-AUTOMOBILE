<?php
// src/Controller/ApiController.php

namespace App\Controller;

use App\Entity\TamponVehicules;
use App\Repository\VehiculeRepository;
use App\Repository\ChauffeurRepository;
use App\Repository\DemandeRepository;
use App\Repository\TamponVehiculesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }
    #[Route('/api/available-vehicles-and-drivers', name: 'api_available_vehicles_and_drivers', methods: ['POST'])]
    public function getAvailableVehiclesAndDrivers(
        VehiculeRepository $vehiculeRepo,
        ChauffeurRepository $chauffeurRepo,
        DemandeRepository $demandeRepo,
        Request $request
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $demandeId = $data['demandeId'];
        $demande = $demandeRepo->find($demandeId);
        $dateFinMission = $demande->getDateFinMission();
    
        $user = $this->security->getUser();
        $institutionId = $this->$user->getInstitution();
    
        // Obtenez les véhicules valides directement
        $vehicles = $vehiculeRepo->findBy([
            'institutionId' => $institutionId,
            'disponibilite' => 'Disponible',
            'deleteAt' => null
        ]);
    
        $validVehicles = array_filter($vehicles, function($vehicle) use ($dateFinMission) {
            // Calcul des kilomètres restants pour vidange
            $kilometreRestant = $vehicle->getNbreKmPourRenouvellerVidange() - ($vehicle->getKilometrageCourant() - $vehicle->getKilometrageInitial());
            $vidangeStatus = $kilometreRestant > 0 ? 'OK' : 'KO';
    
            // Déterminez les statuts d'assurance et de visite
            $assuranceStatus = $vehicle->getDateFinAssurance() > $dateFinMission ? 'OK' : 'KO';
            $visiteStatus = $vehicle->getDateFinVisiteTechnique() > $dateFinMission ? 'OK' : 'KO';
    
            // Retourne vrai si le véhicule est valide
            return $assuranceStatus === 'OK' && $visiteStatus === 'OK' && $vidangeStatus === 'OK';
        });
    
        // Préparez les données des véhicules
        $vehiclesData = array_map(function($vehicle) {
            return [
                'id' => $vehicle->getId(),
                'matricule' => $vehicle->getMatricule(),
                'portee' => $vehicle->getPorteeVehicule(),
                'kilometre' => $vehicle->getNbreKmPourRenouvellerVidange() - ($vehicle->getKilometrageCourant() - $vehicle->getKilometrageInitial())
            ];
        }, $validVehicles);
    
        // Récupérez les chauffeurs disponibles
        $drivers = $chauffeurRepo->findBy([
            'institutionId' => $institutionId,
            'disponibilite' => 'Disponible',
            'deleteAt' => null
        ]);
    
        $driversData = array_map(function($driver) {
            return [
                'id' => $driver->getId(),
                'name' => $driver->getNomChauffeur() . ' ' . $driver->getPrenomChauffeur()
            ];
        }, $drivers);
    
        return new JsonResponse(['vehicles' => $vehiclesData, 'drivers' => $driversData]);
    }

}
