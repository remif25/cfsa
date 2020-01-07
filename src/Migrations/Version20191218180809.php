<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191218180809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE poste_travail_proto_activite_proto (poste_travail_proto_id INT NOT NULL, activite_proto_id INT NOT NULL, INDEX IDX_3BBD569A589A2C (poste_travail_proto_id), INDEX IDX_3BBD5620A85E64 (activite_proto_id), PRIMARY KEY(poste_travail_proto_id, activite_proto_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poste_travail_proto_activite_proto ADD CONSTRAINT FK_3BBD569A589A2C FOREIGN KEY (poste_travail_proto_id) REFERENCES poste_travail_proto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poste_travail_proto_activite_proto ADD CONSTRAINT FK_3BBD5620A85E64 FOREIGN KEY (activite_proto_id) REFERENCES activite_proto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poste_travail_proto ADD centre_production_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE poste_travail_proto ADD CONSTRAINT FK_8F5F296F8876423D FOREIGN KEY (centre_production_id) REFERENCES centre_production (id)');
        $this->addSql('CREATE INDEX IDX_8F5F296F8876423D ON poste_travail_proto (centre_production_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE poste_travail_proto_activite_proto');
        $this->addSql('ALTER TABLE poste_travail_proto DROP FOREIGN KEY FK_8F5F296F8876423D');
        $this->addSql('DROP INDEX IDX_8F5F296F8876423D ON poste_travail_proto');
        $this->addSql('ALTER TABLE poste_travail_proto DROP centre_production_id');
    }
}
