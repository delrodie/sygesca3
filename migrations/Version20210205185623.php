<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205185623 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE requete (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenoms VARCHAR(255) DEFAULT NULL, datenaissance VARCHAR(255) DEFAULT NULL, lieunaissance VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, message LONGTEXT DEFAULT NULL, media VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_1E6639AA98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE requete ADD CONSTRAINT FK_1E6639AA98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE requete');
    }
}
