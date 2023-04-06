<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406062600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем плейсхолдеры для фильтров';
    }
    
    public function up(Schema $schema): void
    {
        $map = [
            'zhalyuzi'                            => 'Жалюзи',
            'zhalyuzi/gorizontalnye'              => 'Горизонтальные жалюзи',
            'vertikalnye-zhalyuzi-na-okna'        => 'Вертикальные жалюзи',
            'zhalyuzi/gorizontalnye/alyuminievye' => 'Алюминиевые',
            'zhalyuzi/gorizontalnye/derevyannye'  => 'Деревянные',
        ];
        
        foreach ($map as $uri => $placeholder) {
            $catalogId = MigrationHelper::getPageIdByUri($this->connection, $uri);
            $this->addSql("update page set settings = JSON_SET(settings, '$.filter_placeholder', ?) where id = ?", [
                $placeholder,
                $catalogId,
            ]);
        }
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
