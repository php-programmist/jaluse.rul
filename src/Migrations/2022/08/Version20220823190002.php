<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823190002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Заполняем список популярных каталогов для "Деревянные горизонтальные жалюзи"';
    }
    
    public function up(Schema $schema): void
    {
        $this->addSql('update page set popular_categories = ? where uri = ?', [
            '{
            "Деревянные жалюзи 25 мм": "zhalyuzi/gorizontalnye/derevyannye/25mm",
            "Деревянные жалюзи 50 мм": "zhalyuzi/gorizontalnye/derevyannye/50mm",
            "Бамбуковые жалюзи": "zhalyuzi/gorizontalnye/derevyannye/bambukovye"
            }',
            'zhalyuzi/gorizontalnye/derevyannye',
        ]);
        
        $this->addSql('update page set popular_categories = ? where uri = ?', [
            '{
            "Алюминиевые жалюзи 16 мм": "zhalyuzi/gorizontalnye/alyuminievye/16mm",
            "Алюминиевые жалюзи 25 мм": "zhalyuzi/gorizontalnye/alyuminievye/25mm",
            "Алюминиевые жалюзи 50 мм": "zhalyuzi/gorizontalnye/alyuminievye/50mm",
            "Деревянные жалюзи 25 мм": "zhalyuzi/gorizontalnye/derevyannye/25mm",
            "Деревянные жалюзи 50 мм": "zhalyuzi/gorizontalnye/derevyannye/50mm",
            "Бамбуковые жалюзи": "zhalyuzi/gorizontalnye/derevyannye/bambukovye"
            }',
            'zhalyuzi/gorizontalnye',
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
