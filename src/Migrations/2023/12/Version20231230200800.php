<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231230200800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('insert into page (name, parent_id,page_type, uri, title, description, published, created_at, modified_at) values (?,?,?,?,?,?,?,?,?)',
            [
                'Жалюзи по городам',
                1,
                'simple',
                'incities',
                'Жалюзи по городам',
                'Жалюзи по городам',
                1,
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s'),
            ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
