<?php 
// src/Service/DemandeService.php
namespace App\Service;

use App\Entity\User;
use App\Repository\DemandeRepository;
use Symfony\Bundle\SecurityBundle\Security;
use RuntimeException;

class DemandeService
{
    private $demandeRepository;
    private $security;

    public function __construct(DemandeRepository $demandeRepository, Security $security)
    {
        $this->demandeRepository = $demandeRepository;
        $this->security = $security;
    }

    public function getNombreDemandesValidees(): int
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new RuntimeException('L\'utilisateur n\'est pas connecté');
        }
        
        $demandes = []; // Initialisation du tableau pour accumuler les demandes

        // Récupération du parc du chef de parc
        $parc = $user->getStructure()->getParc();

        // Récupération des structures associées à ce parc
        $structures = $parc->getStructure();

        // Parcourir chaque structure pour récupérer les demandes
        foreach ($structures as $structure) {
            $structuresdemandes = $this->demandeRepository->findBy([
                'structure' => $structure,
                'traiterPar' => $user,
                'statut' => 'Validé',
                'deleteAt' => null
            ]);

            // Ajouter ces demandes au tableau accumulatif
            $demandes = array_merge($demandes, $structuresdemandes);
        }

        // Compter le nombre de demandes validées
        return count($demandes);
    }
}

