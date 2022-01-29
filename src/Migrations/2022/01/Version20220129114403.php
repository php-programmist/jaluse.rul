<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Entity\Product;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129114403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем отображаемые в карточке товара названия типа и материала';
    }
    
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material ADD card_type_name VARCHAR(255) DEFAULT NULL, ADD card_material_name VARCHAR(255) DEFAULT NULL');
        
        $this->addSql('ALTER TABLE type ADD card_type_name VARCHAR(255) DEFAULT NULL, ADD card_material_name VARCHAR(255) DEFAULT NULL');
        
        $this->addSql('update material set card_material_name = ? where id in (191,192,193,194,195,196,197,198)', [
            'ткань',
        ]);
        
        $this->addSql('update material set card_type_name = ? where id = ?', [
            'Алюминиевые жалюзи',
            89,
        ]);
        
        $this->addSql('update material set card_type_name = ? where id = ?', [
            'Деревянные жалюзи',
            188,
        ]);
        
        $this->addSql('update material set card_type_name = ? where id = ?', [
            'Пластиковые жалюзи',
            189,
        ]);
        
        $this->addSql('update material set card_type_name = ? where id = ?', [
            'Тканевые жалюзи',
            190,
        ]);
        
        $this->addSql('update material set card_type_name = ? where id = ?', [
            'XL',
            197,
        ]);
    
        $this->addSql('update material set card_type_name = ? where id = ?', [
            'Compact',
            198,
        ]);
    
        $this->addSql('update type set card_type_name = ?, card_material_name = ? where id = ?', [
            'Жалюзи Isolite',
            'алюминий',
            Product::ISOLITE_TYPE_ID,
        ]);
    
        $this->addSql('update type set card_type_name = ?, card_material_name = ? where id = ?', [
            '',
            'ткань',
            175,
        ]);
    }
    
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material DROP card_type_name, DROP card_material_name ');
        $this->addSql('ALTER TABLE type DROP card_type_name');
    }
}
