<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220917140000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем каталог Isolite и подкаталоги';
    }
    
    public function up(Schema $schema): void
    {
        $typeId = 181;
        $this->connection->executeQuery('insert into type (id,name, show_main_page_calc, calculation_type, ordering) VALUES (?,?,?,?,?)',
            [
                $typeId,
                'Isolite',
                true,
                'simple',
                8,
            ]);
        
        $catalogLinks = '{"16 мм":"/zhalyuzi/zhalyuzi-izolayt/16mm/", "25 мм":"/zhalyuzi/zhalyuzi-izolayt/25mm/"}';
        
        $parentPage = [
            'name'               => 'Жалюзи Изолайт (Isolite)',
            'parent_id'          => 9,
            'page_type'          => 'catalog',
            'uri'                => 'zhalyuzi/zhalyuzi-izolayt',
            'type_id'            => $typeId,
            'material_id'        => null,
            'name_genitive'      => 'жалюзи Изолайт (Isolite)',
            'catalog_links'      => $catalogLinks,
            'filters'            => null,
            'popular_categories' => '{
            "Жалюзи Изолайт 16 мм": "zhalyuzi/zhalyuzi-izolayt/16mm",
            "Жалюзи Изолайт 25 мм": "zhalyuzi/zhalyuzi-izolayt/25mm",
            "Жалюзи Исотра": "zhalyuzi/isolite"
            }',
        ];
        $parentId   = MigrationHelper::insertPage($this->connection, $parentPage);
        
        $pages = [
            [
                'name'          => 'Жалюзи Изолайт (Isolite) 16 мм',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/zhalyuzi-izolayt/16mm',
                'type_id'       => $typeId,
                'material_id'   => null,
                'name_genitive' => 'жалюзи Изолайт (Isolite) 16 мм',
                'catalog_links' => $catalogLinks,
                'filters'       => '{"exact_catalog": true}',
            ],
            [
                'name'          => 'Жалюзи Изолайт (Isolite) 25 мм',
                'parent_id'     => $parentId,
                'page_type'     => 'catalog',
                'uri'           => 'zhalyuzi/zhalyuzi-izolayt/25mm',
                'type_id'       => $typeId,
                'material_id'   => null,
                'name_genitive' => 'жалюзи Изолайт (Isolite) Исотра 25 мм',
                'catalog_links' => $catalogLinks,
                'filters'       => '{"exact_catalog": true}',
            ],
        ];
        
        foreach ($pages as $page) {
            MigrationHelper::insertPage($this->connection, $page);
        }
        
        $this->addSql('update page set popular_categories = ? where uri = ?', [
            '{
            "Жалюзи Исотра 16 мм": "zhalyuzi/isolite/16mm",
            "Жалюзи Исотра 25 мм": "zhalyuzi/isolite/25mm",
            "Жалюзи Изолайт": "zhalyuzi/zhalyuzi-izolayt"
            }',
            'zhalyuzi/isolite',
        ]);
        
        $this->addSql('update page set modified_at = ?', [
            date('Y-m-d H:i:s'),
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
