<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726224358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande ADD finaliser_par_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5E7E17F36 FOREIGN KEY (finaliser_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5E7E17F36 ON demande (finaliser_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5E7E17F36');
        $this->addSql('DROP INDEX IDX_2694D7A5E7E17F36 ON demande');
        $this->addSql('ALTER TABLE demande DROP finaliser_par_id');
    }
}
