<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730130007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parc (id INT AUTO_INCREMENT NOT NULL, institution_id INT DEFAULT NULL, chef_parc_id INT DEFAULT NULL, nom_parc VARCHAR(255) NOT NULL, INDEX IDX_CADCF50110405986 (institution_id), INDEX IDX_CADCF50146FE222E (chef_parc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parc ADD CONSTRAINT FK_CADCF50110405986 FOREIGN KEY (institution_id) REFERENCES institution (id)');
        $this->addSql('ALTER TABLE parc ADD CONSTRAINT FK_CADCF50146FE222E FOREIGN KEY (chef_parc_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE structure ADD parc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA812D24CA FOREIGN KEY (parc_id) REFERENCES parc (id)');
        $this->addSql('CREATE INDEX IDX_6F0137EA812D24CA ON structure (parc_id)');
        $this->addSql('ALTER TABLE vehicule ADD parc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D812D24CA FOREIGN KEY (parc_id) REFERENCES parc (id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D812D24CA ON vehicule (parc_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA812D24CA');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D812D24CA');
        $this->addSql('ALTER TABLE parc DROP FOREIGN KEY FK_CADCF50110405986');
        $this->addSql('ALTER TABLE parc DROP FOREIGN KEY FK_CADCF50146FE222E');
        $this->addSql('DROP TABLE parc');
        $this->addSql('DROP INDEX IDX_6F0137EA812D24CA ON structure');
        $this->addSql('ALTER TABLE structure DROP parc_id');
        $this->addSql('DROP INDEX IDX_292FFF1D812D24CA ON vehicule');
        $this->addSql('ALTER TABLE vehicule DROP parc_id');
    }
}
