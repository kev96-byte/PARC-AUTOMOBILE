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


    public function countExpiredMissions()
    {
        $now = new \DateTime();
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.dateFinMission < :now')
            ->andWhere('d.dateEffectiveFinMission IS NULL')
            ->andWhere('d.statut = :statut') // Ajouter la condition pour le statut
            ->setParameter('now', $now)
            ->setParameter('statut', 'Validé'); // Définir la valeur du statut
        return (int) $qb->getQuery()->getSingleScalarResult();

    }



    public function findApprouvedMissions()
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('d')
            ->where('d.dateFinMission < :now')
            ->andWhere('d.statut = :statut') // Ajouter la condition pour le statut
            ->setParameter('now', $now)
            ->setParameter('statut', 'Approuvé') // Définir la valeur du statut
            ->getQuery()
            ->getResult();

    }



    public function countAllDemandes(): int
    {
        return $this->createQueryBuilder('v')
            ->select('COUNT(v)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAllDemandesByUser($user):int
    {
        return $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.demander = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

// Total des demandes initiées par l'utilisateur connecté (Point focal) dont la date fin mission est supérieur à la date du jour
    public function countDemandesInitieeByPointFocal($user):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.demander = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Initial')
            ->setParameter('today', new \DateTime());

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
// Fin






    public function countDemandesRejeteesByResponsableStructure($user):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.validateurStructure = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Rejeté');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }


    public function countDemandesRejeteesByValidateur($user):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.traiterPar = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Rejeté');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }



    public function countDemandesForPointFocalRejetees($user):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.demander = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Rejeté');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countDemandesForPointFocalApprouvees($user):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.demander = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Approuvé');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }



    public function countDemandesApprouveesByResponsableStructure($user):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.validateurStructure = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Approuvé');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }



    public function countDemandesTraiteesByValidateur($user):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.traiterPar = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Validé');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }



    public function countAllDemandesRejeteesForInstitution($institution):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.institution = :institution')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('institution', $institution)
            ->setParameter('statut', 'Rejeté');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function countAllDemandesEnAttenteDApprobation($institution):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.institution = :institution')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('institution', $institution)
            ->setParameter('statut', 'Initial');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }


    public function countAllDemandesEnAttenteDeTraitement($institution):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.institution = :institution')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('institution', $institution)
            ->setParameter('statut', 'Approuvé')
            ->setParameter('today', new \DateTime());

        return (int) $qb->getQuery()->getSingleScalarResult();
    }



    public function countValidateurDemandesEnAttente($structure): int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.structure = :structure')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('structure', $structure)
            ->setParameter('statut', 'Approuvé')
            ->setParameter('today', new \DateTime());

        return (int) $qb->getQuery()->getSingleScalarResult();

    }

    public function countApprobateurDemandesEnAttente($structure): int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.structure = :structure')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('structure', $structure)
            ->setParameter('statut', 'Initial')
            ->setParameter('today', new \DateTime());

        return (int) $qb->getQuery()->getSingleScalarResult();

    }

    public function countDemandesPointFocalValidees($user): int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.demander = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Validé');

        return (int) $qb->getQuery()->getSingleScalarResult();

    }

    public function countDemandesValideesforotherroles($institution): int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.institution = :institution')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('institution', $institution)
            ->setParameter('statut', 'Validé');

        return (int) $qb->getQuery()->getSingleScalarResult();

    }

    public function countDemandesTraiteesByChefParc($user):int
    {
        $qb = $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where('d.traiterPar = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Traité');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function findApprobateurDemandesEnAttente($structure)
    {
        return $this->createQueryBuilder('d')
            ->where('d.structure = :structure')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('structure', $structure)
            ->setParameter('statut', 'Initial')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }


    public function findChefParcDemandesEnAttente($structure)
    {
        return $this->createQueryBuilder('d')
            ->where('d.structure = :structure')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('structure', $structure)
            ->setParameter('statut', 'Approuvé')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }


    public function findValidateurDemandesEnAttente($structure)
    {
        return $this->createQueryBuilder('d')
            ->where('d.structure = :structure')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('structure', $structure)
            ->setParameter('statut', 'Traité')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }

    public function findPointFocalDemandesApprouveesByResponsable($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.demander = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Approuvé')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }

    public function findPointFocalDemandesTraiteesByChefParc($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.demander = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Traité')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }


    public function findPointFocalDemandesValideesByValidateur($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.demander = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Validé')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }


    public function findDemandesApprouveesByResponsable($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.validateurStructure = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Approuvé')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }


    public function findDemandesApprouveesByResponsableAndTraiteByChefParc($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.validateurStructure = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Traité')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }


    public function findDemandesApprouveesByResponsableAndValideesByValidateur($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.validateurStructure = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Validé')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }

    public function findDemandesTraiteesByChefParc($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.traiterPar = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Traité')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }


    public function findDemandesValideesByValidateur($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.validatedBy = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Validé')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }


    public function findDemandesTraiteesByChefParcValideesByValidateur($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.traiterPar = :user')
            ->andWhere('d.statut = :statut')
            ->andWhere('d.dateFinMission >= :today')
            ->andWhere('d.deleteAt IS NULL')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Validé')
            ->setParameter('today', (new \DateTimeImmutable('today'))->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }

    public function findPointFocalDemandesInitiales($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.demander = :user')
            ->andWhere('d.statut = :statut')
            ->setParameter('user', $user)
            ->setParameter('statut', 'Initial')
            ->getQuery()
            ->getResult();
    }


    public function findAllDemandesForOneInstitution($institution)
    {
        return $this->createQueryBuilder('d')
            ->where('d.institution = :institution')
            ->andWhere('d.deleteAt IS NULL')
            ->andWhere('d.cancellationDate IS NULL')
            ->setParameter('institution', $institution)
            ->getQuery()
            ->getResult();
    }


    public function findAllDemandesApprouveesForOneInstitution($institution)
    {
        return $this->createQueryBuilder('d')
            ->where('d.institution = :institution')            
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->andWhere('d.cancellationDate IS NULL')
            ->setParameter('institution', $institution)
            ->setParameter('statut', 'Approuvé')
            ->getQuery()
            ->getResult();
    }

    public function findAllDemandesTraiteesForOneInstitution($institution)
    {
        return $this->createQueryBuilder('d')
            ->where('d.institution = :institution')            
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->andWhere('d.cancellationDate IS NULL')
            ->setParameter('institution', $institution)
            ->setParameter('statut', 'Traité')
            ->getQuery()
            ->getResult();
    }


    public function findAllDemandesValideesForOneInstitution($institution)
    {
        return $this->createQueryBuilder('d')
            ->where('d.institution = :institution')            
            ->andWhere('d.statut = :statut')
            ->andWhere('d.deleteAt IS NULL')
            ->andWhere('d.cancellationDate IS NULL')
            ->setParameter('institution', $institution)
            ->setParameter('statut', 'Validé')
            ->getQuery()
            ->getResult();
    }


}
