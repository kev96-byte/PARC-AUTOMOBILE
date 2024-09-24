<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use App\Entity\Institution;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }


    public function findUserByEmailOrUsername(string $usernameOrEmail): ?User
    {
        return $this->createQueryBuilder('u')
                    ->where('u.email = :identifier')
                    ->orWhere('u.username = :identifier')
                    ->setParameter('identifier', $usernameOrEmail)
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getSingleResult();


    }

    public function findOneByRoleAndInstitution(string $role, int $institutionId)
    {

        return $this->createQueryBuilder('u')
            ->andWhere('u.roles = :role')
            ->andWhere('u.institution = :institutionId')
            ->setParameter('role', $role)
            ->setParameter('institutionId', $institutionId)
            ->getQuery()
            ->getOneOrNullResult();

    }

    public function findOneByRoleAndStructure(string $role, int $structureId)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles = :role')
            ->andWhere('u.structure = :structureId')
            ->setParameter('role', $role)
            ->setParameter('structureId', $structureId)
            ->getQuery();
    }


    public function findChefsParc()
    {
        // Récupérer tous les utilisateurs dont deleteAt est NULL
        $users = $this->createQueryBuilder('u')
            ->where('u.deleteAt IS NULL')
            ->getQuery()
            ->getResult();
    
        // Filtrer les utilisateurs pour ne garder que ceux dont le rôle est strictement égal à ROLE_VALIDATEUR
        return array_filter($users, function($user) {
            return in_array('ROLE_VALIDATEUR', $user->getRoles());
        });
    }

    public function findResponsableStructure()
    {
        // Récupérer tous les utilisateurs dont deleteAt est NULL
        $users = $this->createQueryBuilder('u')
            ->where('u.deleteAt IS NULL')
            ->getQuery()
            ->getResult();
    
        // Filtrer les utilisateurs pour ne garder que ceux dont le rôle est strictement égal à ROLE_VALIDATEUR
        return array_filter($users, function($user) {
            return in_array('ROLE_RESPONSABLE_STRUCTURE', $user->getRoles());
        });
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
