<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129090508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Удаляем более старые римские шторы';
    }
    
    public function up(Schema $schema): void
    {
        
        // удаляем старые образцы
        $romanCatalogId = 2420;
        $stmt           = $this->connection->executeQuery('select id from page where parent_id = ?', [
            $romanCatalogId,
        ]);
        $subCatalogsIds = $stmt->fetchFirstColumn();
        foreach ($subCatalogsIds as $subCatalogsId) {
            $this->addSql('DELETE from page where parent_id=?', [
                $subCatalogsId,
            ]);
        }
        $this->addSql('DELETE from page where parent_id=?', [
            $romanCatalogId,
        ]);
        $this->addSql('DELETE from page where id=?', [
            $romanCatalogId,
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
