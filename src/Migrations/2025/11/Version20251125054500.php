<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251125054500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Заполняем названия в именительном падеже';
    }
    
    public function up(Schema $schema): void
    {
        $map = [
            'zhalyuzi'                                          => 'жалюзи на пластиковые окна',
            'vertikalnye-zhalyuzi-na-okna'                      => 'вертикальные жалюзи',
            'zhalyuzi/gorizontalnye'                            => 'горизонтальные жалюзи',
            'vertikalnye-zhalyuzi-na-okna/plastikovye-zhalyuzi' => 'пластиковые вертикальные жалюзи',
            'vertikalnye-zhalyuzi-na-okna/tkanevye-zhalyuzi'    => 'тканевые вертикальные жалюзи',
            'zhalyuzi/gorizontalnye/alyuminievye'               => 'горизонтальные алюминиевые жалюзи',
            'zhalyuzi/gorizontalnye/derevyannye'                => 'горизонтальные деревянные жалюзи',
            'rulonnyie-shtoryi'                                 => 'рулонные шторы',
            'rulonnyie-shtoryi/den-noch-uni-2'                  => 'рулонные шторы день-ночь',
            'rulonnyie-shtoryi/uni'                             => 'кассетные рулонные шторы',
            'zhalyuzi/plisse'                                   => 'шторы плиссе',
            'rimskies'                                          => 'римские шторы',
        ];
        
        foreach ($map as $uri => $value) {
            $this->addSql('UPDATE page set name_nominative = ? where uri = ?', [$value, $uri]);
        }
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
