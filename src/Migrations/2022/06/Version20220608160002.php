<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608160002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Обновляем список популярных категорий на странице рулонных штор';
    }
    
    public function up(Schema $schema): void
    {
        $this->addSql('update page set popular_categories = ? where uri = ?', [
            '{
            "Кассетные UNI":"rulonnyie-shtoryi/uni",
            "Кассетные UNI День Ночь":"rulonnyie-shtoryi/den-noch-uni-2",
            "Mini":"rulonnyie-shtoryi/mini",
            "Mini День Ночь":"rulonnyie-shtoryi/den-noch",
            "Стандартные рулонные шторы":"rulonnyie-shtoryi/standartnye-rulonnye-shtory",
            "Стандартные День Ночь":"rulonnyie-shtoryi/standartnye-den-noch",
            "Рулонные шторы на пластиковые окна":"rulonnye-shtory-na-plastikovye-okna",
            "Плиссе": "zhalyuzi/plisse",
            "Римские шторы": "rimskies",
            }',
            'rulonnyie-shtoryi',
        ]);
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
