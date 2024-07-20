<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718002907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assurance (id INT AUTO_INCREMENT NOT NULL, vehicule_id_id INT DEFAULT NULL, date_debut_assurance DATE NOT NULL, date_fin_assurance DATE NOT NULL, piece_assurance VARCHAR(255) DEFAULT NULL, INDEX IDX_386829AE4F9D6605 (vehicule_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, vehicule_id_id INT DEFAULT NULL, date_debut_visite DATE NOT NULL, date_fin_visite DATE NOT NULL, piece_visite VARCHAR(255) DEFAULT NULL, INDEX IDX_B09C8CBB4F9D6605 (vehicule_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY FK_386829AE4F9D6605');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB4F9D6605');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE visite');
    }
}
