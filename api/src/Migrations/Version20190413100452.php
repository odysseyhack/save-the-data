<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190413100452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evidence ADD incident_id INT DEFAULT NULL, DROP incident');
        $this->addSql('ALTER TABLE evidence ADD CONSTRAINT FK_C61571059E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('CREATE INDEX IDX_C61571059E53FB9 ON evidence (incident_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE incident CHANGE house_number house_number INT DEFAULT NULL, CHANGE house_number_addition house_number_addition VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evidence DROP FOREIGN KEY FK_C61571059E53FB9');
        $this->addSql('DROP INDEX IDX_C61571059E53FB9 ON evidence');
        $this->addSql('ALTER TABLE evidence ADD incident INT NOT NULL, DROP incident_id');
        $this->addSql('ALTER TABLE incident CHANGE house_number house_number INT DEFAULT NULL, CHANGE house_number_addition house_number_addition VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
