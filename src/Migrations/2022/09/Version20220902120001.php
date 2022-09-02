<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220902120001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем подкаталоги в каталог "Исотра"';
    }
    
    public function up(Schema $schema): void
    {
        $parentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/isolite');
        
        $newParentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/isolite/25mm');
        
        $this->addSql('update page set parent_id = ? where parent_id = ? and page_type=?', [
            $newParentId,
            $parentId,
            'product',
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
