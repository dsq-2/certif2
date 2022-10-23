<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221023045439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profession (id INT AUTO_INCREMENT NOT NULL, metier VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', code_postal VARCHAR(60) NOT NULL, ville VARCHAR(60) NOT NULL, INDEX IDX_EAA5610EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, prenom VARCHAR(150) DEFAULT NULL, nom VARCHAR(150) NOT NULL, adresse VARCHAR(150) NOT NULL, code_postal VARCHAR(150) NOT NULL, ville VARCHAR(150) NOT NULL, telephone VARCHAR(150) NOT NULL, nr_siret VARCHAR(150) DEFAULT NULL, is_pro TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profession (user_id INT NOT NULL, profession_id INT NOT NULL, INDEX IDX_1DF4CB85A76ED395 (user_id), INDEX IDX_1DF4CB85FDEF8996 (profession_id), PRIMARY KEY(user_id, profession_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_profession ADD CONSTRAINT FK_1DF4CB85A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_profession ADD CONSTRAINT FK_1DF4CB85FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610EA76ED395');
        $this->addSql('ALTER TABLE user_profession DROP FOREIGN KEY FK_1DF4CB85A76ED395');
        $this->addSql('ALTER TABLE user_profession DROP FOREIGN KEY FK_1DF4CB85FDEF8996');
        $this->addSql('DROP TABLE profession');
        $this->addSql('DROP TABLE realisation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_profession');
    }
}
