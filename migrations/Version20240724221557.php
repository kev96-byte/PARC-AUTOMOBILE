<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724221557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A4F9D6605');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A899A1D7E');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057AFD0D2964');
        $this->addSql('DROP INDEX IDX_C290057A899A1D7E ON affecter');
        $this->addSql('DROP INDEX IDX_C290057A4F9D6605 ON affecter');
        $this->addSql('DROP INDEX IDX_C290057AFD0D2964 ON affecter');
        $this->addSql('ALTER TABLE affecter ADD demande_id INT DEFAULT NULL, ADD vehicule_id INT DEFAULT NULL, ADD chauffeur_id INT DEFAULT NULL, DROP demande_id_id, DROP vehicule_id_id, DROP chauffeur_id_id');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A85C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id)');
        $this->addSql('CREATE INDEX IDX_C290057A80E95E18 ON affecter (demande_id)');
        $this->addSql('CREATE INDEX IDX_C290057A4A4A3511 ON affecter (vehicule_id)');
        $this->addSql('CREATE INDEX IDX_C290057A85C0B3BE ON affecter (chauffeur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A80E95E18');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A4A4A3511');
        $this->addSql('ALTER TABLE affecter DROP FOREIGN KEY FK_C290057A85C0B3BE');
        $this->addSql('DROP INDEX IDX_C290057A80E95E18 ON affecter');
        $this->addSql('DROP INDEX IDX_C290057A4A4A3511 ON affecter');
        $this->addSql('DROP INDEX IDX_C290057A85C0B3BE ON affecter');
        $this->addSql('ALTER TABLE affecter ADD demande_id_id INT DEFAULT NULL, ADD vehicule_id_id INT DEFAULT NULL, ADD chauffeur_id_id INT DEFAULT NULL, DROP demande_id, DROP vehicule_id, DROP chauffeur_id');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A899A1D7E FOREIGN KEY (demande_id_id) REFERENCES demande (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057AFD0D2964 FOREIGN KEY (chauffeur_id_id) REFERENCES chauffeur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C290057A899A1D7E ON affecter (demande_id_id)');
        $this->addSql('CREATE INDEX IDX_C290057A4F9D6605 ON affecter (vehicule_id_id)');
        $this->addSql('CREATE INDEX IDX_C290057AFD0D2964 ON affecter (chauffeur_id_id)');
    }
}
