<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608160000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем каталог "Рулонные шторы на пластиковые окна"';
    }
    
    public function up(Schema $schema): void
    {
        $catalog = [
            'name'               => 'Рулонные шторы на пластиковые окна',
            'parent_id'          => 1,
            'page_type'          => 'catalog',
            'uri'                => 'rulonnye-shtory-na-plastikovye-okna',
            'type_id'            => null,
            'published'          => 1,
            'modified_at'        => '2022-06-08 16:15:22',
            'created_at'         => '2022-06-08 16:15:22',
            'name_genitive'      => 'рулонных штор на пластиковые окна',
            'name_nominative'    => null,
            'seo_type'           => null,
            'filters'            => '{"type": "133,175,178"}',
            'catalog_links'      => '{"Кассетные UNI":"/rulonnyie-shtoryi/uni/", "Кассетные UNI День Ночь":"/rulonnyie-shtoryi/den-noch-uni-2/", "Mini":"/rulonnyie-shtoryi/mini/", "Mini День Ночь":"/rulonnyie-shtoryi/den-noch/","Isotra":"/zhalyuzi/isolite/", "Жалюзи плиссе":"/zhalyuzi/plisse/"}',
            'excluded_materials' => '[195,196]',
            'popular_categories' => '{
            "Кассетные UNI":"rulonnyie-shtoryi/uni",
            "Кассетные UNI День Ночь":"rulonnyie-shtoryi/den-noch-uni-2",
            "Mini":"rulonnyie-shtoryi/mini",
            "Mini День Ночь":"rulonnyie-shtoryi/den-noch",
            "Isotra":"zhalyuzi/isolite",
            "Жалюзи плиссе":"zhalyuzi/plisse"
            }',
            'aggregate_catalog'  => 1,
        ];
        
        $fields       = array_keys($catalog);
        $values       = array_values($catalog);
        $placeholders = substr(str_repeat('?,', count($fields)), 0, -1);
        $this->addSql('insert into page (' . implode(',', $fields) . ') values(' . $placeholders . ')', $values);
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
