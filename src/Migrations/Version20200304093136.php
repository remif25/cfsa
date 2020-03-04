<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200304093136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activite_poste_travail (id INT AUTO_INCREMENT NOT NULL, activite_id INT DEFAULT NULL, poste_travail_id INT DEFAULT NULL, temps_reglage DOUBLE PRECISION DEFAULT NULL, temps_mo DOUBLE PRECISION DEFAULT NULL, temps_ma DOUBLE PRECISION DEFAULT NULL, INDEX IDX_E076A7449B0F88B1 (activite_id), INDEX IDX_E076A7449FEBDA9B (poste_travail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activite_proto (id INT AUTO_INCREMENT NOT NULL, activite_id INT DEFAULT NULL, reference VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_956FF3EA9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre_production (id INT AUTO_INCREMENT NOT NULL, departement_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, designation VARCHAR(255) NOT NULL, cout DOUBLE PRECISION DEFAULT NULL, INDEX IDX_477EEECDCCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(24) NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gamme (id INT AUTO_INCREMENT NOT NULL, gamme_enveloppe_id INT DEFAULT NULL, nom VARCHAR(64) NOT NULL, description VARCHAR(255) DEFAULT NULL, classification VARCHAR(10) DEFAULT NULL, INDEX IDX_C32E1468FF4082F2 (gamme_enveloppe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gamme_enveloppe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(64) NOT NULL, reference VARCHAR(12) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link_regle_operation (id INT AUTO_INCREMENT NOT NULL, regle_id INT NOT NULL, operation_id INT NOT NULL, branche LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_567A45838E12947B (regle_id), UNIQUE INDEX UNIQ_567A458344AC3583 (operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, gamme_id INT DEFAULT NULL, pdt_id INT NOT NULL, activite_id INT NOT NULL, gamme_enveloppe_id INT DEFAULT NULL, numero INT NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_1981A66DD2FD85F1 (gamme_id), INDEX IDX_1981A66DAB0F5606 (pdt_id), INDEX IDX_1981A66D9B0F88B1 (activite_id), INDEX IDX_1981A66DFF4082F2 (gamme_enveloppe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_travail (id INT AUTO_INCREMENT NOT NULL, centre_production_id INT DEFAULT NULL, reference VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, nature_pdt VARCHAR(12) DEFAULT NULL, INDEX IDX_E033582B8876423D (centre_production_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_travail_proto (id INT AUTO_INCREMENT NOT NULL, pdt_id INT DEFAULT NULL, centre_production_id INT DEFAULT NULL, reference VARCHAR(24) NOT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8F5F296FAB0F5606 (pdt_id), INDEX IDX_8F5F296F8876423D (centre_production_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_travail_proto_activite_proto (poste_travail_proto_id INT NOT NULL, activite_proto_id INT NOT NULL, INDEX IDX_3BBD569A589A2C (poste_travail_proto_id), INDEX IDX_3BBD5620A85E64 (activite_proto_id), PRIMARY KEY(poste_travail_proto_id, activite_proto_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, short VARCHAR(32) NOT NULL, q_long VARCHAR(2045) NOT NULL, information LONGTEXT NOT NULL, id_parent_reponse INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regle (id INT AUTO_INCREMENT NOT NULL, ge_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, aide LONGTEXT DEFAULT NULL, INDEX IDX_F0C02F5A78C84753 (ge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, gamme_enveloppe_id INT DEFAULT NULL, short VARCHAR(32) NOT NULL, information LONGTEXT DEFAULT NULL, id_parent_question INT DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, url VARCHAR(2048) DEFAULT NULL, created DATETIME DEFAULT NULL, updated DATETIME DEFAULT NULL, INDEX IDX_5FB6DEC7FF4082F2 (gamme_enveloppe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, api_token VARCHAR(191) DEFAULT NULL, lastname VARCHAR(64) DEFAULT NULL, firstname VARCHAR(64) DEFAULT NULL, birthday DATETIME DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, alias VARCHAR(5) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite_poste_travail ADD CONSTRAINT FK_E076A7449B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE activite_poste_travail ADD CONSTRAINT FK_E076A7449FEBDA9B FOREIGN KEY (poste_travail_id) REFERENCES poste_travail (id)');
        $this->addSql('ALTER TABLE activite_proto ADD CONSTRAINT FK_956FF3EA9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE centre_production ADD CONSTRAINT FK_477EEECDCCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E1468FF4082F2 FOREIGN KEY (gamme_enveloppe_id) REFERENCES gamme_enveloppe (id)');
        $this->addSql('ALTER TABLE link_regle_operation ADD CONSTRAINT FK_567A45838E12947B FOREIGN KEY (regle_id) REFERENCES regle (id)');
        $this->addSql('ALTER TABLE link_regle_operation ADD CONSTRAINT FK_567A458344AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DD2FD85F1 FOREIGN KEY (gamme_id) REFERENCES gamme (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DAB0F5606 FOREIGN KEY (pdt_id) REFERENCES poste_travail (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DFF4082F2 FOREIGN KEY (gamme_enveloppe_id) REFERENCES gamme_enveloppe (id)');
        $this->addSql('ALTER TABLE poste_travail ADD CONSTRAINT FK_E033582B8876423D FOREIGN KEY (centre_production_id) REFERENCES centre_production (id)');
        $this->addSql('ALTER TABLE poste_travail_proto ADD CONSTRAINT FK_8F5F296FAB0F5606 FOREIGN KEY (pdt_id) REFERENCES poste_travail (id)');
        $this->addSql('ALTER TABLE poste_travail_proto ADD CONSTRAINT FK_8F5F296F8876423D FOREIGN KEY (centre_production_id) REFERENCES centre_production (id)');
        $this->addSql('ALTER TABLE poste_travail_proto_activite_proto ADD CONSTRAINT FK_3BBD569A589A2C FOREIGN KEY (poste_travail_proto_id) REFERENCES poste_travail_proto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poste_travail_proto_activite_proto ADD CONSTRAINT FK_3BBD5620A85E64 FOREIGN KEY (activite_proto_id) REFERENCES activite_proto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE regle ADD CONSTRAINT FK_F0C02F5A78C84753 FOREIGN KEY (ge_id) REFERENCES gamme_enveloppe (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FF4082F2 FOREIGN KEY (gamme_enveloppe_id) REFERENCES gamme_enveloppe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activite_poste_travail DROP FOREIGN KEY FK_E076A7449B0F88B1');
        $this->addSql('ALTER TABLE activite_proto DROP FOREIGN KEY FK_956FF3EA9B0F88B1');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D9B0F88B1');
        $this->addSql('ALTER TABLE poste_travail_proto_activite_proto DROP FOREIGN KEY FK_3BBD5620A85E64');
        $this->addSql('ALTER TABLE poste_travail DROP FOREIGN KEY FK_E033582B8876423D');
        $this->addSql('ALTER TABLE poste_travail_proto DROP FOREIGN KEY FK_8F5F296F8876423D');
        $this->addSql('ALTER TABLE centre_production DROP FOREIGN KEY FK_477EEECDCCF9E01E');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DD2FD85F1');
        $this->addSql('ALTER TABLE gamme DROP FOREIGN KEY FK_C32E1468FF4082F2');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DFF4082F2');
        $this->addSql('ALTER TABLE regle DROP FOREIGN KEY FK_F0C02F5A78C84753');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7FF4082F2');
        $this->addSql('ALTER TABLE link_regle_operation DROP FOREIGN KEY FK_567A458344AC3583');
        $this->addSql('ALTER TABLE activite_poste_travail DROP FOREIGN KEY FK_E076A7449FEBDA9B');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DAB0F5606');
        $this->addSql('ALTER TABLE poste_travail_proto DROP FOREIGN KEY FK_8F5F296FAB0F5606');
        $this->addSql('ALTER TABLE poste_travail_proto_activite_proto DROP FOREIGN KEY FK_3BBD569A589A2C');
        $this->addSql('ALTER TABLE link_regle_operation DROP FOREIGN KEY FK_567A45838E12947B');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE activite_poste_travail');
        $this->addSql('DROP TABLE activite_proto');
        $this->addSql('DROP TABLE centre_production');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE gamme');
        $this->addSql('DROP TABLE gamme_enveloppe');
        $this->addSql('DROP TABLE link_regle_operation');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE poste_travail');
        $this->addSql('DROP TABLE poste_travail_proto');
        $this->addSql('DROP TABLE poste_travail_proto_activite_proto');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE regle');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE user');
    }
}
