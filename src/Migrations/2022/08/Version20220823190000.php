<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823190000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем подкаталоги в каталог "Деревянные горизонтальные жалюзи"';
    }
    
    public function up(Schema $schema): void
    {
        $parentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/gorizontalnye/derevyannye');
        
        $catalogLinks = '{"25 мм":"/zhalyuzi/gorizontalnye/derevyannye/25mm/", "50 мм":"/zhalyuzi/gorizontalnye/derevyannye/50mm/", "Бамбуковые":"/zhalyuzi/gorizontalnye/derevyannye/bambukovye/"}';
        
        $this->addSql('update page set catalog_links = ? where id = ?', [
            $catalogLinks,
            $parentId,
        ]);
        
        $pages = [
            [
                'name'          => 'Бамбуковые жалюзи',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/gorizontalnye/derevyannye/bambukovye',
                'type_id'       => 132,
                'material_id'   => 188,
                'name_genitive' => 'бамбуковых жалюзи',
                'catalog_links' => $catalogLinks,
                'filters'       => '{"exact_catalog": true}',
            ],
            [
                'name'          => 'Деревянные жалюзи 25 мм',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/gorizontalnye/derevyannye/25mm',
                'type_id'       => 132,
                'material_id'   => 188,
                'name_genitive' => 'деревянных жалюзи 25 мм',
                'catalog_links' => $catalogLinks,
                'filters'       => '{"exact_catalog": true}',
            ],
            [
                'name'          => 'Деревянные жалюзи 50 мм',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/gorizontalnye/derevyannye/50mm',
                'type_id'       => 132,
                'material_id'   => 188,
                'name_genitive' => 'деревянных жалюзи 50 мм',
                'catalog_links' => $catalogLinks,
                'filters'       => '{"exact_catalog": true}',
            ],
        ];
        
        foreach ($pages as $page) {
            MigrationHelper::insertPage($this->connection, $page);
        }
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
