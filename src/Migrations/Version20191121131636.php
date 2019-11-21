<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191121131636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation ADD pdt_id INT NOT NULL, ADD activite_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DAB0F5606 FOREIGN KEY (pdt_id) REFERENCES poste_travail (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('CREATE INDEX IDX_1981A66DAB0F5606 ON operation (pdt_id)');
        $this->addSql('CREATE INDEX IDX_1981A66D9B0F88B1 ON operation (activite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DAB0F5606');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D9B0F88B1');
        $this->addSql('DROP INDEX IDX_1981A66DAB0F5606 ON operation');
        $this->addSql('DROP INDEX IDX_1981A66D9B0F88B1 ON operation');
        $this->addSql('ALTER TABLE operation DROP pdt_id, DROP activite_id');
    }
}
