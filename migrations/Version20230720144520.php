<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230720144520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assistantes (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, filiale_id INT DEFAULT NULL, prospects_id INT DEFAULT NULL, assistante_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, civilite VARCHAR(40) DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, adresse VARCHAR(500) DEFAULT NULL, code_postal VARCHAR(20) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, telephone VARCHAR(50) DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, motif_contact VARCHAR(500) DEFAULT NULL, adresse_expertise VARCHAR(500) DEFAULT NULL, origine VARCHAR(100) DEFAULT NULL, notes VARCHAR(500) DEFAULT NULL, suites VARCHAR(255) DEFAULT NULL, statut VARCHAR(50) DEFAULT NULL, INDEX IDX_4C62E6385C4BCADC (filiale_id), INDEX IDX_4C62E638775D63D (prospects_id), INDEX IDX_4C62E638A2561908 (assistante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filiales (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6385C4BCADC FOREIGN KEY (filiale_id) REFERENCES filiales (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638775D63D FOREIGN KEY (prospects_id) REFERENCES filiales (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638A2561908 FOREIGN KEY (assistante_id) REFERENCES assistantes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6385C4BCADC');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638775D63D');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638A2561908');
        $this->addSql('DROP TABLE assistantes');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE filiales');
    }
}
