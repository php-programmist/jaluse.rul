<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001140216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Заполняем поля base_catalog_id';
    }
    
    public function up(Schema $schema): void
    {
        $zhalyuziId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi');
        
        $this->addSql('update page set base_catalog_id = ? where page_type = ? AND uri like ?', [
            $zhalyuziId,
            'location',
            'zhalyuzi/%',
        ]);
        
        $rulonnyieShtoryiId = MigrationHelper::getPageIdByUri($this->connection, 'rulonnyie-shtoryi');
        
        $this->addSql('update page set base_catalog_id = ? where page_type = ? AND uri like ?', [
            $rulonnyieShtoryiId,
            'location',
            'rulonnyie-shtoryi/%',
        ]);
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
