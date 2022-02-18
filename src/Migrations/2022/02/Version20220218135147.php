<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220218135147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем названия в родительном падеже';
    }
    
    public function up(Schema $schema): void
    {
        
        $uri_name_map = [
            'zhalyuzi/gorizontalnye/derevyannye'  => 'горизонтальных деревянных жалюзи',
            'zhalyuzi/gorizontalnye/alyuminievye' => 'алюминиевых горизонтальных жалюзи',
            'zhalyuzi/gorizontalnye'              => 'горизонтальных жалюзи',
            'zhalyuzi/vertikalnye/tkanevye'       => 'тканевых вертикальных жалюзи',
            'zhalyuzi/vertikalnye'                => 'вертикальных жалюзи',
            'zhalyuzi'                            => 'жалюзи на пластиковые окна',
            'zhalyuzi/rimskies'                   => 'римских штор',
            'zhalyuzi/plisse'                     => 'плиссе (жалюзи)',
            'rulonnyie-shtoryi'                   => 'рулонных штор',
        ];
        foreach ($uri_name_map as $uri => $name) {
            $this->addSql('UPDATE page set name_genitive = ? where uri = ?', [
                $name,
                $uri,
            ]);
        }
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
