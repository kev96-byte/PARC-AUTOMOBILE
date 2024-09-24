<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240919141205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chauffeur DROP FOREIGN KEY FK_5CA777B810405986');
        $this->addSql('DROP INDEX IDX_5CA777B810405986 ON chauffeur');
        $this->addSql('ALTER TABLE chauffeur DROP institution_id, CHANGE parc_id parc_id INT NOT NULL');
        $this->addSql('ALTER TABLE chauffeur ADD CONSTRAINT FK_5CA777B8812D24CA FOREIGN KEY (parc_id) REFERENCES parc (id)');
        $this->addSql('CREATE INDEX IDX_5CA777B8812D24CA ON chauffeur (parc_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chauffeur DROP FOREIGN KEY FK_5CA777B8812D24CA');
        $this->addSql('DROP INDEX IDX_5CA777B8812D24CA ON chauffeur');
        $this->addSql('ALTER TABLE chauffeur ADD institution_id INT DEFAULT NULL, CHANGE parc_id parc_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chauffeur ADD CONSTRAINT FK_5CA777B810405986 FOREIGN KEY (institution_id) REFERENCES institution (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5CA777B810405986 ON chauffeur (institution_id)');
    }
}
