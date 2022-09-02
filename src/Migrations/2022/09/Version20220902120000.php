<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220902120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Перемещаем товары из каталога "Исотра" в подкаталог';
    }
    
    public function up(Schema $schema): void
    {
        $parentId = MigrationHelper::getPageIdByUri($this->connection, 'zhalyuzi/isolite');
        
        $catalogLinks = '{"16 мм":"/zhalyuzi/isolite/16mm/", "25 мм":"/zhalyuzi/isolite/25mm/"}';
        
        $this->addSql('update page set catalog_links = ? where id = ?', [
            $catalogLinks,
            $parentId,
        ]);
        
        $pages = [
            [
                'name'          => 'Жалюзи Исотра 16 мм',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/isolite/16mm',
                'type_id'       => 178,
                'material_id'   => null,
                'name_genitive' => 'жалюзи Исотра 16 мм',
                'catalog_links' => $catalogLinks,
                'filters'       => '{"exact_catalog": true}',
            ],
            [
                'name'          => 'Жалюзи Исотра 25 мм',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/isolite/25mm',
                'type_id'       => 178,
                'material_id'   => null,
                'name_genitive' => 'жалюзи Исотра 25 мм',
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
