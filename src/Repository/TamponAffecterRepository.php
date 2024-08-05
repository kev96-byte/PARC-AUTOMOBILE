<?php
namespace App\Repository;

use App\Entity\TamponAffecter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TamponAffecterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TamponAffecter::class);
    }

    // Méthode pour vider la table tampon
    public function clearTable()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'DELETE FROM tampon_affecter';
        $stmt = $conn->prepare($sql);
        $stmt->executeQuery();
    }

    // Méthode pour insérer des données dans la table tampon
    public function insertData(array $data)
    {
        $conn = $this->getEntityManager()->getConnection();
        foreach ($data as $item) {
            $sql = '
                INSERT INTO tampon_affecter 
                (tampon_matricule, tampon_nom_chauffeur, tampon_prenom_chauffeur, tampon_kilometrage, tampon_vehicule_id, tampon_chauffeur_id) 
                VALUES 
                (:tamponMatricule, :tamponNomChauffeur, :tamponPrenomChauffeur, :tamponKilometrage, :tamponVehiculeId, :tamponChauffeurId)';
            $stmt = $conn->prepare($sql);
            $stmt->executeQuery([
                'tamponMatricule' => $item['vehiculeMatricule'],
                'tamponNomChauffeur' => $item['chauffeurNom'],
                'tamponPrenomChauffeur' => $item['chauffeurPrenom'],
                'tamponKilometrage' => $item['kilometrageReleve'],
                'tamponVehiculeId' => $item['vehiculeId'],
                'tamponChauffeurId' => $item['chauffeurId'],
            ]);
        }
    }

    // Méthode pour récupérer toutes les données de la table tampon sous forme associative
    public function findAllAssociative()
    {
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function updateKilometrage(string $matricule, float $kilometrage): int
    {

        $qb = $this->createQueryBuilder('t')
            ->update()
            ->set('t.tamponKilometrage', ':kilometrage')
            ->where('t.tamponMatricule = :matricule')
            ->setParameter('kilometrage', $kilometrage)
            ->setParameter('matricule', $matricule)
            ->getQuery();
    
        return $qb->execute();
    }



    
}
