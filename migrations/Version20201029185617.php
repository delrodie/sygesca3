<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029185617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recherche (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info2020 (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, district_id INT DEFAULT NULL, groupe_id INT DEFAULT NULL, fonction_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenoms VARCHAR(255) DEFAULT NULL, date_naissance VARCHAR(255) DEFAULT NULL, lieu_naissance VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, urgence VARCHAR(255) DEFAULT NULL, contact_parent VARCHAR(255) DEFAULT NULL, branche VARCHAR(255) DEFAULT NULL, INDEX IDX_E1AD0AFD98260155 (region_id), INDEX IDX_E1AD0AFDB08FA272 (district_id), INDEX IDX_E1AD0AFD7A45358C (groupe_id), INDEX IDX_E1AD0AFD57889920 (fonction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_info2020 ADD CONSTRAINT FK_E1AD0AFD98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE user_info2020 ADD CONSTRAINT FK_E1AD0AFDB08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE user_info2020 ADD CONSTRAINT FK_E1AD0AFD7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE user_info2020 ADD CONSTRAINT FK_E1AD0AFD57889920 FOREIGN KEY (fonction_id) REFERENCES fonctions (id)');
        $this->addSql('ALTER TABLE fos_user CHANGE login_count login_count INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE recherche');
        $this->addSql('DROP TABLE user_info2020');
        $this->addSql('ALTER TABLE fos_user CHANGE login_count login_count INT DEFAULT 0 NOT NULL');
    }
}
