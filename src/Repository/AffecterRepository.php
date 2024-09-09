<?php

namespace App\Repository;

use App\Entity\Affecter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Affecter>
 */
class AffecterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affecter::class);
    }


    public function findDemandesByChauffeurId(int $chauffeurId): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.demande', 'd')
            ->where('a.chauffeur = :chauffeurId')
            ->setParameter('chauffeurId', $chauffeurId)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Affecter[] Returns an array of Affecter objects
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

    //    public function findOneBySomeField($value): ?Affecter
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findLieuxByVehiculeId(int $vehiculeId): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.demande', 'd')  // Joindre la table des demandes pour accéder au lieu
            ->select('d.lieuMission')  // Sélectionner uniquement le champ "lieu" de la demande
            ->where('a.vehicule = :vehiculeId')  // Filtrer par l'ID du véhicule
            ->setParameter('vehiculeId', $vehiculeId)
            ->getQuery()
            ->getResult();
    }


}
