<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131142135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Увеличиваем порядок сортировки римских штор XL';
    }
    
    public function up(Schema $schema): void
    {
        $stmt     = $this->connection->executeQuery('SELECT id from page WHERE `uri` = ?', ['rimskies/xl']);
        $parentId = $stmt->fetchOne();
        
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE page SET ordering = 1 where parent_id = ?', [
            $parentId,
        ]);
    }
    
    public function down(Schema $schema): void
    {
    }
}
