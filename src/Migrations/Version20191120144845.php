<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191120144845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gamme (id INT AUTO_INCREMENT NOT NULL, gamme_enveloppe_id INT DEFAULT NULL, nom VARCHAR(64) NOT NULL, description VARCHAR(255) DEFAULT NULL, classification VARCHAR(10) DEFAULT NULL, INDEX IDX_C32E1468FF4082F2 (gamme_enveloppe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gamme_enveloppe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link_regle_operation (id INT AUTO_INCREMENT NOT NULL, regle_id INT NOT NULL, operation_id INT NOT NULL, branche LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_567A45838E12947B (regle_id), UNIQUE INDEX UNIQ_567A458344AC3583 (operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, gamme_id INT DEFAULT NULL, numero INT NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_1981A66DD2FD85F1 (gamme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste_travail (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regle (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, aide LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E1468FF4082F2 FOREIGN KEY (gamme_enveloppe_id) REFERENCES gamme_enveloppe (id)');
        $this->addSql('ALTER TABLE link_regle_operation ADD CONSTRAINT FK_567A45838E12947B FOREIGN KEY (regle_id) REFERENCES regle (id)');
        $this->addSql('ALTER TABLE link_regle_operation ADD CONSTRAINT FK_567A458344AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DD2FD85F1 FOREIGN KEY (gamme_id) REFERENCES gamme (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DD2FD85F1');
        $this->addSql('ALTER TABLE gamme DROP FOREIGN KEY FK_C32E1468FF4082F2');
        $this->addSql('ALTER TABLE link_regle_operation DROP FOREIGN KEY FK_567A458344AC3583');
        $this->addSql('ALTER TABLE link_regle_operation DROP FOREIGN KEY FK_567A45838E12947B');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE gamme');
        $this->addSql('DROP TABLE gamme_enveloppe');
        $this->addSql('DROP TABLE link_regle_operation');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE poste_travail');
        $this->addSql('DROP TABLE regle');
    }
}
