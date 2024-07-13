<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709160639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54C21AB48 FOREIGN KEY (demander_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5DF4C0F3E FOREIGN KEY (validateur_structure_id) REFERENCES user (id)');
        // $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5167FABE8 FOREIGN KEY (traite_par_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54C21AB48');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5DF4C0F3E');
        // $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5167FABE8');
    }
}
