<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200313070556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, gamme_enveloppe_id INT NOT NULL, gamme VARCHAR(255) NOT NULL, article VARCHAR(255) NOT NULL, configuration LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_27BA704BA76ED395 (user_id), INDEX IDX_27BA704BFF4082F2 (gamme_enveloppe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE processus_enveloppe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE processus_enveloppe_gamme_enveloppe (id INT AUTO_INCREMENT NOT NULL, gamme_enveloppe_id INT DEFAULT NULL, processus_enveloppe_id INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_225C8BFDFF4082F2 (gamme_enveloppe_id), INDEX IDX_225C8BFD999B6E15 (processus_enveloppe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BFF4082F2 FOREIGN KEY (gamme_enveloppe_id) REFERENCES gamme_enveloppe (id)');
        $this->addSql('ALTER TABLE processus_enveloppe_gamme_enveloppe ADD CONSTRAINT FK_225C8BFDFF4082F2 FOREIGN KEY (gamme_enveloppe_id) REFERENCES gamme_enveloppe (id)');
        $this->addSql('ALTER TABLE processus_enveloppe_gamme_enveloppe ADD CONSTRAINT FK_225C8BFD999B6E15 FOREIGN KEY (processus_enveloppe_id) REFERENCES processus_enveloppe (id)');
        $this->addSql('ALTER TABLE activite_poste_travail CHANGE activite_id activite_id INT DEFAULT NULL, CHANGE poste_travail_id poste_travail_id INT DEFAULT NULL, CHANGE time_id time_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activite_proto CHANGE activite_id activite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activite_proto_poste_travail_proto CHANGE activite_proto_id activite_proto_id INT DEFAULT NULL, CHANGE poste_travail_proto_id poste_travail_proto_id INT DEFAULT NULL, CHANGE time_id time_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE centre_production CHANGE departement_id departement_id INT DEFAULT NULL, CHANGE cout cout DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE gamme CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE classification classification VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE operation CHANGE gamme_id gamme_id INT DEFAULT NULL, CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE poste_travail CHANGE centre_production_id centre_production_id INT DEFAULT NULL, CHANGE nature_pdt nature_pdt VARCHAR(12) DEFAULT NULL, CHANGE temps_reglage temps_reglage DOUBLE PRECISION DEFAULT NULL, CHANGE temps_mo temps_mo DOUBLE PRECISION DEFAULT NULL, CHANGE temps_ma temps_ma DOUBLE PRECISION DEFAULT NULL, CHANGE acheminement acheminement DOUBLE PRECISION DEFAULT NULL, CHANGE quantite quantite DOUBLE PRECISION DEFAULT NULL, CHANGE unite unite VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE poste_travail_proto CHANGE pdt_id pdt_id INT DEFAULT NULL, CHANGE centre_production_id centre_production_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question CHANGE id_parent_reponse id_parent_reponse INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regle CHANGE ge_id ge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE id_parent_question id_parent_question INT DEFAULT NULL, CHANGE img img VARCHAR(255) DEFAULT NULL, CHANGE url url VARCHAR(2048) DEFAULT NULL, CHANGE created created DATETIME DEFAULT NULL, CHANGE updated updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE time CHANGE unite_id unite_id INT DEFAULT NULL, CHANGE temps_reglage temps_reglage DOUBLE PRECISION DEFAULT NULL, CHANGE temps_mo temps_mo DOUBLE PRECISION DEFAULT NULL, CHANGE temps_ma temps_ma DOUBLE PRECISION DEFAULT NULL, CHANGE acheminement acheminement DOUBLE PRECISION DEFAULT NULL, CHANGE quantite quantite DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D64C1185E237E06 ON unite (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D64C1188F2890A2 ON unite (short)');
        $this->addSql('ALTER TABLE user CHANGE api_token api_token VARCHAR(191) DEFAULT NULL, CHANGE lastname lastname VARCHAR(64) DEFAULT NULL, CHANGE firstname firstname VARCHAR(64) DEFAULT NULL, CHANGE birthday birthday DATETIME DEFAULT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL, CHANGE alias alias VARCHAR(5) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE processus_enveloppe_gamme_enveloppe DROP FOREIGN KEY FK_225C8BFD999B6E15');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE processus_enveloppe');
        $this->addSql('DROP TABLE processus_enveloppe_gamme_enveloppe');
        $this->addSql('ALTER TABLE activite_poste_travail CHANGE activite_id activite_id INT DEFAULT NULL, CHANGE poste_travail_id poste_travail_id INT DEFAULT NULL, CHANGE time_id time_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activite_proto CHANGE activite_id activite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activite_proto_poste_travail_proto CHANGE activite_proto_id activite_proto_id INT DEFAULT NULL, CHANGE poste_travail_proto_id poste_travail_proto_id INT DEFAULT NULL, CHANGE time_id time_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE centre_production CHANGE departement_id departement_id INT DEFAULT NULL, CHANGE cout cout DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE gamme CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE classification classification VARCHAR(10) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE operation CHANGE gamme_id gamme_id INT DEFAULT NULL, CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE poste_travail CHANGE centre_production_id centre_production_id INT DEFAULT NULL, CHANGE nature_pdt nature_pdt VARCHAR(12) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE temps_reglage temps_reglage DOUBLE PRECISION DEFAULT \'NULL\', CHANGE temps_mo temps_mo DOUBLE PRECISION DEFAULT \'NULL\', CHANGE temps_ma temps_ma DOUBLE PRECISION DEFAULT \'NULL\', CHANGE acheminement acheminement DOUBLE PRECISION DEFAULT \'NULL\', CHANGE quantite quantite DOUBLE PRECISION DEFAULT \'NULL\', CHANGE unite unite VARCHAR(32) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE poste_travail_proto CHANGE pdt_id pdt_id INT DEFAULT NULL, CHANGE centre_production_id centre_production_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question CHANGE id_parent_reponse id_parent_reponse INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regle CHANGE ge_id ge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE id_parent_question id_parent_question INT DEFAULT NULL, CHANGE img img VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE url url VARCHAR(2048) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE created created DATETIME DEFAULT \'NULL\', CHANGE updated updated DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE time CHANGE unite_id unite_id INT DEFAULT NULL, CHANGE temps_reglage temps_reglage DOUBLE PRECISION DEFAULT \'NULL\', CHANGE temps_mo temps_mo DOUBLE PRECISION DEFAULT \'NULL\', CHANGE temps_ma temps_ma DOUBLE PRECISION DEFAULT \'NULL\', CHANGE acheminement acheminement DOUBLE PRECISION DEFAULT \'NULL\', CHANGE quantite quantite DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('DROP INDEX UNIQ_1D64C1185E237E06 ON unite');
        $this->addSql('DROP INDEX UNIQ_1D64C1188F2890A2 ON unite');
        $this->addSql('ALTER TABLE user CHANGE api_token api_token VARCHAR(191) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE lastname lastname VARCHAR(64) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE firstname firstname VARCHAR(64) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE birthday birthday DATETIME DEFAULT \'NULL\', CHANGE slug slug VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE alias alias VARCHAR(5) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
    }
}
