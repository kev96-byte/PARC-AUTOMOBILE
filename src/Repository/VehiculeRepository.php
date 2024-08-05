<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicule>
 */
class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }

    public function findAvailableVehicles(\DateTimeInterface $dateFinMission): array
    {
        return $this->createQueryBuilder('v')
            ->where('v.dateFinAssurance > :dateFinMission')
            ->andWhere('v.dateFinVisiteTechnique > :dateFinMission')
            ->andWhere('(v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial)) > 0')
            ->andWhere('v.disponibilite = :disponibilite')
            ->andWhere('v.deleteAt IS NULL')
            ->setParameter('dateFinMission', $dateFinMission)
            ->setParameter('disponibilite', 'Disponible')
            ->getQuery()
            ->getResult();
    }
    

    //    /**
    //     * @return Vehicule[] Returns an array of Vehicule objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vehicule
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
