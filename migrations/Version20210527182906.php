<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210527182906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE base (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, statut TINYINT(1) DEFAULT NULL, image_name VARCHAR(255) NOT NULL, image_size INT DEFAULT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(75) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE branche (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cotisation (id INT AUTO_INCREMENT NOT NULL, scout_id INT DEFAULT NULL, annee VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, carte VARCHAR(255) DEFAULT NULL, montant VARCHAR(255) DEFAULT NULL, montant_san_frais INT DEFAULT NULL, ristourne INT DEFAULT NULL, INDEX IDX_AE64D2ED486EE6BB (scout_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE district (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, doyenne VARCHAR(125) DEFAULT NULL, slug VARCHAR(255) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, INDEX IDX_31C1548798260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ext_log_entries (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(8) NOT NULL, logged_at DATETIME NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', username VARCHAR(255) DEFAULT NULL, INDEX log_class_lookup_idx (object_class), INDEX log_date_lookup_idx (logged_at), INDEX log_user_lookup_idx (username), INDEX log_version_lookup_idx (object_id, object_class, version), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonctions (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, montant VARCHAR(255) DEFAULT NULL, created_at VARCHAR(255) DEFAULT NULL, updated_at VARCHAR(255) DEFAULT NULL, ristourne INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', login_count INT NOT NULL, first_login DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gestionnaire (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, contact VARCHAR(255) DEFAULT NULL, slug VARCHAR(20) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, INDEX IDX_F4461B2098260155 (region_id), INDEX IDX_F4461B20A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, district_id INT DEFAULT NULL, paroisse VARCHAR(255) NOT NULL, localite VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, INDEX IDX_4B98C21B08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectif (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, annee VARCHAR(255) NOT NULL, valeur INT NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, INDEX IDX_E2F8685198260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiements (id INT AUTO_INCREMENT NOT NULL, userinfo_id INT DEFAULT NULL, cpm_site_id VARCHAR(255) DEFAULT NULL, signature VARCHAR(255) DEFAULT NULL, cpm_amount VARCHAR(255) DEFAULT NULL, cpm_trans_id VARCHAR(255) DEFAULT NULL, cpm_custom VARCHAR(255) DEFAULT NULL, cpm_currency VARCHAR(255) DEFAULT NULL, cpm_payid VARCHAR(255) DEFAULT NULL, cpm_payment_date VARCHAR(255) DEFAULT NULL, cpm_payment_time VARCHAR(255) DEFAULT NULL, cpm_error_message VARCHAR(255) DEFAULT NULL, payment_method VARCHAR(255) DEFAULT NULL, cpm_phone_prefixe VARCHAR(255) DEFAULT NULL, cel_phone_num VARCHAR(255) DEFAULT NULL, cpm_ipn_ack VARCHAR(255) DEFAULT NULL, cpm_result VARCHAR(255) DEFAULT NULL, cpm_trans_status VARCHAR(255) DEFAULT NULL, cpm_designation VARCHAR(255) DEFAULT NULL, buyer_name VARCHAR(255) DEFAULT NULL, created_at VARCHAR(255) DEFAULT NULL, updated_at VARCHAR(255) DEFAULT NULL, INDEX IDX_E1B02E12C1EA3D46 (userinfo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, code VARCHAR(255) DEFAULT NULL, slug VARCHAR(20) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE requete (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenoms VARCHAR(255) DEFAULT NULL, datenaissance DATETIME DEFAULT NULL, lieunaissance VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, message LONGTEXT DEFAULT NULL, media VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_1E6639AA98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scout (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, statut_id INT DEFAULT NULL, matricule VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, datenaiss VARCHAR(255) NOT NULL, lieunaiss VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, branche VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, contactParent VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, carte VARCHAR(255) DEFAULT NULL, cotisation VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, publie_par VARCHAR(25) DEFAULT NULL, modifie_par VARCHAR(25) DEFAULT NULL, publie_le DATETIME DEFAULT NULL, modifie_le DATETIME DEFAULT NULL, urgence VARCHAR(255) DEFAULT NULL, INDEX IDX_176881647A45358C (groupe_id), INDEX IDX_17688164F6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scout_deleted (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenoms VARCHAR(255) NOT NULL, datenaiss VARCHAR(255) NOT NULL, lieunaiss VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, branche VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) DEFAULT NULL, contactParent VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, carte VARCHAR(255) DEFAULT NULL, cotisation VARCHAR(255) DEFAULT NULL, urgence VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, publie_le DATETIME DEFAULT NULL, supprime_le VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, groupe VARCHAR(255) DEFAULT NULL, district VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, montant INT DEFAULT NULL, montant_sans_frais INT DEFAULT NULL, ristourne INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_infos (id INT AUTO_INCREMENT NOT NULL, fonction_id INT DEFAULT NULL, groupe_id INT DEFAULT NULL, region_id INT DEFAULT NULL, district_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, birthday VARCHAR(255) DEFAULT NULL, birth_location VARCHAR(255) DEFAULT NULL, sexe_adh VARCHAR(255) DEFAULT NULL, contact_name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, num_perso VARCHAR(255) DEFAULT NULL, id_transaction VARCHAR(255) DEFAULT NULL, status_paiement VARCHAR(255) DEFAULT NULL, created_at VARCHAR(255) DEFAULT NULL, updated_at VARCHAR(255) DEFAULT NULL, branche VARCHAR(255) DEFAULT NULL, INDEX IDX_C08793557889920 (fonction_id), INDEX IDX_C0879357A45358C (groupe_id), INDEX IDX_C08793598260155 (region_id), INDEX IDX_C087935B08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info2020 (id INT AUTO_INCREMENT NOT NULL, fonction_id INT DEFAULT NULL, groupe_id INT DEFAULT NULL, region_id INT DEFAULT NULL, district_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, birthday VARCHAR(255) DEFAULT NULL, birth_location VARCHAR(255) DEFAULT NULL, sexe_adh VARCHAR(255) DEFAULT NULL, contact_name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, num_perso VARCHAR(255) DEFAULT NULL, id_transaction VARCHAR(255) DEFAULT NULL, status_paiement VARCHAR(255) DEFAULT NULL, created_at VARCHAR(255) DEFAULT NULL, updated_at VARCHAR(255) DEFAULT NULL, branche VARCHAR(255) DEFAULT NULL, INDEX IDX_C08793557889920 (fonction_id), INDEX IDX_C0879357A45358C (groupe_id), INDEX IDX_C08793598260155 (region_id), INDEX IDX_C087935B08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED486EE6BB FOREIGN KEY (scout_id) REFERENCES scout (id)');
        $this->addSql('ALTER TABLE district ADD CONSTRAINT FK_31C1548798260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE gestionnaire ADD CONSTRAINT FK_F4461B2098260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE gestionnaire ADD CONSTRAINT FK_F4461B20A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE objectif ADD CONSTRAINT FK_E2F8685198260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE paiements ADD CONSTRAINT FK_E1B02E12C1EA3D46 FOREIGN KEY (userinfo_id) REFERENCES user_infos (id)');
        $this->addSql('ALTER TABLE requete ADD CONSTRAINT FK_1E6639AA98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE scout ADD CONSTRAINT FK_176881647A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE scout ADD CONSTRAINT FK_17688164F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C08793557889920 FOREIGN KEY (fonction_id) REFERENCES fonctions (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C0879357A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C08793598260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE user_infos ADD CONSTRAINT FK_C087935B08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        //$this->addSql('ALTER TABLE user_info2020 ADD id_transaction VARCHAR(255) DEFAULT NULL, ADD status_paiement VARCHAR(255) DEFAULT NULL, ADD numero_paiement VARCHAR(255) DEFAULT NULL, ADD statut VARCHAR(255) DEFAULT NULL, ADD matricule VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_info2020 ADD CONSTRAINT FK_E1AD0AFD98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE user_info2020 ADD CONSTRAINT FK_E1AD0AFDB08FA272 FOREIGN KEY (district_id) REFERENCES district (id)');
        $this->addSql('ALTER TABLE user_info2020 ADD CONSTRAINT FK_E1AD0AFD7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE user_info2020 ADD CONSTRAINT FK_E1AD0AFD57889920 FOREIGN KEY (fonction_id) REFERENCES fonctions (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21B08FA272');
        $this->addSql('ALTER TABLE user_info2020 DROP FOREIGN KEY FK_E1AD0AFDB08FA272');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C087935B08FA272');
        $this->addSql('ALTER TABLE user_info2020 DROP FOREIGN KEY FK_E1AD0AFD57889920');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C08793557889920');
        $this->addSql('ALTER TABLE gestionnaire DROP FOREIGN KEY FK_F4461B20A76ED395');
        $this->addSql('ALTER TABLE scout DROP FOREIGN KEY FK_176881647A45358C');
        $this->addSql('ALTER TABLE user_info2020 DROP FOREIGN KEY FK_E1AD0AFD7A45358C');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C0879357A45358C');
        $this->addSql('ALTER TABLE district DROP FOREIGN KEY FK_31C1548798260155');
        $this->addSql('ALTER TABLE gestionnaire DROP FOREIGN KEY FK_F4461B2098260155');
        $this->addSql('ALTER TABLE objectif DROP FOREIGN KEY FK_E2F8685198260155');
        $this->addSql('ALTER TABLE requete DROP FOREIGN KEY FK_1E6639AA98260155');
        $this->addSql('ALTER TABLE user_info2020 DROP FOREIGN KEY FK_E1AD0AFD98260155');
        $this->addSql('ALTER TABLE user_infos DROP FOREIGN KEY FK_C08793598260155');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED486EE6BB');
        $this->addSql('ALTER TABLE scout DROP FOREIGN KEY FK_17688164F6203804');
        $this->addSql('ALTER TABLE paiements DROP FOREIGN KEY FK_E1B02E12C1EA3D46');
        $this->addSql('DROP TABLE base');
        $this->addSql('DROP TABLE branche');
        $this->addSql('DROP TABLE cotisation');
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE ext_log_entries');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE fonctions');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE gestionnaire');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE objectif');
        $this->addSql('DROP TABLE paiements');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE requete');
        $this->addSql('DROP TABLE scout');
        $this->addSql('DROP TABLE scout_deleted');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE user_infos');
        $this->addSql('ALTER TABLE user_info2020 DROP id_transaction, DROP status_paiement, DROP numero_paiement, DROP statut, DROP matricule');
    }
}
