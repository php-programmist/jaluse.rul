<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230904140510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем сущность настроек поддоменов';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subdomain (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, substitutions LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page CHANGE ordering ordering INT DEFAULT 0 NOT NULL');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE subdomain');
        $this->addSql('ALTER TABLE page CHANGE ordering ordering INT DEFAULT 0');
    }
}
