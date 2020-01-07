<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191218162501 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activite_proto (id INT AUTO_INCREMENT NOT NULL, activite_id INT DEFAULT NULL, reference VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_956FF3EA9B0F88B1 (activite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite_proto ADD CONSTRAINT FK_956FF3EA9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE poste_travail DROP FOREIGN KEY FK_E033582B9A589A2C');
        $this->addSql('ALTER TABLE poste_travail DROP FOREIGN KEY FK_E033582B8876423D');
        $this->addSql('DROP INDEX UNIQ_E033582B9A589A2C ON poste_travail');
        $this->addSql('ALTER TABLE poste_travail DROP poste_travail_proto_id');
        $this->addSql('ALTER TABLE poste_travail ADD CONSTRAINT FK_E033582B8876423D FOREIGN KEY (centre_production_id) REFERENCES centre_production (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE activite_proto');
        $this->addSql('ALTER TABLE poste_travail DROP FOREIGN KEY FK_E033582B8876423D');
        $this->addSql('ALTER TABLE poste_travail ADD poste_travail_proto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE poste_travail ADD CONSTRAINT FK_E033582B9A589A2C FOREIGN KEY (poste_travail_proto_id) REFERENCES poste_travail_proto (id)');
        $this->addSql('ALTER TABLE poste_travail ADD CONSTRAINT FK_E033582B8876423D FOREIGN KEY (centre_production_id) REFERENCES centre_production (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E033582B9A589A2C ON poste_travail (poste_travail_proto_id)');
    }
}
