<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191121143217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activite_poste_travail (activite_id INT NOT NULL, poste_travail_id INT NOT NULL, INDEX IDX_E076A7449B0F88B1 (activite_id), INDEX IDX_E076A7449FEBDA9B (poste_travail_id), PRIMARY KEY(activite_id, poste_travail_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite_poste_travail ADD CONSTRAINT FK_E076A7449B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activite_poste_travail ADD CONSTRAINT FK_E076A7449FEBDA9B FOREIGN KEY (poste_travail_id) REFERENCES poste_travail (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE operation ADD gamme_enveloppe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DFF4082F2 FOREIGN KEY (gamme_enveloppe_id) REFERENCES gamme_enveloppe (id)');
        $this->addSql('CREATE INDEX IDX_1981A66DFF4082F2 ON operation (gamme_enveloppe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE activite_poste_travail');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DFF4082F2');
        $this->addSql('DROP INDEX IDX_1981A66DFF4082F2 ON operation');
        $this->addSql('ALTER TABLE operation DROP gamme_enveloppe_id');
    }
}
