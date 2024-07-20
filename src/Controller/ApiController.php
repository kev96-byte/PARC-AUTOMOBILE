<?php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use App\Repository\ChauffeurRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/api/available-vehicles-and-drivers', name: 'api_available_vehicles_and_drivers', methods: ['POST'])]
    public function getAvailableVehiclesAndDrivers(VehiculeRepository $vehiculeRepo, ChauffeurRepository $chauffeurRepo): JsonResponse
    {
        $user = $this->security->getUser();
        $institutionId = $this->$user->getInstitution();

        $vehicles = $vehiculeRepo->findBy([
            'institutionId' => $institutionId,
            'disponibilite' => 'Disponible',
            'deleteAt' => null
        ]);

        $drivers = $chauffeurRepo->findBy([
            'institutionId' => $institutionId,
            'disponibilite' => 'Disponible',
            'deleteAt' => null
        ]);

        $vehiclesData = array_map(function($vehicle) {
            return [
                'id' => $vehicle->getId(),
                'matricule' => $vehicle->getMatricule()
            ];
        }, $vehicles);

        $driversData = array_map(function($driver) {
            return [
                'id' => $driver->getId(),
                'name' => $driver->getLastName() . ' ' . $driver->getFirstName()
            ];
        }, $drivers);

        return new JsonResponse(['vehicles' => $vehiclesData, 'drivers' => $driversData]);
    }
}
