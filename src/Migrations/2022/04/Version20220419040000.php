<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Helper\MigrationHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419040000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем калькуляторы для плиссе и римских штор';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');
        
        $calculators = [
            [
                'name'      => 'Калькулятор плиссе',
                'parentUri' => 'zhalyuzi/plisse',
                'uri'       => 'zhalyuzi/plisse/kalkulyator',
            ],
            [
                'name'      => 'Калькулятор римских штор',
                'parentUri' => 'rimskies',
                'uri'       => 'rimskies/kalkulyator',
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
        
    }
}
