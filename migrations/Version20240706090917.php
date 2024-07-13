<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706090917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_commune DROP FOREIGN KEY FK_D2156A41131A4F72');
        $this->addSql('ALTER TABLE demande_commune DROP FOREIGN KEY FK_D2156A4180E95E18');
        $this->addSql('DROP INDEX IDX_D2156A4180E95E18 ON demande_commune');
        $this->addSql('DROP INDEX IDX_D2156A41131A4F72 ON demande_commune');
        $this->addSql('DROP INDEX `primary` ON demande_commune');
        $this->addSql('ALTER TABLE demande_commune DROP demande_id');
        $this->addSql('ALTER TABLE demande_commune ADD PRIMARY KEY (commune_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON demande_commune');
        $this->addSql('ALTER TABLE demande_commune ADD demande_id INT NOT NULL');
        $this->addSql('ALTER TABLE demande_commune ADD CONSTRAINT FK_D2156A41131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande_commune ADD CONSTRAINT FK_D2156A4180E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D2156A4180E95E18 ON demande_commune (demande_id)');
        $this->addSql('CREATE INDEX IDX_D2156A41131A4F72 ON demande_commune (commune_id)');
        $this->addSql('ALTER TABLE demande_commune ADD PRIMARY KEY (demande_id, commune_id)');
    }
}
