<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528070000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем каталог "Жалюзи на окна ПВХ"';
    }
    
    public function up(Schema $schema): void
    {
        $catalog = [
            'name'               => 'Жалюзи на окна ПВХ',
            'parent_id'          => 1,
            'page_type'          => 'catalog',
            'uri'                => 'zhalyuzi-na-okna-pvh',
            'type_id'            => null,
            'published'          => 1,
            'modified_at'        => '2022-05-28 16:15:22',
            'created_at'         => '2022-05-28 16:15:22',
            'name_genitive'      => 'жалюзи на окна ПВХ',
            'name_nominative'    => null,
            'seo_type'           => null,
            'filters'            => '{"type": "133,175,178"}',
            'catalog_links'      => '{"Isotra":"/zhalyuzi/isolite/", "Кассетные UNI":"/rulonnyie-shtoryi/uni/", "Кассетные UNI День Ночь":"/rulonnyie-shtoryi/den-noch-uni-2/", "Mini":"/rulonnyie-shtoryi/mini/", "Mini День Ночь":"/rulonnyie-shtoryi/den-noch/", "Жалюзи плиссе":"/zhalyuzi/plisse/"}',
            'excluded_materials' => '[195,196]',
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
