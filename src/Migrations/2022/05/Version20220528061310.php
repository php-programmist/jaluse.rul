<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528061310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем поля для перезаписи ссылок на каталоги в боковом меню и списка исключенных подтипов';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD catalog_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD excluded_materials LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE seo_type seo_type VARCHAR(255) DEFAULT NULL');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP catalog_links, DROP excluded_materials, CHANGE seo_type seo_type VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
