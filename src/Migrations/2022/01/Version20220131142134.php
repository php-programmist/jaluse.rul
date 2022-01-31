<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131142134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем поле ручной сортировки товаров в каталоге';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD ordering INT DEFAULT 0');
        $this->addSql('ALTER TABLE type CHANGE card_material_name card_material_name VARCHAR(255) DEFAULT NULL');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP ordering');
        $this->addSql('ALTER TABLE type CHANGE card_material_name card_material_name VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
