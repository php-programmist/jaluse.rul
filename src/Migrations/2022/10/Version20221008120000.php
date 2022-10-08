<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221008120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем каталог помещений для вертикальных тканевых жалюзи';
    }
    
    public function up(Schema $schema): void
    {
        $parentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/vertikalnye/tkanevye');
        
        MigrationHelper::insertPage($this->connection, [
            'name'             => 'Вертикальные тканевые жалюзи для помещений',
            'h1'               => '',
            'parent_id'        => $parentId,
            'page_type'        => 'catalog',
            'uri'              => 'zhalyuzi/vertikalnye/tkanevye/pomeshheniya',
            'title'            => 'Вертикальные Тканевые Жалюзи, цвет Помещения купить на заказ в Москве, цена руб/м2',
            'geo_product_type' => 'zhalyuzi',
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
