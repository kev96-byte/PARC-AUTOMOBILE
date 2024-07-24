<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240720223409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affecter (id INT AUTO_INCREMENT NOT NULL, demande_id_id INT DEFAULT NULL, vehicule_id_id INT DEFAULT NULL, chauffeur_id_id INT DEFAULT NULL, INDEX IDX_C290057A899A1D7E (demande_id_id), INDEX IDX_C290057A4F9D6605 (vehicule_id_id), INDEX IDX_C290057AFD0D2964 (chauffeur_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assurance (id INT AUTO_INCREMENT NOT NULL, vehicule_id_id INT DEFAULT NULL, date_debut_assurance DATE NOT NULL, date_fin_assurance DATE NOT NULL, piece_assurance VARCHAR(255) DEFAULT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_386829AE4F9D6605 (vehicule_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traiter_demande (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traiter_demande_demande (traiter_demande_id INT NOT NULL, demande_id INT NOT NULL, INDEX IDX_3F8049CC167DC9D9 (traiter_demande_id), INDEX IDX_3F8049CC80E95E18 (demande_id), PRIMARY KEY(traiter_demande_id, demande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traiter_demande_chauffeur (traiter_demande_id INT NOT NULL, chauffeur_id INT NOT NULL, INDEX IDX_FF2F0001167DC9D9 (traiter_demande_id), INDEX IDX_FF2F000185C0B3BE (chauffeur_id), PRIMARY KEY(traiter_demande_id, chauffeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traiter_demande_vehicule (traiter_demande_id INT NOT NULL, vehicule_id INT NOT NULL, INDEX IDX_1D58327F167DC9D9 (traiter_demande_id), INDEX IDX_1D58327F4A4A3511 (vehicule_id), PRIMARY KEY(traiter_demande_id, vehicule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, vehicule_id_id INT DEFAULT NULL, date_debut_visite DATE NOT NULL, date_fin_visite DATE NOT NULL, piece_visite VARCHAR(255) DEFAULT NULL, INDEX IDX_B09C8CBB4F9D6605 (vehicule_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A899A1D7E FOREIGN KEY (demande_id_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057AFD0D2964 FOREIGN KEY (chauffeur_id_id) REFERENCES chauffeur (id)');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE traiter_demande_demande ADD CONSTRAINT FK_3F8049CC167DC9D9 FOREIGN KEY (traiter_demande_id) REFERENCES traiter_demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_demande ADD CONSTRAINT FK_3F8049CC80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_chauffeur ADD CONSTRAINT FK_FF2F0001167DC9D9 FOREIGN KEY (traiter_demande_id) REFERENCES traiter_demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_chauffeur ADD CONSTRAINT FK_FF2F000185C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_vehicule ADD CONSTRAINT FK_1D58327F167DC9D9 FOREIGN KEY (traiter_demande_id) REFERENCES traiter_demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_vehicule ADD CONSTRAINT FK_1D58327F4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE chauffeur ADD disponibilite VARCHAR(255) DEFAULT NULL, ADD photo_chauffeur VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5167FABE8');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54C21AB48');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5DF4C0F3E');
        $this->addSql('ALTER TABLE demande ADD raison_rejet_approbation VARCHAR(255) DEFAULT NULL, ADD get_raison_rejet_validation VARCHAR(255) DEFAULT NULL, ADD date_approbation DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD date_traitement DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD observations VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5167FABE8 FOREIGN KEY (traite_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54C21AB48 FOREIGN KEY (demander_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5DF4C0F3E FOREIGN KEY (validateur_structure_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_MATRICULE ON user (matricule)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A899A1D7E');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A4F9D6605');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057AFD0D2964');
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY FK_386829AE4F9D6605');
        $this->addSql('ALTER TABLE traiter_demande_demande DROP FOREIGN KEY FK_3F8049CC167DC9D9');
        $this->addSql('ALTER TABLE traiter_demande_demande DROP FOREIGN KEY FK_3F8049CC80E95E18');
        $this->addSql('ALTER TABLE traiter_demande_chauffeur DROP FOREIGN KEY FK_FF2F0001167DC9D9');
        $this->addSql('ALTER TABLE traiter_demande_chauffeur DROP FOREIGN KEY FK_FF2F000185C0B3BE');
        $this->addSql('ALTER TABLE traiter_demande_vehicule DROP FOREIGN KEY FK_1D58327F167DC9D9');
        $this->addSql('ALTER TABLE traiter_demande_vehicule DROP FOREIGN KEY FK_1D58327F4A4A3511');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB4F9D6605');
        $this->addSql('DROP TABLE affecter');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE traiter_demande');
        $this->addSql('DROP TABLE traiter_demande_demande');
        $this->addSql('DROP TABLE traiter_demande_chauffeur');
        $this->addSql('DROP TABLE traiter_demande_vehicule');
        $this->addSql('DROP TABLE visite');
        $this->addSql('ALTER TABLE chauffeur DROP disponibilite, DROP photo_chauffeur');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54C21AB48');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5DF4C0F3E');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5167FABE8');
        $this->addSql('ALTER TABLE demande DROP raison_rejet_approbation, DROP get_raison_rejet_validation, DROP date_approbation, DROP date_traitement, DROP observations');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54C21AB48 FOREIGN KEY (demander_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5DF4C0F3E FOREIGN KEY (validateur_structure_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5167FABE8 FOREIGN KEY (traite_par_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_MATRICULE ON user');
    }
}
