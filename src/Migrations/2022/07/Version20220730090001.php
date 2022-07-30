<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220730090001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Заменяем ссылки в фильтрах для алюминиевых жалюзи';
    }
    
    public function up(Schema $schema): void
    {
        $this->addSql('update page set catalog_links = ? where uri = ?', [
            '{"16 мм":"/zhalyuzi/gorizontalnye/alyuminievye/16mm/", "25 мм":"/zhalyuzi/gorizontalnye/alyuminievye/25mm/", "50 мм":"/zhalyuzi/gorizontalnye/alyuminievye/50mm/"}',
            'zhalyuzi/gorizontalnye/alyuminievye',
        ]);
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
