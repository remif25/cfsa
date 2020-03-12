<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312083148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activite_proto_poste_travail_proto (id INT AUTO_INCREMENT NOT NULL, activite_proto_id INT DEFAULT NULL, poste_travail_proto_id INT DEFAULT NULL, time_id INT DEFAULT NULL, INDEX IDX_E98D3D7E20A85E64 (activite_proto_id), INDEX IDX_E98D3D7E9A589A2C (poste_travail_proto_id), UNIQUE INDEX UNIQ_E98D3D7E5EEADD3B (time_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time (id INT AUTO_INCREMENT NOT NULL, temps_reglage DOUBLE PRECISION DEFAULT NULL, temps_mo DOUBLE PRECISION DEFAULT NULL, temps_ma DOUBLE PRECISION DEFAULT NULL, acheminement DOUBLE PRECISION DEFAULT NULL, quantite DOUBLE PRECISION DEFAULT NULL, unite VARCHAR(24) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite_proto_poste_travail_proto ADD CONSTRAINT FK_E98D3D7E20A85E64 FOREIGN KEY (activite_proto_id) REFERENCES activite_proto (id)');
        $this->addSql('ALTER TABLE activite_proto_poste_travail_proto ADD CONSTRAINT FK_E98D3D7E9A589A2C FOREIGN KEY (poste_travail_proto_id) REFERENCES poste_travail_proto (id)');
        $this->addSql('ALTER TABLE activite_proto_poste_travail_proto ADD CONSTRAINT FK_E98D3D7E5EEADD3B FOREIGN KEY (time_id) REFERENCES time (id)');
        $this->addSql('ALTER TABLE activite_poste_travail ADD time_id INT DEFAULT NULL, DROP temps_reglage, DROP temps_mo, DROP temps_ma, CHANGE activite_id activite_id INT DEFAULT NULL, CHANGE poste_travail_id poste_travail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activite_poste_travail ADD CONSTRAINT FK_E076A7445EEADD3B FOREIGN KEY (time_id) REFERENCES time (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E076A7445EEADD3B ON activite_poste_travail (time_id)');
        $this->addSql('ALTER TABLE activite_proto CHANGE activite_id activite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE centre_production CHANGE departement_id departement_id INT DEFAULT NULL, CHANGE cout cout DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE gamme CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE classification classification VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE operation CHANGE gamme_id gamme_id INT DEFAULT NULL, CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE poste_travail ADD temps_reglage DOUBLE PRECISION DEFAULT NULL, ADD temps_mo DOUBLE PRECISION DEFAULT NULL, ADD temps_ma DOUBLE PRECISION DEFAULT NULL, ADD acheminement DOUBLE PRECISION DEFAULT NULL, ADD quantite DOUBLE PRECISION DEFAULT NULL, ADD unite VARCHAR(32) DEFAULT NULL, CHANGE centre_production_id centre_production_id INT DEFAULT NULL, CHANGE nature_pdt nature_pdt VARCHAR(12) DEFAULT NULL');
        $this->addSql('ALTER TABLE poste_travail_proto CHANGE pdt_id pdt_id INT DEFAULT NULL, CHANGE centre_production_id centre_production_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question CHANGE id_parent_reponse id_parent_reponse INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regle CHANGE ge_id ge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE id_parent_question id_parent_question INT DEFAULT NULL, CHANGE img img VARCHAR(255) DEFAULT NULL, CHANGE url url VARCHAR(2048) DEFAULT NULL, CHANGE created created DATETIME DEFAULT NULL, CHANGE updated updated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE api_token api_token VARCHAR(191) DEFAULT NULL, CHANGE lastname lastname VARCHAR(64) DEFAULT NULL, CHANGE firstname firstname VARCHAR(64) DEFAULT NULL, CHANGE birthday birthday DATETIME DEFAULT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL, CHANGE alias alias VARCHAR(5) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activite_poste_travail DROP FOREIGN KEY FK_E076A7445EEADD3B');
        $this->addSql('ALTER TABLE activite_proto_poste_travail_proto DROP FOREIGN KEY FK_E98D3D7E5EEADD3B');
        $this->addSql('DROP TABLE activite_proto_poste_travail_proto');
        $this->addSql('DROP TABLE time');
        $this->addSql('DROP INDEX UNIQ_E076A7445EEADD3B ON activite_poste_travail');
        $this->addSql('ALTER TABLE activite_poste_travail ADD temps_reglage DOUBLE PRECISION DEFAULT \'NULL\', ADD temps_mo DOUBLE PRECISION DEFAULT \'NULL\', ADD temps_ma DOUBLE PRECISION DEFAULT \'NULL\', DROP time_id, CHANGE activite_id activite_id INT DEFAULT NULL, CHANGE poste_travail_id poste_travail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activite_proto CHANGE activite_id activite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE centre_production CHANGE departement_id departement_id INT DEFAULT NULL, CHANGE cout cout DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE gamme CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE classification classification VARCHAR(10) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE operation CHANGE gamme_id gamme_id INT DEFAULT NULL, CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE poste_travail DROP temps_reglage, DROP temps_mo, DROP temps_ma, DROP acheminement, DROP quantite, DROP unite, CHANGE centre_production_id centre_production_id INT DEFAULT NULL, CHANGE nature_pdt nature_pdt VARCHAR(12) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE poste_travail_proto CHANGE pdt_id pdt_id INT DEFAULT NULL, CHANGE centre_production_id centre_production_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question CHANGE id_parent_reponse id_parent_reponse INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regle CHANGE ge_id ge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE gamme_enveloppe_id gamme_enveloppe_id INT DEFAULT NULL, CHANGE id_parent_question id_parent_question INT DEFAULT NULL, CHANGE img img VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE url url VARCHAR(2048) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE created created DATETIME DEFAULT \'NULL\', CHANGE updated updated DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE api_token api_token VARCHAR(191) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE lastname lastname VARCHAR(64) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE firstname firstname VARCHAR(64) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE birthday birthday DATETIME DEFAULT \'NULL\', CHANGE slug slug VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE alias alias VARCHAR(5) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
    }
}
