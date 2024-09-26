<?php

namespace App\Repository;

use App\Entity\Assurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Assurance>
 */
class AssuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assurance::class);
    }

    public function findLatestByVehicule($vehiculeId)
    {
        return $this->createQueryBuilder('a')
            ->where('a.vehicule = :vehiculeId')
            ->setParameter('vehiculeId', $vehiculeId)
            ->orderBy('a.dateFinAssurance', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }



    public function countAssurancesNonvalides(): int
    {
        $qb = $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.dateFinAssurance < :today') // Assurance non valide
            ->andWhere('a.dateFinAssurance = (
            SELECT MAX(a2.dateFinAssurance)
            FROM App\Entity\Assurance a2
            WHERE a2.vehicule = a.vehicule
        )') // Dernière assurance pour chaque véhicule
            ->setParameter('today', new \DateTime());
        return (int) $qb->getQuery()->getSingleScalarResult();

    }

    //    /**
    //     * @return Assurance[] Returns an array of Assurance objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Assurance
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
