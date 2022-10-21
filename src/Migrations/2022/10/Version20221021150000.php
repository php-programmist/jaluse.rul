<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021150000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем каталог помещений для горизонтальных и алюминиевых';
    }
    
    public function up(Schema $schema): void
    {
        $parentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/gorizontalnye');
        
        MigrationHelper::insertPage($this->connection, [
            'name'             => 'Горизонтальные жалюзи для помещений',
            'h1'               => '',
            'parent_id'        => $parentId,
            'page_type'        => 'catalog',
            'uri'              => 'zhalyuzi/gorizontalnye/pomeshheniya',
            'title'            => 'Горизонтальные жалюзи, цвет Помещения купить на заказ в Москве, цена руб/м2',
            'geo_product_type' => 'zhalyuzi',
        ]);
        
        $parentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/gorizontalnye/alyuminievye');
        
        MigrationHelper::insertPage($this->connection, [
            'name'             => 'Горизонтальные алюминиевые жалюзи для помещений',
            'h1'               => '',
            'parent_id'        => $parentId,
            'page_type'        => 'catalog',
            'uri'              => 'zhalyuzi/gorizontalnye/alyuminievye/pomeshheniya',
            'title'            => 'Горизонтальные алюминиевые жалюзи, цвет Помещения купить на заказ в Москве, цена руб/м2',
            'geo_product_type' => 'zhalyuzi',
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
