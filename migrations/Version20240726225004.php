<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726225004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5167FABE8');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5E7E17F36');
        $this->addSql('DROP INDEX IDX_2694D7A5167FABE8 ON demande');
        $this->addSql('DROP INDEX IDX_2694D7A5E7E17F36 ON demande');
        $this->addSql('ALTER TABLE demande ADD traiter_par_id INT DEFAULT NULL, DROP traite_par_id, DROP finaliser_par_id');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54546CD3F FOREIGN KEY (traiter_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A54546CD3F ON demande (traiter_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54546CD3F');
        $this->addSql('DROP INDEX IDX_2694D7A54546CD3F ON demande');
        $this->addSql('ALTER TABLE demande ADD finaliser_par_id INT DEFAULT NULL, CHANGE traiter_par_id traite_par_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5167FABE8 FOREIGN KEY (traite_par_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5E7E17F36 FOREIGN KEY (finaliser_par_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2694D7A5167FABE8 ON demande (traite_par_id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5E7E17F36 ON demande (finaliser_par_id)');
    }
}
