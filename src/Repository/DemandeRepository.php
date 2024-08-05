<?php
// src/Repository/DemandeRepository.php

namespace App\Repository;

use App\Entity\Demande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demande::class);
    }

    public function findExpiredMissions()
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('d')
            ->where('d.dateFinMission < :now')
            ->andWhere('d.dateEffectiveFinMission IS NULL')
            ->andWhere('d.statut = :statut') // Ajouter la condition pour le statut
            ->setParameter('now', $now)
            ->setParameter('statut', 'Validé') // Définir la valeur du statut
            ->getQuery()
            ->getResult();
        
    }
}
