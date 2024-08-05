<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729052223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande ADD date_signature_note_de_service DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE institution ADD logo_institution VARCHAR(255) DEFAULT NULL, ADD adresse_postale_institution VARCHAR(255) DEFAULT NULL, ADD adresse_mail_institution VARCHAR(255) DEFAULT NULL, ADD lien_site_web_institution VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP date_signature_note_de_service');
        $this->addSql('ALTER TABLE institution DROP logo_institution, DROP adresse_postale_institution, DROP adresse_mail_institution, DROP lien_site_web_institution');
    }
}
