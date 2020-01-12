<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191219142400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE regle ADD ge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regle ADD CONSTRAINT FK_F0C02F5A78C84753 FOREIGN KEY (ge_id) REFERENCES gamme_enveloppe (id)');
        $this->addSql('CREATE INDEX IDX_F0C02F5A78C84753 ON regle (ge_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE regle DROP FOREIGN KEY FK_F0C02F5A78C84753');
        $this->addSql('DROP INDEX IDX_F0C02F5A78C84753 ON regle');
        $this->addSql('ALTER TABLE regle DROP ge_id');
    }
}
