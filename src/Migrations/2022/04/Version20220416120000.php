<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Корректируем фильтры каталогов';
    }
    
    public function up(Schema $schema): void
    {
        $this->addSql('update page set type_id = null, filters = ? where uri = ?', [
            '{"category": "3,2"}',
            'zhalyuzi/gorizontalnye/alyuminievye/premium-klassa',
        ]);
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
