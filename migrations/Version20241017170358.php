<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017170358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande ADD cancelled_by_id INT DEFAULT NULL, ADD cancellation_request_by_id INT DEFAULT NULL, ADD cancellation_date DATETIME DEFAULT NULL, ADD cancellation_request_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5187B2D12 FOREIGN KEY (cancelled_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A52F84F10B FOREIGN KEY (cancellation_request_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5187B2D12 ON demande (cancelled_by_id)');
        $this->addSql('CREATE INDEX IDX_2694D7A52F84F10B ON demande (cancellation_request_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5187B2D12');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A52F84F10B');
        $this->addSql('DROP INDEX IDX_2694D7A5187B2D12 ON demande');
        $this->addSql('DROP INDEX IDX_2694D7A52F84F10B ON demande');
        $this->addSql('ALTER TABLE demande DROP cancelled_by_id, DROP cancellation_request_by_id, DROP cancellation_date, DROP cancellation_request_date');
    }
}
