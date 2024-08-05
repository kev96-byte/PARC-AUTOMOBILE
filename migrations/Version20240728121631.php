<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240728121631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY FK_386829AE4F9D6605');
        $this->addSql('DROP INDEX IDX_386829AE4F9D6605 ON assurance');
        $this->addSql('ALTER TABLE assurance CHANGE vehicule_id_id vehicule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_386829AE4A4A3511 ON assurance (vehicule_id)');
        $this->addSql('ALTER TABLE vidange CHANGE piece_vidande piece_vidange VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB4F9D6605');
        $this->addSql('DROP INDEX IDX_B09C8CBB4F9D6605 ON visite');
        $this->addSql('ALTER TABLE visite CHANGE vehicule_id_id vehicule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_B09C8CBB4A4A3511 ON visite (vehicule_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY FK_386829AE4A4A3511');
        $this->addSql('DROP INDEX IDX_386829AE4A4A3511 ON assurance');
        $this->addSql('ALTER TABLE assurance CHANGE vehicule_id vehicule_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_386829AE4F9D6605 ON assurance (vehicule_id_id)');
        $this->addSql('ALTER TABLE vidange CHANGE piece_vidange piece_vidande VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB4A4A3511');
        $this->addSql('DROP INDEX IDX_B09C8CBB4A4A3511 ON visite');
        $this->addSql('ALTER TABLE visite CHANGE vehicule_id vehicule_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B09C8CBB4F9D6605 ON visite (vehicule_id_id)');
    }
}
