<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220730090000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем подкаталоги в каталог "Алюминиевые горизонтальные жалюзи"';
    }
    
    public function up(Schema $schema): void
    {
        $parentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/gorizontalnye/alyuminievye');
        
        $catalogLinks = '{"16 мм":"/zhalyuzi/gorizontalnye/alyuminievye/16mm/", "25 мм":"/zhalyuzi/gorizontalnye/alyuminievye/25mm/", "50 мм":"/zhalyuzi/gorizontalnye/alyuminievye/50mm/"}';
        
        $pages = [
            [
                'name'          => 'Алюминиевые жалюзи 16 мм',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/gorizontalnye/alyuminievye/16mm',
                'type_id'       => 132,
                'material_id'   => 89,
                'name_genitive' => 'алюминиевых жалюзи 16 мм',
                'catalog_links' => $catalogLinks,
                'filters'       => '{"exact_catalog": true}',
            ],
            [
                'name'          => 'Алюминиевые жалюзи 25 мм',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/gorizontalnye/alyuminievye/25mm',
                'type_id'       => 132,
                'material_id'   => 89,
                'name_genitive' => 'алюминиевых жалюзи 25 мм',
                'catalog_links' => $catalogLinks,
                'filters'       => '{"exact_catalog": true}',
            ],
            [
                'name'          => 'Алюминиевые жалюзи 50 мм',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/gorizontalnye/alyuminievye/50mm',
                'type_id'       => 132,
                'material_id'   => 89,
                'name_genitive' => 'алюминиевых жалюзи 50 мм',
                'catalog_links' => $catalogLinks,
                'filters'       => '{"exact_catalog": true}',
            ],
        ];
        
        foreach ($pages as $page) {
            MigrationHelper::insertPage($this->connection, $page);
        }
        
        $newParentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/gorizontalnye/alyuminievye/25mm');
        
        $this->addSql('update page set parent_id = ? where parent_id = ? and page_type = ?', [
            $newParentId,
            $parentId,
            'product',
        ]);
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
