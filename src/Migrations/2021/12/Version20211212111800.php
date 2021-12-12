<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211212111800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Настройки цен для товаров районов';
    }
    
    public function up(Schema $schema): void
    {
        
        $this->addSql("insert into config set title = ?,name = ?,value = ?", [
            'Районы. Цена жалюзи',
            'geo.zhalyuzi',
            'от 664 руб/м2',
        ]);
        
        $this->addSql("insert into config set title = ?,name = ?,value = ?", [
            'Районы. Цена рулонные шторы',
            'geo.rulonnyie-shtoryi',
            'от 1432 рублей за изделие',
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
