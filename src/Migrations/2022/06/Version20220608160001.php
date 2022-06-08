<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Entity\Catalog;
use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608160001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем дополнительные страницы для каталога "Рулонные шторы на пластиковые окна"';
    }
    
    public function up(Schema $schema): void
    {
        $parentId = MigrationHelper::getPageIdByUri($this->connection, 'rulonnye-shtory-na-plastikovye-okna');
        
        $pages = [
            [
                'name'               => 'Элитные рулонные шторы премиум класса на пластиковые окна',
                'parent_id'          => $parentId,
                'page_type'          => 'catalog',
                'uri'                => 'rulonnye-shtory-na-plastikovye-okna/premium-klassa',
                'type_id'            => null,
                'name_genitive'      => 'элитных рулонных штор премиум класса на пластиковые окна',
                'name_nominative'    => null,
                'filters'            => '{"type": "133,175,178", "category": 3}',
                'excluded_materials' => '[195,196]',
                'hide_categories'    => true,
                'hide_filters'       => true,
                'seo_type'           => Catalog::SEO_TYPE_PREMIUM,
                'aggregate_catalog'  => 1,
            ],
            [
                'name'               => 'Рулонные шторы на пластиковые окна без сверления',
                'parent_id'          => $parentId,
                'page_type'          => 'catalog',
                'uri'                => 'rulonnye-shtory-na-plastikovye-okna/bez-sverleniya',
                'type_id'            => null,
                'name_genitive'      => 'рулонных штор на пластиковые окна без сверления',
                'name_nominative'    => null,
                'filters'            => '{"type": "133,175,178"}',
                'excluded_materials' => '[195,196]',
                'seo_type'           => Catalog::SEO_TYPE_NO_DRILL,
                'aggregate_catalog'  => 1,
            ],
            [
                'name'               => 'Рулонные шторы на пластиковые окна заказать с установкой',
                'parent_id'          => $parentId,
                'page_type'          => 'catalog',
                'uri'                => 'rulonnye-shtory-na-plastikovye-okna/s-ustanovkoy',
                'type_id'            => null,
                'name_genitive'      => 'рулонных штор на пластиковые окна заказать с установкой',
                'name_nominative'    => null,
                'filters'            => '{"type": "133,175,178"}',
                'excluded_materials' => '[195,196]',
                'seo_type'           => Catalog::SEO_TYPE_WITH_INSTALLATION,
                'aggregate_catalog'  => 1,
            ],
            [
                'name'               => 'Изготовление рулонных штор на пластиковые окна на заказ',
                'parent_id'          => $parentId,
                'page_type'          => 'catalog',
                'uri'                => 'rulonnye-shtory-na-plastikovye-okna/na-zakaz',
                'type_id'            => null,
                'name_genitive'      => 'рулонных штор на пластиковые окна на заказ',
                'name_nominative'    => null,
                'filters'            => '{"type": "133,175,178"}',
                'excluded_materials' => '[195,196]',
                'seo_type'           => Catalog::SEO_TYPE_FOR_ORDER,
                'aggregate_catalog'  => 1,
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
