<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use App\Helper\SlugHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809153905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем районы';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');
        
        $cities = [
            'в Зеленограде',
            'в Щербинке',
            'в Апрелевке',
            'в Дедовске',
            'в Мытищах',
            'в Старой Купавне',
            'в Электроуглях',
        ];
        
        $types = [
            [
                'parent_id' => MigrationHelper::getPageIdByUri($this->connection, 'moskovskoy-oblasti'),
                'base_uri'  => 'moskovskoy-oblasti/',
                'type'      => 'zhalyuzi',
            ],
            [
                'parent_id' => MigrationHelper::getPageIdByUri($this->connection,
                    'rulonnyie-shtoryi/moskovskoy-oblasti'),
                'base_uri'  => 'rulonnyie-shtoryi/moskovskoy-oblasti/',
                'type'      => 'rulonnyie-shtoryi',
            ],
        ];
        
        foreach ($cities as $city) {
            foreach ($types as $type) {
                $this->addSql('insert into page (name, parent_id, page_type, uri, published, modified_at, created_at,  geo_product_type) values (?,?,?,?,?,?,?,?)',
                    [
                        $city,
                        $type['parent_id'],
                        'city',
                        $type['base_uri'] . SlugHelper::makeSlug($city),
                        1,
                        date('Y-m-d H:i:s'),
                        date('Y-m-d H:i:s'),
                        $type['type'],
                    ]);
            }
        }
    }
}
