<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617123051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chauffeur (id INT AUTO_INCREMENT NOT NULL, institution_id INT DEFAULT NULL, nom_chauffeur VARCHAR(255) NOT NULL, prenom_chauffeur VARCHAR(255) NOT NULL, telephone_chauffeur VARCHAR(255) DEFAULT NULL, num_permis VARCHAR(255) NOT NULL, etat_chauffeur VARCHAR(255) DEFAULT NULL, INDEX IDX_5CA777B810405986 (institution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE financement (id INT AUTO_INCREMENT NOT NULL, libelle_financement VARCHAR(255) NOT NULL, type_financementent VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, libelle_institution VARCHAR(255) NOT NULL, telephone_institution VARCHAR(255) DEFAULT NULL, INDEX IDX_3A9F98E5B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle_niveau VARCHAR(255) NOT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle_role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, type_structure_id INT DEFAULT NULL, institution_id INT DEFAULT NULL, libelle_structure VARCHAR(255) NOT NULL, telephone_structure VARCHAR(255) DEFAULT NULL, libelle_long_structure VARCHAR(255) DEFAULT NULL, INDEX IDX_6F0137EAA277BA8E (type_structure_id), INDEX IDX_6F0137EA10405986 (institution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, champ1 VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_structure (id INT AUTO_INCREMENT NOT NULL, libelle_type_structure VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_vehicule (id INT AUTO_INCREMENT NOT NULL, libelle_type_vehicule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, structure_id INT DEFAULT NULL, institution_id INT DEFAULT NULL, nom_utilisateur VARCHAR(255) NOT NULL, prenom_utilisateur VARCHAR(255) NOT NULL, date_naissance DATE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone_utilisateur VARCHAR(255) DEFAULT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, INDEX IDX_1D1C63B3D60322AC (role_id), INDEX IDX_1D1C63B32534008B (structure_id), INDEX IDX_1D1C63B310405986 (institution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, financement_id INT DEFAULT NULL, type_vehicule_id INT DEFAULT NULL, matricule VARCHAR(255) NOT NULL, numero_chassis VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, nbre_place INT NOT NULL, etat VARCHAR(255) DEFAULT NULL, date_acquisition DATE DEFAULT NULL, valeur_acquisition DOUBLE PRECISION DEFAULT NULL, kilometrage DOUBLE PRECISION DEFAULT NULL, date_reception DATE DEFAULT NULL, date_mise_en_circulation DATE DEFAULT NULL, mise_en_rebut TINYINT(1) DEFAULT NULL, date_debut_visite_technique DATE DEFAULT NULL, date_fin_visite_technique DATE DEFAULT NULL, date_entretien DATE DEFAULT NULL, alimentation VARCHAR(255) DEFAULT NULL, allumage VARCHAR(255) DEFAULT NULL, assistance_freinage VARCHAR(255) DEFAULT NULL, capacite_carburant DOUBLE PRECISION DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, cession VARCHAR(255) DEFAULT NULL, charge_utile VARCHAR(255) DEFAULT NULL, climatiseur TINYINT(1) DEFAULT NULL, nbre_cylindre INT DEFAULT NULL, numero_moteur VARCHAR(255) DEFAULT NULL, pma INT DEFAULT NULL, puissance DOUBLE PRECISION DEFAULT NULL, vitesse DOUBLE PRECISION DEFAULT NULL, cylindree VARCHAR(255) DEFAULT NULL, direction_assistee VARCHAR(1000) DEFAULT NULL, duree_guarantie INT DEFAULT NULL, dure_vie INT DEFAULT NULL, energie VARCHAR(255) DEFAULT NULL, freins VARCHAR(255) DEFAULT NULL, pva VARCHAR(255) DEFAULT NULL, radio TINYINT(1) DEFAULT NULL, type_energie VARCHAR(255) DEFAULT NULL, type_transmission VARCHAR(255) DEFAULT NULL, disponibilite VARCHAR(255) DEFAULT NULL, INDEX IDX_292FFF1DA737ED74 (financement_id), INDEX IDX_292FFF1D153E280 (type_vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chauffeur ADD CONSTRAINT FK_5CA777B810405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE institution ADD CONSTRAINT FK_3A9F98E5B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EAA277BA8E FOREIGN KEY (type_structure_id) REFERENCES type_structure (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA10405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B32534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B310405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DA737ED74 FOREIGN KEY (financement_id) REFERENCES financement (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D153E280 FOREIGN KEY (type_vehicule_id) REFERENCES type_vehicule (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chauffeur DROP FOREIGN KEY FK_5CA777B810405986');
        $this->addSql('ALTER TABLE institution DROP FOREIGN KEY FK_3A9F98E5B3E9C81');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EAA277BA8E');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA10405986');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B32534008B');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B310405986');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DA737ED74');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D153E280');
        $this->addSql('DROP TABLE chauffeur');
        $this->addSql('DROP TABLE financement');
        $this->addSql('DROP TABLE institution');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE type_structure');
        $this->addSql('DROP TABLE type_vehicule');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
