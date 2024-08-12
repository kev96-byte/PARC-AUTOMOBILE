<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use DateTime;

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

    public function countAvailableVehicles(): int
    {
        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.disponibilite = :disponible')
            ->andWhere('v.deleteAt IS NULL')
            ->andWhere('v.dateFinAssurance > :today')
            ->andWhere('v.dateFinVisiteTechnique > :today')
            ->andWhere('v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial) > 0')
            ->setParameter('disponible', 'Disponible')
            ->setParameter('today', new \DateTime());

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    
public function findAvailableVehiclesWithFilters(
    ?string $dateFinAssurance,
    ?string $dateFinVisiteTechnique,
    ?string $dateDebutPeriode,
    ?string $dateFinPeriode
): array
{
    $qb = $this->createQueryBuilder('v')
        ->where('v.disponibilite = :disponibilite')
        ->setParameter('disponibilite', 'Disponible')
        ->andWhere('v.deleteAt IS NULL')
        ->andWhere('v.dateFinAssurance >= CURRENT_DATE()')
        ->andWhere('v.dateFinVisiteTechnique >= CURRENT_DATE()')
        // Calcul du kilométrage restant
        ->addSelect('v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial) AS HIDDEN kilometrageRestant');

    if ($dateFinAssurance) {
        $qb->andWhere('v.dateFinAssurance <= :dateFinAssurance')
            ->setParameter('dateFinAssurance', $dateFinAssurance);
    }

    if ($dateFinVisiteTechnique) {
        $qb->andWhere('v.dateFinVisiteTechnique <= :dateFinVisiteTechnique')
            ->setParameter('dateFinVisiteTechnique', $dateFinVisiteTechnique);
    }

    if ($dateDebutPeriode && $dateFinPeriode) {
        $qb->andWhere('v.dateFinAssurance BETWEEN :dateDebutPeriode AND :dateFinPeriode')
            ->setParameter('dateDebutPeriode', $dateDebutPeriode)
            ->setParameter('dateFinPeriode', $dateFinPeriode);
    }

    return $qb->getQuery()->getResult();
}




public function findVehiclesExpiringInPeriod(string $period): array
{
    $qb = $this->createQueryBuilder('v')
        ->where('v.disponibilite = :disponibilite')
        ->setParameter('disponibilite', 'Disponible')
        ->andWhere('v.deleteAt IS NULL')
        ->andWhere('v.dateFinAssurance >= CURRENT_DATE()')
        ->andWhere('v.dateFinVisiteTechnique >= CURRENT_DATE()')
        // Calcul du kilométrage restant
        ->addSelect('v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial) AS HIDDEN kilometrageRestant');

    // Définir la date limite en fonction de la période choisie
    switch ($period) {
        case 'month':
            $dateLimit = new DateTime();
            $dateLimit->modify('+1 month');
            break;
        case 'week':
            $dateLimit = new DateTime();
            $dateLimit->modify('+1 week');
            break;
        case 'three_days':
            $dateLimit = new DateTime();
            $dateLimit->modify('+3 days');
            break;
        default:
            throw new \InvalidArgumentException('Période invalide spécifiée');
    }

    $qb->andWhere('v.dateFinAssurance <= :dateLimit')
        ->setParameter('dateLimit', $dateLimit);

    return $qb->getQuery()->getResult();
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
