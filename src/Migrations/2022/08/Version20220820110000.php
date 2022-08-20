<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220820110000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Заполняем список популярных каталогов для Горизонтальных алюминиевых жалюзи';
    }
    
    public function up(Schema $schema): void
    {
        
        $this->addSql('update page set popular_categories = ? where uri = ?', [
            '{
            "Алюминиевые жалюзи 16 мм": "zhalyuzi/gorizontalnye/alyuminievye/16mm",
            "Алюминиевые жалюзи 25 мм": "zhalyuzi/gorizontalnye/alyuminievye/25mm",
            "Алюминиевые жалюзи 50 мм": "zhalyuzi/gorizontalnye/alyuminievye/50mm"
            }',
            'zhalyuzi/gorizontalnye/alyuminievye',
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
