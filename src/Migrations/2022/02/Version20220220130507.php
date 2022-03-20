<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220130507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Подготовка БД для новых плиссе';
    }
    
    public function up(Schema $schema): void
    {
    
        // удаляем старые образцы
        $plisseCatalogId = 23;
        $stmt            = $this->connection->executeQuery('select id from page where parent_id = ?', [
            $plisseCatalogId,
        ]);
        $productsIds     = $stmt->fetchFirstColumn();
        foreach ($productsIds as $productId) {
            $this->addSql('UPDATE work_example SET product_id = null where product_id=?', [
                $productId,
            ]);
        }
    
        $this->addSql('DELETE from page where parent_id=?', [
            $plisseCatalogId,
        ]);
    
        //Добавляем подтипы
        $typeId = 175;
    
        $simpleMaterialId = 199;
        $this->addSql('insert into material (id, name, ordering) VALUES (?,?,?)', [
            $simpleMaterialId,
            'На обычные окна',
            0,
        ]);
        
        $mansardMaterialId = 200;
        $this->addSql('insert into material (id, name, ordering) VALUES (?,?,?)', [
            $mansardMaterialId,
            'На мансардные окна',
            1,
        ]);
        
        $arkMaterialId = 201;
        $this->addSql('insert into material (id, name, ordering) VALUES (?,?,?)', [
            $arkMaterialId,
            'На арочные окна',
            2,
        ]);
        
        $this->addSql('insert into material_type(material_id, type_id) VALUES (?,?)', [
            $simpleMaterialId,
            $typeId,
        ]);
        
        $this->addSql('insert into material_type(material_id, type_id) VALUES (?,?)', [
            $mansardMaterialId,
            $typeId,
        ]);
        
        $this->addSql('insert into material_type(material_id, type_id) VALUES (?,?)', [
            $arkMaterialId,
            $typeId,
        ]);
        
        $now = date('Y-m-d H:i:s');
        
        //Добавляем новые подразделы
        $this->addSql('insert into page (name, parent_id, page_type, uri, material_id, published, created_at, modified_at,name_genitive) VALUES (?,?,?,?,?,?,?,?,?)',
            [
                'Плиссе (шторы, жалюзи) на пластиковые окна',
                $plisseCatalogId,
                'catalog',
                'zhalyuzi/plisse/na-plastikovye-okna',
                $simpleMaterialId,
                true,
                $now,
                $now,
                'плиссе (шторы, жалюзи) на пластиковые окна',
            ]);
        $this->addSql('insert into page (name, parent_id, page_type, uri, material_id, published, created_at, modified_at,name_genitive) VALUES (?,?,?,?,?,?,?,?,?)',
            [
                'Плиссе мансардные (шторы, жалюзи)',
                $plisseCatalogId,
                'catalog',
                'zhalyuzi/plisse/mansardnye',
                $mansardMaterialId,
                true,
                $now,
                $now,
                'мансардных плиссе (шторы, жалюзи)',
            ]);
        $this->addSql('insert into page (name, parent_id, page_type, uri, material_id, published, created_at, modified_at,name_genitive) VALUES (?,?,?,?,?,?,?,?,?)',
            [
                'Плиссе арочные (шторы, жалюзи)',
                $plisseCatalogId,
                'catalog',
                'zhalyuzi/plisse/arochnye',
                $arkMaterialId,
                true,
                $now,
                $now,
                'арочных плиссе (шторы, жалюзи)',
            ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
