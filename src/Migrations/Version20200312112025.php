<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312112025 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

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
        $this->addSql('ALTER TABLE time ADD unite_id INT DEFAULT NULL, DROP unite, CHANGE temps_reglage temps_reglage DOUBLE PRECISION DEFAULT NULL, CHANGE temps_mo temps_mo DOUBLE PRECISION DEFAULT NULL, CHANGE temps_ma temps_ma DOUBLE PRECISION DEFAULT NULL, CHANGE acheminement acheminement DOUBLE PRECISION DEFAULT NULL, CHANGE quantite quantite DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE time ADD CONSTRAINT FK_6F949845EC4A74AB FOREIGN KEY (unite_id) REFERENCES unite (id)');
        $this->addSql('CREATE INDEX IDX_6F949845EC4A74AB ON time (unite_id)');
        $this->addSql('ALTER TABLE user CHANGE api_token api_token VARCHAR(191) DEFAULT NULL, CHANGE lastname lastname VARCHAR(64) DEFAULT NULL, CHANGE firstname firstname VARCHAR(64) DEFAULT NULL, CHANGE birthday birthday DATETIME DEFAULT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL, CHANGE alias alias VARCHAR(5) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

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
        $this->addSql('ALTER TABLE time DROP FOREIGN KEY FK_6F949845EC4A74AB');
        $this->addSql('DROP INDEX IDX_6F949845EC4A74AB ON time');
        $this->addSql('ALTER TABLE time ADD unite VARCHAR(24) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, DROP unite_id, CHANGE temps_reglage temps_reglage DOUBLE PRECISION DEFAULT \'NULL\', CHANGE temps_mo temps_mo DOUBLE PRECISION DEFAULT \'NULL\', CHANGE temps_ma temps_ma DOUBLE PRECISION DEFAULT \'NULL\', CHANGE acheminement acheminement DOUBLE PRECISION DEFAULT \'NULL\', CHANGE quantite quantite DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE api_token api_token VARCHAR(191) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE lastname lastname VARCHAR(64) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE firstname firstname VARCHAR(64) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE birthday birthday DATETIME DEFAULT \'NULL\', CHANGE slug slug VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE alias alias VARCHAR(5) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
    }
}
