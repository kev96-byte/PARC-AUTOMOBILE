<?php

namespace App\Repository;

use App\Entity\Dommage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dommage>
 */
class DommageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dommage::class);
    }


    public function findDommagesWithChauffeurAndVehicule(): array
    {
        return $this->createQueryBuilder('d')
            ->select('d', 'chauffeur', 'vehicule')
            ->join('d.chauffeur', 'chauffeur')
            ->join('d.vehicule', 'vehicule')
            ->where('d.chauffeur IS NOT NULL')
            ->andWhere('d.vehicule IS NOT NULL')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Dommage[] Returns an array of Dommage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Dommage
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
