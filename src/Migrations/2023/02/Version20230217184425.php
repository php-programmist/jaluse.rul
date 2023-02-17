<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217184425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем настройки для каталогов';
    }
    
    public function up(Schema $schema): void
    {
        $byPopular = [
            'zhalyuzi',
            'zhalyuzi-na-okna-pvh',
            'rulonnyie-shtoryi',
            'vertikalnye-zhalyuzi-na-okna',
            'zhalyuzi/gorizontalnye',
        ];
        
        $byPrice = [
            'vertikalnye-zhalyuzi-na-okna/tkanevye-zhalyuzi',
            'vertikalnye-zhalyuzi-na-okna/plastikovye-zhalyuzi',
            'zhalyuzi/gorizontalnye/alyuminievye',
            'zhalyuzi/gorizontalnye/derevyannye',
            'zhalyuzi/isolite',
            'zhalyuzi/zhalyuzi-izolayt',
            'rulonnyie-shtoryi/den-noch-uni-2',
            'rulonnyie-shtoryi/uni',
            'rulonnyie-shtoryi/mini',
            'rulonnyie-shtoryi/den-noch',
            'rulonnyie-shtoryi/standartnye-rulonnye-shtory',
            'rulonnyie-shtoryi/standartnye-den-noch',
        ];
        
        foreach ($byPopular as $uri) {
            $this->addSql('update page set settings = ? where uri = ?', [
                '{"default_ordering":"popular-desc"}',
                $uri,
            ]);
        }
        
        foreach ($byPrice as $uri) {
            $this->addSql('update page set settings = ? where uri = ?', [
                '{"default_ordering":"price"}',
                $uri,
            ]);
        }
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
