<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730154121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure ADD responsable_structure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA1805704 FOREIGN KEY (responsable_structure_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6F0137EA1805704 ON structure (responsable_structure_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA1805704');
        $this->addSql('DROP INDEX UNIQ_6F0137EA1805704 ON structure');
        $this->addSql('ALTER TABLE structure DROP responsable_structure_id');
    }
}
