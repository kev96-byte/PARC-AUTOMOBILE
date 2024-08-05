<?php

namespace App\Repository;

use App\Entity\Commune;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commune>
 */
class CommuneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commune::class);
    }

    //    /**
    //     * @return Commune[] Returns an array of Commune objects
    //     */

    public function findActiveCommunesFormatted(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select("CONCAT('Commune ', UPPER(c.libelleCommune), ' (', d.region, ')') as formattedCommune, c.libelleCommune")
            ->join('c.departement', 'd')
            ->where('c.deleteAt IS NULL')
            ->orderBy('c.libelleCommune', 'ASC');
    
        $result = $qb->getQuery()->getResult();
    
        $communeChoices = [];
        foreach ($result as $row) {
            $communeChoices[$row['formattedCommune']] = $row['libelleCommune'];
        }
    
        return $communeChoices;
    }

    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Commune
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
