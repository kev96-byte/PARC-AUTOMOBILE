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
            ->andWhere('v.etat = :etat')
            ->andWhere('v.deleteAt IS NULL')
            ->setParameter('dateFinMission', $dateFinMission)
            ->setParameter('etat', 'En service')
            ->getQuery()
            ->getResult();
    }


    public function findActiveVehiculesFormatted(): array
    {
        $qb = $this->createQueryBuilder('v')
            ->select("v.matricule as formattedVehicule, v.matricule")
            ->where('v.etat = :etat')
            ->andWhere('v.deleteAt IS NULL')
            ->setParameter('etat', 'En service')
            ->orderBy('v.matricule', 'ASC');
    
        $result = $qb->getQuery()->getResult();
    
        $vehiculeChoices = [];
        foreach ($result as $row) {
            $vehiculeChoices[$row['formattedVehicule']] = $row['matricule'];
        }
    
        return $vehiculeChoices;
    }
    

    public function findVehiculesDisponibles(\DateTimeInterface $dateDebutMission, \DateTimeInterface $dateFinMission, $parc)
    {
        // Sous-requête pour trouver les véhicules déjà affectés pendant la période
        $subQuery = $this->createQueryBuilder('v2')
            ->select('v2.id')
            ->innerJoin('v2.affecters', 'a')
            ->where('a.dateDebutMission BETWEEN :dateDebut AND :dateFin')
            ->orWhere('a.dateFinMission BETWEEN :dateDebut AND :dateFin')
            ->orWhere(':dateDebut BETWEEN a.dateDebutMission AND a.dateFinMission')
            ->orWhere(':dateFin BETWEEN a.dateDebutMission AND a.dateFinMission');
    
            // Requête principale pour trouver les véhicules disponibles
            $qb = $this->createQueryBuilder('v');

            $qb->where('v.deleteAt IS NULL')
            ->andWhere('v.dateFinAssurance > :dateFinMission')
            ->andWhere('v.dateFinVisiteTechnique > :dateFinMission')
            ->andWhere('v.etat = :etat')
            ->andWhere('v.parc = :parc')
            ->andWhere('(v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial)) > 0')
            ->andWhere($qb->expr()->notIn('v.id', $subQuery->getDQL()))
            ->setParameter('dateDebut', $dateDebutMission)
            ->setParameter('dateFin', $dateFinMission)
            ->setParameter('dateFinMission', $dateFinMission)
            ->setParameter('etat', 'En service')
            ->setParameter('parc', $parc);
    
        return $qb->getQuery()->getResult();
    }


    public function findAvailableVehicles2(): array
    {
        return $this->createQueryBuilder('v')
            ->where('v.etat = :etat')
            ->andWhere('v.deleteAt IS NULL')
            ->andWhere('v.dateFinAssurance > :today')
            ->andWhere('v.dateFinVisiteTechnique > :today')
            ->andWhere('v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial) > 0')
            ->setParameter('etat', 'En service')
            ->setParameter('today', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function countAvailableVehicles(): int
    {
        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->andWhere('v.etat = :etat')
            ->andWhere('v.deleteAt IS NULL')
            ->andWhere('v.dateFinAssurance > :today')
            ->andWhere('v.dateFinVisiteTechnique > :today')
            ->andWhere('v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial) > 0')
            ->setParameter('etat', 'En service')
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
            ->andWhere('v.etat = :etat')
            ->andWhere('v.deleteAt IS NULL')
            ->andWhere('v.dateFinAssurance >= CURRENT_DATE()')
            ->andWhere('v.dateFinVisiteTechnique >= CURRENT_DATE()')
            ->setParameter('disponibilite', 'Disponible')
            ->setParameter('etat', 'En service')
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
            ->andWhere('v.etat = :etat')
            ->andWhere('v.deleteAt IS NULL')
            ->andWhere('v.dateFinAssurance >= CURRENT_DATE()')
            ->andWhere('v.dateFinVisiteTechnique >= CURRENT_DATE()')
            ->setParameter('disponibilite', 'Disponible')
            ->setParameter('etat', 'En service')
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

    public function countAllVehicles(): int
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v)')
            ->where('v.deleteAt IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllVehicules():array
    {
        return $this->createQueryBuilder('v')
            ->where('v.deleteAt IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function findVehiclesInMission(): array
    {
        return $this->createQueryBuilder('v')
            ->where('v.disponibilite = :disponibilite')
            ->andWhere('v.deleteAt IS NULL')
            ->setParameter('disponibilite', 'En mission')
            ->getQuery()
            ->getResult();
    }

    public function findAllVehiculesInMission(): array
    {
        return $this->createQueryBuilder('v')
            ->where('v.disponibilite = :disponibilite')
            ->andWhere('v.deleteAt IS NULL')
            ->setParameter('disponibilite', 'En mission')
            ->getQuery()
            ->getResult();
    }

    public function countVehiclesInMission(): int
    {
        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.disponibilite = :disponible')
            ->andWhere('v.deleteAt IS NULL')
            ->setParameter('disponible', 'En mission');

        return (int) $qb->getQuery()->getSingleScalarResult();
        }

    public function countVidangesNonvalides(): int
    {
        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->Where('(v.nbreKmPourRenouvellerVidange - (v.kilometrageCourant - v.kilometrageInitial)) <= 0');
        return (int) $qb->getQuery()->getSingleScalarResult();

    }

    public function countVehiclesJamaisAssure(): int
    {
        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.dateFinAssurance IS NULL')
            ->andWhere('v.deleteAt IS NULL');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }


    public function countVehiclesJamaisVisite(): int
    {
        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.dateFinVisiteTechnique IS NULL')
            ->andWhere('v.deleteAt IS NULL');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }



    public function countVehiclesSansVidange(): int
    {
        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.id)')
            ->where('v.dateVidange IS NULL')
            ->andWhere('v.deleteAt IS NULL');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
