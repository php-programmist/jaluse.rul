<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210731053905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');
        
        $calculators = [
            [
                'name'      => 'Калькулятор вертикальных жалюзи',
                'parentUri' => 'zhalyuzi/vertikalnye',
                'uri'       => 'zhalyuzi/vertikalnye/kalkulyator',
            ],
            [
                'name'      => 'Калькулятор вертикальных тканевых жалюзи',
                'parentUri' => 'zhalyuzi/vertikalnye/tkanevye',
                'uri'       => 'zhalyuzi/vertikalnye/tkanevye/kalkulyator',
            ],
            [
                'name'      => 'Калькулятор вертикальных пластиковых жалюзи',
                'parentUri' => 'zhalyuzi/vertikalnye/plastikovyie',
                'uri'       => 'zhalyuzi/vertikalnye/plastikovyie/kalkulyator',
            ],
            [
                'name'      => 'Калькулятор горизонтальных жалюзи',
                'parentUri' => 'zhalyuzi/gorizontalnye',
                'uri'       => 'zhalyuzi/gorizontalnye/kalkulyator',
            ],
            [
                'name'      => 'Калькулятор горизонтальных алюминиевых жалюзи',
                'parentUri' => 'zhalyuzi/gorizontalnye/alyuminievye',
                'uri'       => 'zhalyuzi/gorizontalnye/alyuminievye/kalkulyator',
            ],
            [
                'name'      => 'Калькулятор горизонтальных деревянных жалюзи',
                'parentUri' => 'zhalyuzi/gorizontalnye/derevyannye',
                'uri'       => 'zhalyuzi/gorizontalnye/derevyannye/kalkulyator',
            ],
            [
                'name'      => 'Калькулятор горизонтальных Isolite жалюзи',
                'parentUri' => 'zhalyuzi/isolite',
                'uri'       => 'zhalyuzi/isolite/kalkulyator',
            ],
            [
                'name'      => 'Калькулятор жалюзи для пластиковых окон',
                'parentUri' => 'zhalyuzi',
                'uri'       => 'zhalyuzi/kalkulyator',
            ],
        ];
        foreach ($calculators as $calculator) {
            $this->addSql("insert into page (name, parent_id,page_type, uri,published,created_at,modified_at) values(?,?,'calculator',?,1,?,?)",
                [
                    $calculator['name'],
                    MigrationHelper::getPageIdByUri($this->connection, $calculator['parentUri']),
                    $calculator['uri'],
                    date('Y-m-d H:i:s'),
                    date('Y-m-d H:i:s'),
                ]);
        }
        
        $this->addSql("update page set parent_id = ?, page_type = 'calculator' where uri = ?", [
            MigrationHelper::getPageIdByUri($this->connection, 'zakaz-zhalyuzi'),
            'zakaz-zhalyuzi/kalkulyator-zhalyuzi',
        ]);
        
        $this->addSql("update page set parent_id = ?, page_type = 'calculator' where uri = ?", [
            MigrationHelper::getPageIdByUri($this->connection, 'rulonnyie-shtoryi'),
            'rulonnyie-shtoryi/kalkulyator',
        ]);
    }
}
