<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Entity\Catalog;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428170004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем каталоги "На заказ"';
    }
    
    public function up(Schema $schema): void
    {
        $catalogs = [
            [
                'name'            => 'Изготовление жалюзи на пластиковые окна на заказ',
                'parent_id'       => 9,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'жалюзи на пластиковые окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление вертикальных жалюзи на окна на заказ',
                'parent_id'       => 20,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'вертикальных жалюзи на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление горизонтальных жалюзи на окна на заказ',
                'parent_id'       => 21,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'горизонтальных жалюзи на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление тканевых жалюзи на окна на заказ',
                'parent_id'       => 538,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/tkanevye/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'тканевых жалюзи на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление пластиковых жалюзи на окна на заказ',
                'parent_id'       => 539,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/plastikovyie/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'пластиковых жалюзи на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление алюминиевых жалюзи на окна на заказ',
                'parent_id'       => 861,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/alyuminievye/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'алюминиевых жалюзи на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление деревянных жалюзи на окна на заказ',
                'parent_id'       => 862,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/derevyannye/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'деревянных жалюзи на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление жалюзи плиссе на окна на заказ',
                'parent_id'       => 23,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/plisse/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'плиссе на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление римских штор на окна на заказ',
                'parent_id'       => 28,
                'page_type'       => 'catalog',
                'uri'             => 'rimskies/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'римских штор на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление рулонных штор на окна на заказ',
                'parent_id'       => 10,
                'page_type'       => 'catalog',
                'uri'             => 'rulonnyie-shtoryi/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'рулонных штор на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление рулонных штор Мини на окна на заказ',
                'parent_id'       => 2801,
                'page_type'       => 'catalog',
                'uri'             => 'rulonnyie-shtoryi/mini/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'рулонных штор Мини на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
            ],
            [
                'name'            => 'Изготовление рулонных штор День Ночь на окна на заказ',
                'parent_id'       => 2587,
                'page_type'       => 'catalog',
                'uri'             => 'rulonnyie-shtoryi/den-noch-uni-2/na-zakaz',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'рулонных штор День Ночь на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_FOR_ORDER,
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
