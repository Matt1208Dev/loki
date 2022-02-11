<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204182851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rent_row (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, rent_id INT DEFAULT NULL, quantity INT NOT NULL, price NUMERIC(5, 2) NOT NULL, total_row NUMERIC(5, 2) NOT NULL, INDEX IDX_846A32DEED5CA9E6 (service_id), INDEX IDX_846A32DEE5FD6250 (rent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rent_row ADD CONSTRAINT FK_846A32DEED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE rent_row ADD CONSTRAINT FK_846A32DEE5FD6250 FOREIGN KEY (rent_id) REFERENCES rent (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rent_row');
    }
}
