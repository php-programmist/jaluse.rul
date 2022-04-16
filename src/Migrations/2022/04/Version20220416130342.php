<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416130342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем каталоги "Без сверления"';
    }
    
    public function up(Schema $schema): void
    {
        $catalogs = [
            [
                'name'            => 'Жалюзи на пластиковые окна без сверления',
                'parent_id'       => 9,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'жалюзи на пластиковые окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
            ],
            [
                'name'            => 'Вертикальные жалюзи на окна без сверления',
                'parent_id'       => 20,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'вертикальных жалюзи на окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
            ],
            [
                'name'            => 'Горизонтальные жалюзи на окна без сверления',
                'parent_id'       => 21,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'горизонтальных жалюзи на окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
            ],
            [
                'name'            => 'Тканевые жалюзи на окна без сверления',
                'parent_id'       => 538,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/tkanevye/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'тканевых жалюзи на окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
            ],
            [
                'name'            => 'Пластиковые жалюзи на окна без сверления',
                'parent_id'       => 539,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/vertikalnye/plastikovyie/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'пластиковых жалюзи на окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
            ],
            [
                'name'            => 'Алюминиевые жалюзи на окна без сверления',
                'parent_id'       => 861,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/alyuminievye/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'алюминиевых жалюзи на окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
            ],
            [
                'name'            => 'Деревянные жалюзи на окна без сверления',
                'parent_id'       => 862,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/gorizontalnye/derevyannye/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'деревянных жалюзи на окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
            ],
            [
                'name'            => 'Жалюзи плиссе на окна без сверления',
                'parent_id'       => 23,
                'page_type'       => 'catalog',
                'uri'             => 'zhalyuzi/plisse/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'плиссе на окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
            ],
            [
                'name'            => 'Римские шторы на окна без сверления',
                'parent_id'       => 28,
                'page_type'       => 'catalog',
                'uri'             => 'rimskies/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'римских штор на окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
            ],
            [
                'name'            => 'Рулонные шторы на окна без сверления',
                'parent_id'       => 10,
                'page_type'       => 'catalog',
                'uri'             => 'rulonnyie-shtoryi/bez-sverleniya',
                'type_id'         => null,
                'published'       => 1,
                'modified_at'     => '2022-04-16 16:15:22',
                'created_at'      => '2022-04-16 16:15:22',
                'name_genitive'   => 'рулонных штор на окна без сверления',
                'name_nominative' => null,
                'no_drill'        => true,
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
