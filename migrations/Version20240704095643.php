<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704095643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, demander_id INT DEFAULT NULL, validateur_structure_id INT DEFAULT NULL, traite_par_id INT DEFAULT NULL, num_demande VARCHAR(255) NOT NULL, date_demande DATETIME NOT NULL, objet_mission VARCHAR(255) NOT NULL, date_debut_mission DATETIME NOT NULL, date_fin_mission DATETIME NOT NULL, nbre_participants INT NOT NULL, nbre_vehicules INT NOT NULL, INDEX IDX_2694D7A54C21AB48 (demander_id), INDEX IDX_2694D7A5DF4C0F3E (validateur_structure_id), INDEX IDX_2694D7A5167FABE8 (traite_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_commune (demande_id INT NOT NULL, commune_id INT NOT NULL, INDEX IDX_D2156A4180E95E18 (demande_id), INDEX IDX_D2156A41131A4F72 (commune_id), PRIMARY KEY(demande_id, commune_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54C21AB48 FOREIGN KEY (demander_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5DF4C0F3E FOREIGN KEY (validateur_structure_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5167FABE8 FOREIGN KEY (traite_par_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE demande_commune ADD CONSTRAINT FK_D2156A4180E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande_commune ADD CONSTRAINT FK_D2156A41131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54C21AB48');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5DF4C0F3E');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5167FABE8');
        $this->addSql('ALTER TABLE demande_commune DROP FOREIGN KEY FK_D2156A4180E95E18');
        $this->addSql('ALTER TABLE demande_commune DROP FOREIGN KEY FK_D2156A41131A4F72');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE demande_commune');
    }
}
