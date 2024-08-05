<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240726143449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tampon_affecter (id INT AUTO_INCREMENT NOT NULL, tampon_matricule VARCHAR(255) DEFAULT NULL, tampon_nom_chauffeur VARCHAR(255) DEFAULT NULL, tampon_prenom_chauffeur VARCHAR(255) DEFAULT NULL, tampon_kilometrage DOUBLE PRECISION DEFAULT NULL, tampon_vehicule_id INT DEFAULT NULL, tampon_chauffeur_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE tampon_afecter');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tampon_afecter (id INT AUTO_INCREMENT NOT NULL, tampon_matricule VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tampon_nom_chauffeur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tampon_prenom_chauffeur VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tampon_kilometrage DOUBLE PRECISION DEFAULT NULL, tampon_vehicule_id INT DEFAULT NULL, tampon_chauffeur_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE tampon_affecter');
    }
}
