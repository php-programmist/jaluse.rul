<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211016091123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем связь между статьями и товарами';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_product (article_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_3E98401A7294869C (article_id), INDEX IDX_3E98401A4584665A (product_id), PRIMARY KEY(article_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_product ADD CONSTRAINT FK_3E98401A7294869C FOREIGN KEY (article_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_product ADD CONSTRAINT FK_3E98401A4584665A FOREIGN KEY (product_id) REFERENCES page (id) ON DELETE CASCADE');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_product');
    }
}
