<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925180144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance ADD type_couverture LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD type_assurance VARCHAR(255) DEFAULT NULL, ADD compagnie_assurance VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE chauffeur ADD CONSTRAINT FK_5CA777B8812D24CA FOREIGN KEY (parc_id) REFERENCES parc (id)');
        $this->addSql('CREATE INDEX IDX_5CA777B8812D24CA ON chauffeur (parc_id)');
        $this->addSql('ALTER TABLE chauffeur RENAME INDEX fk_5ca777b810405986 TO IDX_5CA777B810405986');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance DROP type_couverture, DROP type_assurance, DROP compagnie_assurance');
        $this->addSql('ALTER TABLE chauffeur DROP FOREIGN KEY FK_5CA777B8812D24CA');
        $this->addSql('DROP INDEX IDX_5CA777B8812D24CA ON chauffeur');
        $this->addSql('ALTER TABLE chauffeur RENAME INDEX idx_5ca777b810405986 TO FK_5CA777B810405986');
    }
}
