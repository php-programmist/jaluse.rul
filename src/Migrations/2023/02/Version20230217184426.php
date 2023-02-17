<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217184426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем настройки для особых каталогов';
    }
    
    public function up(Schema $schema): void
    {
        $byPrice = [
            'zhalyuzi/bez-sverleniya',
            'zhalyuzi/na-zakaz',
            'zhalyuzi/s-ustanovkoy',
            'rulonnyie-shtoryi/bez-sverleniya',
            'rulonnyie-shtoryi/na-zakaz',
            'rulonnyie-shtoryi/s-ustanovkoy',
            'vertikalnye-zhalyuzi-na-okna/bez-sverleniya',
            'vertikalnye-zhalyuzi-na-okna/na-zakaz',
            'vertikalnye-zhalyuzi-na-okna/s-ustanovkoy',
            'zhalyuzi/gorizontalnye/bez-sverleniya',
            'zhalyuzi/gorizontalnye/na-zakaz',
            'zhalyuzi/gorizontalnye/s-ustanovkoy',
        ];
        
        $byPopular = [
            'vertikalnye-zhalyuzi-na-okna/tkanevye-zhalyuzi/bez-sverleniya',
            'vertikalnye-zhalyuzi-na-okna/tkanevye-zhalyuzi/na-zakaz',
            'vertikalnye-zhalyuzi-na-okna/tkanevye-zhalyuzi/s-ustanovkoy',
            'vertikalnye-zhalyuzi-na-okna/plastikovye-zhalyuzi/bez-sverleniya',
            'vertikalnye-zhalyuzi-na-okna/plastikovye-zhalyuzi/na-zakaz',
            'vertikalnye-zhalyuzi-na-okna/plastikovye-zhalyuzi/s-ustanovkoy',
            'zhalyuzi/gorizontalnye/alyuminievye/bez-sverleniya',
            'zhalyuzi/gorizontalnye/alyuminievye/na-zakaz',
            'zhalyuzi/gorizontalnye/alyuminievye/s-ustanovkoy',
            'zhalyuzi/gorizontalnye/derevyannye/bez-sverleniya',
            'zhalyuzi/gorizontalnye/derevyannye/na-zakaz',
            'zhalyuzi/gorizontalnye/derevyannye/s-ustanovkoy',
            'rulonnyie-shtoryi/den-noch-uni-2/bez-sverleniya',
            'rulonnyie-shtoryi/den-noch-uni-2/na-zakaz',
            'rulonnyie-shtoryi/den-noch-uni-2/s-ustanovkoy',
            'rulonnyie-shtoryi/mini/bez-sverleniya',
            'rulonnyie-shtoryi/mini/na-zakaz',
            'rulonnyie-shtoryi/mini/s-ustanovkoy',
        ];
        
        foreach ($byPopular as $uri) {
            $this->addSql('update page set settings = ? where uri = ?', [
                '{"default_ordering":"popular-desc", "products_per_page": 12}',
                $uri,
            ]);
        }
        
        foreach ($byPrice as $uri) {
            $this->addSql('update page set settings = ? where uri = ?', [
                '{"default_ordering":"price", "products_per_page": 12}',
                $uri,
            ]);
        }
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
