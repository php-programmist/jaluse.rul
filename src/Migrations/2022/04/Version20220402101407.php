<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402101407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавил поля для премиум каталогов';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD filters LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD hide_categories TINYINT(1) DEFAULT \'0\', ADD hide_filters TINYINT(1) DEFAULT \'0\', ADD premium TINYINT(1) DEFAULT \'0\'');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP filters, DROP hide_categories, DROP hide_filters, DROP premium');
    }
}
