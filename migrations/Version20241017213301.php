<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017213301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parc ADD validateur_parc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parc ADD CONSTRAINT FK_CADCF501E0CA4B47 FOREIGN KEY (validateur_parc_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CADCF501E0CA4B47 ON parc (validateur_parc_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parc DROP FOREIGN KEY FK_CADCF501E0CA4B47');
        $this->addSql('DROP INDEX IDX_CADCF501E0CA4B47 ON parc');
        $this->addSql('ALTER TABLE parc DROP validateur_parc_id');
    }
}
