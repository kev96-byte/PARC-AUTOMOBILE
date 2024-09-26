<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }


    public function findLatestByVehicule($vehiculeId)
    {
        return $this->createQueryBuilder('v')
            ->where('v.vehicule = :vehiculeId')
            ->setParameter('vehiculeId', $vehiculeId)
            ->orderBy('v.dateFinVisite', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countVisitesNonvalides(): int
    {
        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.dateFinVisite < :today') // Visite valide
            ->andWhere('v.dateFinVisite = (
            SELECT MAX(v2.dateFinVisite)
            FROM App\Entity\Visite v2
            WHERE v2.vehicule = v.vehicule
        )') // Dernière visite pour chaque véhicule
            ->setParameter('today', new \DateTime());
        return (int) $qb->getQuery()->getSingleScalarResult();

    }



    //    /**
    //     * @return Visite[] Returns an array of Visite objects
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

    //    public function findOneBySomeField($value): ?Visite
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
