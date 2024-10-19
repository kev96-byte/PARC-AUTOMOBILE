<?php

namespace App\Repository;

use App\Entity\Chauffeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chauffeur>
 */
class ChauffeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chauffeur::class);
    }

    public function findAvailableChauffeurs(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.etatChauffeur = :etat')
            ->andWhere('c.deleteAt IS NULL')
            ->setParameter('etat', 'En service')
            ->getQuery()
            ->getResult();
    }



    public function findActiveChauffeursFormatted(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select("CONCAT(c.matriculeChauffeur, ' (', UPPER(c.nomChauffeur), ' ', UPPER(c.prenomChauffeur), ')') as formattedChauffeur, c.matriculeChauffeur")
            ->where('c.etatChauffeur = :etat')
            ->andWhere('c.deleteAt IS NULL')
            ->setParameter('etat', 'En service')
            ->orderBy('c.matriculeChauffeur', 'ASC');
    
        $result = $qb->getQuery()->getResult();
    
        $chauffeurChoices = [];
        foreach ($result as $row) {
            $chauffeurChoices[$row['formattedChauffeur']] = $row['matriculeChauffeur'];
        }
    
        return $chauffeurChoices;
    }
    

    public function findChauffeursDisponibles(\DateTimeInterface $dateDebutMission, \DateTimeInterface $dateFinMission, $parc)
    {
        // Sous-requête pour trouver les chauffeurs déjà affectés pendant la période
        $subQuery = $this->createQueryBuilder('c2')
        ->select('c2.id')
        ->innerJoin('c2.affecters', 'a')
        ->where('a.dateDebutMission BETWEEN :dateDebut AND :dateFin')
        ->orWhere('a.dateFinMission BETWEEN :dateDebut AND :dateFin')
        ->orWhere(':dateDebut BETWEEN a.dateDebutMission AND a.dateFinMission')
        ->orWhere(':dateFin BETWEEN a.dateDebutMission AND a.dateFinMission');
    
        // Requête principale pour trouver les véhicules disponibles
        $qb = $this->createQueryBuilder('c');

        $qb->where('c.deleteAt IS NULL')
        ->andWhere('c.etatChauffeur = :etat')
        ->andWhere('c.parc = :parc')
        ->andWhere($qb->expr()->notIn('c.id', $subQuery->getDQL()))
        ->setParameter('dateDebut', $dateDebutMission)
        ->setParameter('dateFin', $dateFinMission)
        ->setParameter('etat', 'En service')
        ->setParameter('parc', $parc);

        return $qb->getQuery()->getResult();
    }

    public function findChauffeursInMission(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.disponibilite = :disponibilite')
            ->andWhere('c.deleteAt IS NULL')
            ->setParameter('disponibilite', 'En mission')
            ->getQuery()
            ->getResult();
    }

    public function countChauffeursInMission(): int
    {
        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.disponibilite = :disponibilite')
            ->andWhere('c.deleteAt IS NULL')
            ->setParameter('disponibilite', 'En mission');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countAvailableChauffeurs(): int
    {
        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->andWhere('c.etatChauffeur = :etat')
            ->andWhere('c.deleteAt IS NULL')
            ->setParameter('etat', 'En service');
        return (int) $qb->getQuery()->getSingleScalarResult();
    }





    

    //    /**
    //     * @return Chauffeur[] Returns an array of Chauffeur objects
    //     */
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

    //    public function findOneBySomeField($value): ?Chauffeur
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

}
