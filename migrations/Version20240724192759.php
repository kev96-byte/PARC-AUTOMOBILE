<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724192759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE traiter_demande_chauffeur DROP FOREIGN KEY FK_FF2F0001167DC9D9');
        $this->addSql('ALTER TABLE traiter_demande_chauffeur DROP FOREIGN KEY FK_FF2F000185C0B3BE');
        $this->addSql('ALTER TABLE traiter_demande_demande DROP FOREIGN KEY FK_3F8049CC167DC9D9');
        $this->addSql('ALTER TABLE traiter_demande_demande DROP FOREIGN KEY FK_3F8049CC80E95E18');
        $this->addSql('ALTER TABLE traiter_demande_vehicule DROP FOREIGN KEY FK_1D58327F167DC9D9');
        $this->addSql('ALTER TABLE traiter_demande_vehicule DROP FOREIGN KEY FK_1D58327F4A4A3511');
        $this->addSql('DROP TABLE traiter_demande');
        $this->addSql('DROP TABLE traiter_demande_chauffeur');
        $this->addSql('DROP TABLE traiter_demande_demande');
        $this->addSql('DROP TABLE traiter_demande_vehicule');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traiter_demande (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE traiter_demande_chauffeur (traiter_demande_id INT NOT NULL, chauffeur_id INT NOT NULL, INDEX IDX_FF2F0001167DC9D9 (traiter_demande_id), INDEX IDX_FF2F000185C0B3BE (chauffeur_id), PRIMARY KEY(traiter_demande_id, chauffeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE traiter_demande_demande (traiter_demande_id INT NOT NULL, demande_id INT NOT NULL, INDEX IDX_3F8049CC167DC9D9 (traiter_demande_id), INDEX IDX_3F8049CC80E95E18 (demande_id), PRIMARY KEY(traiter_demande_id, demande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE traiter_demande_vehicule (traiter_demande_id INT NOT NULL, vehicule_id INT NOT NULL, INDEX IDX_1D58327F167DC9D9 (traiter_demande_id), INDEX IDX_1D58327F4A4A3511 (vehicule_id), PRIMARY KEY(traiter_demande_id, vehicule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE traiter_demande_chauffeur ADD CONSTRAINT FK_FF2F0001167DC9D9 FOREIGN KEY (traiter_demande_id) REFERENCES traiter_demande (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_chauffeur ADD CONSTRAINT FK_FF2F000185C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_demande ADD CONSTRAINT FK_3F8049CC167DC9D9 FOREIGN KEY (traiter_demande_id) REFERENCES traiter_demande (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_demande ADD CONSTRAINT FK_3F8049CC80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_vehicule ADD CONSTRAINT FK_1D58327F167DC9D9 FOREIGN KEY (traiter_demande_id) REFERENCES traiter_demande (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE traiter_demande_vehicule ADD CONSTRAINT FK_1D58327F4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
