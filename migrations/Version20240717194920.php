<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240717194920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affecter (id INT AUTO_INCREMENT NOT NULL, demande_id_id INT DEFAULT NULL, vehicule_id_id INT DEFAULT NULL, chauffeur_id_id INT DEFAULT NULL, INDEX IDX_C290057A899A1D7E (demande_id_id), INDEX IDX_C290057A4F9D6605 (vehicule_id_id), INDEX IDX_C290057AFD0D2964 (chauffeur_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A899A1D7E FOREIGN KEY (demande_id_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057AFD0D2964 FOREIGN KEY (chauffeur_id_id) REFERENCES chauffeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A899A1D7E');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A4F9D6605');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057AFD0D2964');
        $this->addSql('DROP TABLE affecter');
    }
}
