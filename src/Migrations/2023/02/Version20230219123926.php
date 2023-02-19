<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219123926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем в каталог Жалюзи на пластиковые окна Вертикальные жалюзи';
    }
    
    public function up(Schema $schema): void
    {
        $this->addSql('update page set filters = ? where uri = ?',[
            '{"type": "86,132,178"}',
            'zhalyuzi'
        ]);
        
        $this->addSql('update page set popular = 2 where page_type = ? and uri like ? and popular =1',[
            'product',
            '%gorizontalnye%'
        ]);
        
    }
    
    public function down(Schema $schema): void
    {
        $this->addSql('update page set filters = ? where uri = ?',[
            '{"type": "132,178"}',
            'zhalyuzi'
        ]);
        $this->addSql('update page set popular = 1 where page_type = ? and uri like ? and popular =2',[
            'product',
            '%gorizontalnye%'
        ]);
    }
}
