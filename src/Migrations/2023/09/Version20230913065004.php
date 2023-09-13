<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913065004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем в subdomain таблицу список редиректов на поддомен';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subdomain ADD redirects LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subdomain DROP redirects');
    }
}
