<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204181548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rent (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, apartment_id INT DEFAULT NULL, starting_date DATETIME NOT NULL, ending_date DATETIME NOT NULL, rent_type VARCHAR(20) NOT NULL, total NUMERIC(5, 2) NOT NULL, is_paid TINYINT(1) NOT NULL, settlement_date DATETIME DEFAULT NULL, deposit VARCHAR(50) NOT NULL, comment VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_2784DCC7E3C61F9 (owner_id), INDEX IDX_2784DCC176DFE85 (apartment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rent');
    }
}
