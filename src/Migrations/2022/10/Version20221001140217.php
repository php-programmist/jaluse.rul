<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001140217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем каталог помещений для вертикальных жалюзи';
    }
    
    public function up(Schema $schema): void
    {
        $parentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/vertikalnye');
        
        MigrationHelper::insertPage($this->connection, [
            'name'             => 'Помещения',
            'h1'               => '',
            'parent_id'        => $parentId,
            'page_type'        => 'catalog',
            'uri'              => 'zhalyuzi/vertikalnye/pomeshheniya',
            'title'            => 'Вертикальные Жалюзи, цвет Помещения купить на заказ в Москве, цена руб/м2',
            'geo_product_type' => 'zhalyuzi',
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
