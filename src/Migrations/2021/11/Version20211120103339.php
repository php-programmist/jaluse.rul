<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211120103339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем связи для примеров работ с типами, материалами и страницами';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE work_example_page (work_example_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_29CC2D58B0646AC2 (work_example_id), INDEX IDX_29CC2D58C4663E4 (page_id), PRIMARY KEY(work_example_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE work_example_page ADD CONSTRAINT FK_29CC2D58B0646AC2 FOREIGN KEY (work_example_id) REFERENCES work_example (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_example_page ADD CONSTRAINT FK_29CC2D58C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_example ADD product_type_id INT DEFAULT NULL, ADD product_material_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE work_example ADD CONSTRAINT FK_BB2723BD14959723 FOREIGN KEY (product_type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE work_example ADD CONSTRAINT FK_BB2723BD4F273270 FOREIGN KEY (product_material_id) REFERENCES material (id)');
        $this->addSql('CREATE INDEX IDX_BB2723BD14959723 ON work_example (product_type_id)');
        $this->addSql('CREATE INDEX IDX_BB2723BD4F273270 ON work_example (product_material_id)');
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE work_example_page');
        $this->addSql('ALTER TABLE work_example DROP FOREIGN KEY FK_BB2723BD14959723');
        $this->addSql('ALTER TABLE work_example DROP FOREIGN KEY FK_BB2723BD4F273270');
        $this->addSql('DROP INDEX IDX_BB2723BD14959723 ON work_example');
        $this->addSql('DROP INDEX IDX_BB2723BD4F273270 ON work_example');
        $this->addSql('ALTER TABLE work_example DROP product_type_id, DROP product_material_id');
    }
}
