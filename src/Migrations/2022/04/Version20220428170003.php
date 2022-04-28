<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Entity\Catalog;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428170003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем каталоги "С установкой"';
    }
    
    public function up(Schema $schema): void
    {
        $catalogs = [
            [
                'name'            => 'Жалюзи на пластиковые окна заказать с установкой',
                'parent_id'       => 9,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'жалюзи на пластиковые окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Вертикальные жалюзи на окна заказать с установкой',
                'parent_id'       => 20,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'вертикальных жалюзи на окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Горизонтальные жалюзи на окна заказать с установкой',
                'parent_id'       => 21,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'горизонтальных жалюзи на окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Тканевые жалюзи на окна заказать с установкой',
                'parent_id'       => 538,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/tkanevye/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'тканевых жалюзи на окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Пластиковые жалюзи на окна заказать с установкой',
                'parent_id'       => 539,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/plastikovyie/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'пластиковых жалюзи на окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Алюминиевые жалюзи на окна заказать с установкой',
                'parent_id'       => 861,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/alyuminievye/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'алюминиевых жалюзи на окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Деревянные жалюзи на окна заказать с установкой',
                'parent_id'       => 862,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/derevyannye/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'деревянных жалюзи на окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Жалюзи плиссе на окна заказать с установкой',
                'parent_id'       => 23,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/plisse/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'плиссе на окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Римские шторы на окна заказать с установкой',
                'parent_id'       => 28,
                'page_type'       => 'catalog',
                'uri'             => 'rimskies/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'римских штор на окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Рулонные шторы на окна заказать с установкой',
                'parent_id'       => 10,
                'page_type'       => 'catalog',
                'uri'             => 'rulonnyie-shtoryi/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'рулонных штор на окна заказать с установкой',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Рулонные шторы Мини на окна заказать с установкой',
                'parent_id'       => 2801,
                'page_type'       => 'catalog',
                'uri'             => 'rulonnyie-shtoryi/mini/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'рулонных штор Мини на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
            ],
            [
                'name'            => 'Рулонные шторы День Ночь на окна заказать с установкой',
                'parent_id'       => 2587,
                'page_type'       => 'catalog',
                'uri'             => 'rulonnyie-shtoryi/den-noch-uni-2/s-ustanovkoy',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'рулонных штор День Ночь на окна на заказ',
                'name_nominative' => null,
                'seo_type'        => Catalog::SEO_TYPE_WITH_INSTALLATION,
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
