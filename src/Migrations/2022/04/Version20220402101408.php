<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402101408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавил премиум каталоги';
    }
    
    public function up(Schema $schema): void
    {
        $catalogs = [
            [
                'name'            => 'Элитные жалюзи премиум класса на пластиковые окна',
                'parent_id'       => 9,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/premium-klassa',
                'type_id'         => 86,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных жалюзи премиум класса на пластиковые окна',
                'name_nominative' => 'Жалюзи премиум класса на пластиковые окна',
                'filters'         => '{"category": 3}',
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
            [
                'name'            => 'Элитные вертикальные жалюзи на окна премиум класса',
                'parent_id'       => 20,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/premium-klassa',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных вертикальных жалюзи на окна премиум класса',
                'name_nominative' => 'Вертикальные жалюзи премиум класса',
                'filters'         => '{"category": 3}',
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
            [
                'name'            => 'Элитные горизонтальные жалюзи на окна премиум класса',
                'parent_id'       => 21,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/premium-klassa',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных горизонтальных жалюзи на окна премиум класса',
                'name_nominative' => 'Горизонтальные жалюзи премиум класса',
                'filters'         => '{"category": 3}',
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
            [
                'name'            => 'Элитные тканевые жалюзи на окна премиум класса',
                'parent_id'       => 538,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/tkanevye/premium-klassa',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных тканевых жалюзи на окна премиум класса',
                'name_nominative' => 'Тканевые жалюзи премиум класса',
                'filters'         => '{"category": 3}',
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
            [
                'name'            => 'Элитные пластиковые жалюзи на окна премиум класса',
                'parent_id'       => 539,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/plastikovyie/premium-klassa',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных пластиковых жалюзи на окна премиум класса',
                'name_nominative' => 'Пластиковые жалюзи премиум класса',
                'filters'         => '{"category": 3}',
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
            [
                'name'            => 'Элитные алюминиевые жалюзи на окна премиум класса',
                'parent_id'       => 861,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/alyuminievye/premium-klassa',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных алюминиевых жалюзи на окна премиум класса',
                'name_nominative' => 'Алюминиевые жалюзи премиум класса',
                'filters'         => '{"category": 3}',
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
            [
                'name'            => 'Элитные деревянные жалюзи на окна премиум класса',
                'parent_id'       => 862,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/derevyannye/premium-klassa',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных деревянных жалюзи на окна премиум класса',
                'name_nominative' => 'Деревянные жалюзи премиум класса',
                'filters'         => '{"category": 2}',
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
            [
                'name'            => 'Элитные жалюзи плиссе на окна премиум класса',
                'parent_id'       => 23,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/plisse/premium-klassa',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных жалюзи плиссе на окна премиум класса',
                'name_nominative' => 'Плиссе шторы премиум класса',
                'filters'         => null,
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
            [
                'name'            => 'Элитные римские шторы на окна премиум класса',
                'parent_id'       => 28,
                'page_type'       => 'catalog',
                'uri'             => 'rimskies/premium-klassa',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных римских штор на окна премиум класса',
                'name_nominative' => 'Римские шторы премиум класса',
                'filters'         => null,
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
            [
                'name'            => 'Элитные рулонные шторы на окна премиум класса',
                'parent_id'       => 10,
                'page_type'       => 'catalog',
                'uri'             => 'rulonnyie-shtoryi/premium-klassa',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-02-28 15:50:48',
                'created_at'      => '2022-02-28 15:50:48',
                'name_genitive'   => 'элитных рулонных штор на окна премиум класса',
                'name_nominative' => 'Рулонные шторы премиум класса',
                'filters'         => '{"category": 3}',
                'hide_categories' => true,
                'hide_filters'    => true,
                'premium'         => true,
            ],
        ];
        foreach ($catalogs as $catalog) {
            $fields       = array_keys($catalog);
            $values       = array_values($catalog);
            $placeholders = substr(str_repeat('?,', count($fields)), 0, -1);
            $this->addSql('insert into page (' . implode(',', $fields) . ') values(' . $placeholders . ')', $values);
        }
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
