<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241105065316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dommage (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT DEFAULT NULL, chauffeur_id INT DEFAULT NULL, type_dommage VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, date_dommage DATETIME DEFAULT NULL, delete_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', repare TINYINT(1) NOT NULL, date_reparation DATETIME DEFAULT NULL, observation LONGTEXT DEFAULT NULL, INDEX IDX_EDA85F854A4A3511 (vehicule_id), INDEX IDX_EDA85F8585C0B3BE (chauffeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dommage ADD CONSTRAINT FK_EDA85F854A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE dommage ADD CONSTRAINT FK_EDA85F8585C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dommage DROP FOREIGN KEY FK_EDA85F854A4A3511');
        $this->addSql('ALTER TABLE dommage DROP FOREIGN KEY FK_EDA85F8585C0B3BE');
        $this->addSql('DROP TABLE dommage');
    }
}
