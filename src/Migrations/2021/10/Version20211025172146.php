<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025172146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work_example ADD measuring_price INT DEFAULT 0 NOT NULL, CHANGE make_days make_days INT DEFAULT 3 NOT NULL, CHANGE install_days install_days INT DEFAULT 1 NOT NULL');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work_example DROP measuring_price, CHANGE make_days make_days INT DEFAULT NULL, CHANGE install_days install_days INT DEFAULT NULL');
    }
}
