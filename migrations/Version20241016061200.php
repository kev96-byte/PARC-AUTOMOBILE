<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241016061200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affecter (id INT AUTO_INCREMENT NOT NULL, demande_id INT DEFAULT NULL, vehicule_id INT DEFAULT NULL, chauffeur_id INT DEFAULT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C290057A80E95E18 (demande_id), INDEX IDX_C290057A4A4A3511 (vehicule_id), INDEX IDX_C290057A85C0B3BE (chauffeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assurance (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT DEFAULT NULL, date_debut_assurance DATE NOT NULL, date_fin_assurance DATE NOT NULL, piece_assurance VARCHAR(255) DEFAULT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', type_couverture LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', type_assurance VARCHAR(255) DEFAULT NULL, compagnie_assurance VARCHAR(255) DEFAULT NULL, INDEX IDX_386829AE4A4A3511 (vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chauffeur (id INT AUTO_INCREMENT NOT NULL, institution_id INT DEFAULT NULL, parc_id INT DEFAULT NULL, nom_chauffeur VARCHAR(255) NOT NULL, prenom_chauffeur VARCHAR(255) NOT NULL, telephone_chauffeur VARCHAR(16) DEFAULT NULL, num_permis VARCHAR(255) NOT NULL, etat_chauffeur VARCHAR(255) DEFAULT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', matricule_chauffeur VARCHAR(255) NOT NULL, disponibilite VARCHAR(255) DEFAULT NULL, photo_chauffeur VARCHAR(255) DEFAULT NULL, INDEX IDX_5CA777B810405986 (institution_id), INDEX IDX_5CA777B8812D24CA (parc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, departement_id INT DEFAULT NULL, libelle_commune VARCHAR(255) NOT NULL, delete_at DATETIME DEFAULT NULL, INDEX IDX_E2E2D1EECCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, demander_id INT DEFAULT NULL, validateur_structure_id INT DEFAULT NULL, traiter_par_id INT DEFAULT NULL, finaliser_par_id INT DEFAULT NULL, structure_id INT DEFAULT NULL, institution_id INT DEFAULT NULL, num_demande VARCHAR(255) DEFAULT NULL, date_demande DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', objet_mission VARCHAR(255) NOT NULL, date_debut_mission DATE DEFAULT NULL, date_fin_mission DATE DEFAULT NULL, lieuMission JSON NOT NULL, nbre_participants INT NOT NULL, nbre_vehicules INT NOT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', statut VARCHAR(255) DEFAULT NULL, raison_rejet_approbation VARCHAR(255) DEFAULT NULL, get_raison_rejet_validation VARCHAR(255) DEFAULT NULL, date_approbation DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_traitement DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', observations VARCHAR(255) DEFAULT NULL, date_effective_fin_mission DATE DEFAULT NULL, date_finalisation_demande DATE DEFAULT NULL, reference_note_de_service VARCHAR(255) DEFAULT NULL, date_signature_note_de_service DATE DEFAULT NULL, INDEX IDX_2694D7A54C21AB48 (demander_id), INDEX IDX_2694D7A5DF4C0F3E (validateur_structure_id), INDEX IDX_2694D7A54546CD3F (traiter_par_id), INDEX IDX_2694D7A5E7E17F36 (finaliser_par_id), INDEX IDX_2694D7A52534008B (structure_id), INDEX IDX_2694D7A510405986 (institution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_commune (commune_id INT NOT NULL, PRIMARY KEY(commune_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, libelle_departement VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, delete_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE financement (id INT AUTO_INCREMENT NOT NULL, libelle_financement VARCHAR(255) NOT NULL, type_financementent VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, libelle_institution VARCHAR(255) NOT NULL, telephone_institution VARCHAR(16) DEFAULT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', logo_institution VARCHAR(255) DEFAULT NULL, adresse_postale_institution VARCHAR(255) DEFAULT NULL, adresse_mail_institution VARCHAR(255) DEFAULT NULL, lien_site_web_institution VARCHAR(255) DEFAULT NULL, INDEX IDX_3A9F98E5B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, libelle_marque VARCHAR(255) NOT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle_niveau VARCHAR(255) NOT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parc (id INT AUTO_INCREMENT NOT NULL, institution_id INT DEFAULT NULL, chef_parc_id INT DEFAULT NULL, nom_parc VARCHAR(255) NOT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', telephone_parc VARCHAR(255) DEFAULT NULL, email_parc VARCHAR(255) DEFAULT NULL, INDEX IDX_CADCF50110405986 (institution_id), INDEX IDX_CADCF50146FE222E (chef_parc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, type_structure_id INT DEFAULT NULL, institution_id INT DEFAULT NULL, parc_id INT DEFAULT NULL, responsable_structure_id INT DEFAULT NULL, libelle_structure VARCHAR(255) NOT NULL, telephone_structure VARCHAR(16) DEFAULT NULL, libelle_long_structure VARCHAR(255) DEFAULT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6F0137EAA277BA8E (type_structure_id), INDEX IDX_6F0137EA10405986 (institution_id), INDEX IDX_6F0137EA812D24CA (parc_id), INDEX IDX_6F0137EA1805704 (responsable_structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tampon_affecter (id INT AUTO_INCREMENT NOT NULL, tampon_matricule VARCHAR(255) DEFAULT NULL, tampon_nom_chauffeur VARCHAR(255) DEFAULT NULL, tampon_prenom_chauffeur VARCHAR(255) DEFAULT NULL, tampon_kilometrage DOUBLE PRECISION DEFAULT NULL, tampon_vehicule_id INT DEFAULT NULL, tampon_chauffeur_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tampon_vehicules (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) DEFAULT NULL, kilometrerestant DOUBLE PRECISION DEFAULT NULL, checkassurance VARCHAR(255) DEFAULT NULL, checkvisite VARCHAR(255) DEFAULT NULL, checkvidange VARCHAR(255) DEFAULT NULL, portee_vehicule VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, champ1 VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_structure (id INT AUTO_INCREMENT NOT NULL, libelle_type_structure VARCHAR(255) NOT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_vehicule (id INT AUTO_INCREMENT NOT NULL, libelle_type_vehicule VARCHAR(255) NOT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, institution_id INT DEFAULT NULL, structure_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_verified TINYINT(1) NOT NULL, statut_compte VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, is_first_login TINYINT(1) NOT NULL, INDEX IDX_8D93D64910405986 (institution_id), INDEX IDX_8D93D6492534008B (structure_id), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), UNIQUE INDEX UNIQ_IDENTIFIER_MATRICULE (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, marque_id INT DEFAULT NULL, financement_id INT DEFAULT NULL, type_vehicule_id INT DEFAULT NULL, institution_id INT DEFAULT NULL, parc_id INT DEFAULT NULL, matricule VARCHAR(255) NOT NULL, numero_chassis VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, nbre_place INT NOT NULL, etat VARCHAR(255) DEFAULT NULL, date_acquisition DATE DEFAULT NULL, valeur_acquisition DOUBLE PRECISION DEFAULT NULL, kilometrage_initial DOUBLE PRECISION DEFAULT NULL, date_reception DATE DEFAULT NULL, date_mise_en_circulation DATE DEFAULT NULL, mise_en_rebut TINYINT(1) DEFAULT NULL, date_fin_assurance DATE DEFAULT NULL, date_fin_visite_technique DATE DEFAULT NULL, date_vidange DATE DEFAULT NULL, alimentation VARCHAR(255) DEFAULT NULL, allumage VARCHAR(255) DEFAULT NULL, assistance_freinage VARCHAR(255) DEFAULT NULL, capacite_carburant DOUBLE PRECISION DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, cession VARCHAR(255) DEFAULT NULL, charge_utile VARCHAR(255) DEFAULT NULL, climatiseur TINYINT(1) DEFAULT NULL, nbre_cylindre INT DEFAULT NULL, numero_moteur VARCHAR(255) DEFAULT NULL, pma INT DEFAULT NULL, puissance DOUBLE PRECISION DEFAULT NULL, vitesse DOUBLE PRECISION DEFAULT NULL, cylindree VARCHAR(255) DEFAULT NULL, direction_assistee VARCHAR(1000) DEFAULT NULL, duree_guarantie INT DEFAULT NULL, dure_vie INT DEFAULT NULL, energie VARCHAR(255) DEFAULT NULL, freins VARCHAR(255) DEFAULT NULL, pva VARCHAR(255) DEFAULT NULL, radio TINYINT(1) DEFAULT NULL, type_energie VARCHAR(255) DEFAULT NULL, type_transmission VARCHAR(255) DEFAULT NULL, disponibilite VARCHAR(255) DEFAULT NULL, photo_vehicule LONGTEXT DEFAULT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', nbre_km_pour_renouveller_vidange INT DEFAULT NULL, kilometrage_courant INT DEFAULT NULL, portee_vehicule VARCHAR(255) DEFAULT NULL, INDEX IDX_292FFF1D4827B9B2 (marque_id), INDEX IDX_292FFF1DA737ED74 (financement_id), INDEX IDX_292FFF1D153E280 (type_vehicule_id), INDEX IDX_292FFF1D10405986 (institution_id), INDEX IDX_292FFF1D812D24CA (parc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vidange (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT DEFAULT NULL, date_vidange DATE NOT NULL, valeur_compteur_kilometrage DOUBLE PRECISION DEFAULT NULL, piece_vidange VARCHAR(255) DEFAULT NULL, INDEX IDX_872AAB8B4A4A3511 (vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT DEFAULT NULL, date_debut_visite DATE NOT NULL, date_fin_visite DATE NOT NULL, piece_visite VARCHAR(255) DEFAULT NULL, INDEX IDX_B09C8CBB4A4A3511 (vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A85C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id)');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE chauffeur ADD CONSTRAINT FK_5CA777B810405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE chauffeur ADD CONSTRAINT FK_5CA777B8812D24CA FOREIGN KEY (parc_id) REFERENCES parc (id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EECCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54C21AB48 FOREIGN KEY (demander_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5DF4C0F3E FOREIGN KEY (validateur_structure_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54546CD3F FOREIGN KEY (traiter_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5E7E17F36 FOREIGN KEY (finaliser_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A52534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A510405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE institution ADD CONSTRAINT FK_3A9F98E5B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE parc ADD CONSTRAINT FK_CADCF50110405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE parc ADD CONSTRAINT FK_CADCF50146FE222E FOREIGN KEY (chef_parc_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EAA277BA8E FOREIGN KEY (type_structure_id) REFERENCES type_structure (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA10405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA812D24CA FOREIGN KEY (parc_id) REFERENCES parc (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA1805704 FOREIGN KEY (responsable_structure_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64910405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DA737ED74 FOREIGN KEY (financement_id) REFERENCES financement (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D153E280 FOREIGN KEY (type_vehicule_id) REFERENCES type_vehicule (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D10405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D812D24CA FOREIGN KEY (parc_id) REFERENCES parc (id)');
        $this->addSql('ALTER TABLE vidange ADD CONSTRAINT FK_872AAB8B4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A80E95E18');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A4A4A3511');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A85C0B3BE');
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY FK_386829AE4A4A3511');
        $this->addSql('ALTER TABLE chauffeur DROP FOREIGN KEY FK_5CA777B810405986');
        $this->addSql('ALTER TABLE chauffeur DROP FOREIGN KEY FK_5CA777B8812D24CA');
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EECCF9E01E');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54C21AB48');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5DF4C0F3E');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54546CD3F');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5E7E17F36');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A52534008B');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A510405986');
        $this->addSql('ALTER TABLE institution DROP FOREIGN KEY FK_3A9F98E5B3E9C81');
        $this->addSql('ALTER TABLE parc DROP FOREIGN KEY FK_CADCF50110405986');
        $this->addSql('ALTER TABLE parc DROP FOREIGN KEY FK_CADCF50146FE222E');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EAA277BA8E');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA10405986');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA812D24CA');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA1805704');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64910405986');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492534008B');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D4827B9B2');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DA737ED74');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D153E280');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D10405986');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D812D24CA');
        $this->addSql('ALTER TABLE vidange DROP FOREIGN KEY FK_872AAB8B4A4A3511');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB4A4A3511');
        $this->addSql('DROP TABLE affecter');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE chauffeur');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE demande_commune');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE financement');
        $this->addSql('DROP TABLE institution');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE parc');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE tampon_affecter');
        $this->addSql('DROP TABLE tampon_vehicules');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE type_structure');
        $this->addSql('DROP TABLE type_vehicule');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP TABLE vidange');
        $this->addSql('DROP TABLE visite');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
