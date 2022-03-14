<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211154813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apartment CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owner CHANGE street street VARCHAR(150) NOT NULL');
        // $this->addSql('ALTER TABLE owner ADD retired TINYINT(1) DEFAULT NULL, CHANGE street street VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE rent_row CHANGE service_id service_id INT NOT NULL, CHANGE rent_id rent_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apartment CHANGE owner_id owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE owner DROP retired, CHANGE street street VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE rent CHANGE owner_id owner_id INT DEFAULT NULL, CHANGE apartment_id apartment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rent_row CHANGE service_id service_id INT DEFAULT NULL, CHANGE rent_id rent_id INT DEFAULT NULL');
    }
}
