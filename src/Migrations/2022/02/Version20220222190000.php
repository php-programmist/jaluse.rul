<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222190000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем настройку лимита товаров для мобильных';
    }
    
    public function up(Schema $schema): void
    {
        $this->addSql('insert into config (name, value, title) VALUES (?,?,?)', [
            'calc.products_catalog_limit_mobile',
            12,
            'Количество товаров на одной странице каталога (мобильные)',
        ]);
        
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
