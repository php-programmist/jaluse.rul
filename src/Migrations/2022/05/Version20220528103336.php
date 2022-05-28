<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528103336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Заполняем список популярных каталогов';
    }
    
    public function up(Schema $schema): void
    {
        
        $this->addSql('update page set popular_categories = ? where uri = ?', [
            '{
            "Вертикальные жалюзи": "zhalyuzi/vertikalnye",
            "Горизонтальные жалюзи": "zhalyuzi/gorizontalnye",
            "Рулонные шторы": "rulonnyie-shtoryi",
            "Тканевые жалюзи": "zhalyuzi/vertikalnye/tkanevye",
            "Пластиковые жалюзи": "zhalyuzi/vertikalnye/plastikovyie",
            "Алюминиевые жалюзи": "zhalyuzi/gorizontalnye/alyuminievye",
            "Деревянные жалюзи": "zhalyuzi/gorizontalnye/derevyannye",
            "Плиссе": "zhalyuzi/plisse",
            "Римские шторы": "rimskies"
            }',
            'zhalyuzi',
        ]);
        
        $this->addSql('update page set popular_categories = ? where uri = ?', [
            '{
            "Isotra":"zhalyuzi/isolite",
            "Кассетные UNI":"rulonnyie-shtoryi/uni",
            "Кассетные UNI День Ночь":"rulonnyie-shtoryi/den-noch-uni-2",
            "Mini":"rulonnyie-shtoryi/mini",
            "Mini День Ночь":"rulonnyie-shtoryi/den-noch",
            "Жалюзи плиссе":"zhalyuzi/plisse"
            }',
            'zhalyuzi-na-okna-pvh',
        ]);
        
        $this->addSql('update page set popular_categories = ? where uri = ?', [
            '{
            "Кассетные UNI":"rulonnyie-shtoryi/uni",
            "Кассетные UNI День Ночь":"rulonnyie-shtoryi/den-noch-uni-2",
            "Mini":"rulonnyie-shtoryi/mini",
            "Mini День Ночь":"rulonnyie-shtoryi/den-noch",
            "Стандартные рулонные шторы":"rulonnyie-shtoryi/standartnye-rulonnye-shtory",
            "Стандартные День Ночь":"rulonnyie-shtoryi/standartnye-den-noch"
            }',
            'rulonnyie-shtoryi',
        ]);
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
