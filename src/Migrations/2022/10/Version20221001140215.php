<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001140215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем поля base_catalog_id и h1';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD base_catalog_id INT DEFAULT NULL, ADD h1 VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6205F86B5F0 FOREIGN KEY (base_catalog_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_140AB6205F86B5F0 ON page (base_catalog_id)');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB6205F86B5F0');
        $this->addSql('DROP INDEX IDX_140AB6205F86B5F0 ON page');
        $this->addSql('ALTER TABLE page DROP base_catalog_id, DROP h1');
    }
}
