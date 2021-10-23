<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211023130747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем сущность примера работ';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE work_example (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, catalog_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address LONGTEXT DEFAULT NULL, type LONGTEXT DEFAULT NULL, collection LONGTEXT DEFAULT NULL, color LONGTEXT DEFAULT NULL, number INT DEFAULT NULL, place LONGTEXT DEFAULT NULL, location LONGTEXT DEFAULT NULL, make_days INT DEFAULT NULL, install_days INT DEFAULT NULL, total_price INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_BB2723BD4584665A (product_id), INDEX IDX_BB2723BDCC3C66FC (catalog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE work_example ADD CONSTRAINT FK_BB2723BD4584665A FOREIGN KEY (product_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE work_example ADD CONSTRAINT FK_BB2723BDCC3C66FC FOREIGN KEY (catalog_id) REFERENCES page (id)');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE work_example');
    }
}
