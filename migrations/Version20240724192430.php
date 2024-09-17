<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240724192430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add nbre_km_pour_renouveller_vidange and kilometrage_courant columns to vehicule table if they don\'t exist';
    }

    public function up(Schema $schema): void
    {
        // Vérifiez si les colonnes existent avant de les ajouter
        $table = $schema->getTable('vehicule');

        if (!$table->hasColumn('nbre_km_pour_renouveller_vidange')) {
            $this->addSql('ALTER TABLE vehicule ADD nbre_km_pour_renouveller_vidange INT DEFAULT NULL');
        }

        if (!$table->hasColumn('kilometrage_courant')) {
            $this->addSql('ALTER TABLE vehicule ADD kilometrage_courant INT DEFAULT NULL');
        }
    }

    public function down(Schema $schema): void
    {
        // Vérifiez si les colonnes existent avant de les supprimer
        $table = $schema->getTable('vehicule');

        if ($table->hasColumn('nbre_km_pour_renouveller_vidange')) {
            $this->addSql('ALTER TABLE vehicule DROP nbre_km_pour_renouveller_vidange');
        }

        if ($table->hasColumn('kilometrage_courant')) {
            $this->addSql('ALTER TABLE vehicule DROP kilometrage_courant');
        }
    }
}