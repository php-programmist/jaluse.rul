<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129090507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Подготовка БД для новых римских штор';
    }
    
    public function up(Schema $schema): void
    {
    
        // удаляем старые образцы
        $romanCatalogId = 28;
        $stmt           = $this->connection->executeQuery('select id from page where parent_id = ?', [
            $romanCatalogId,
        ]);
        $subCatalogsIds = $stmt->fetchFirstColumn();
        foreach ($subCatalogsIds as $subCatalogsId) {
            $this->addSql('DELETE from page where parent_id=?', [
                $subCatalogsId,
            ]);
        }
        $this->addSql('DELETE from page where parent_id=?', [
            $romanCatalogId,
        ]);
    
        //Добавляем тип и подтипы
        $typeId = 180;
        $this->addSql('insert into type (id,name, show_main_page_calc, calculation_type, ordering) VALUES (?,?,?,?,?)',
            [
                $typeId,
                'Римские шторы',
                true,
                'matrix',
                7,
            ]);
    
        $xlMaterialId = 197;
        $this->addSql('insert into material (id, name, ordering) VALUES (?,?,?)', [
            $xlMaterialId,
            'XL (на проем)',
            0,
        ]);
    
        $compactMaterialId = 198;
        $this->addSql('insert into material (id, name, ordering) VALUES (?,?,?)', [
            $compactMaterialId,
            'Compact (на створку)',
            1,
        ]);
    
        $this->addSql('insert into material_type(material_id, type_id) VALUES (?,?)', [
            $xlMaterialId,
            $typeId,
        ]);
    
        $this->addSql('insert into material_type(material_id, type_id) VALUES (?,?)', [
            $compactMaterialId,
            $typeId,
        ]);
        
        //Меняем настройки раздела
        $this->addSql('update page set type_id = ?, matrix_folder =?, matrix_id = ? where id = ?', [
            $typeId,
            'roman',
            1,
            $romanCatalogId,
        ]);
        $now = date('Y-m-d H:i:s');
        
        //Добавляем новые подразделы
        $this->addSql('insert into page (name, parent_id, page_type, uri, material_id, published, created_at, modified_at) VALUES (?,?,?,?,?,?,?,?)',
            [
                'Римские шторы XL (на оконный проем)',
                $romanCatalogId,
                'catalog',
                'rimskies/xl',
                $xlMaterialId,
                true,
                $now,
                $now,
            ]);
        $this->addSql('insert into page (name, parent_id, page_type, uri, material_id, published, created_at, modified_at) VALUES (?,?,?,?,?,?,?,?)',
            [
                'Римские шторы Compact (на створку окна)',
                $romanCatalogId,
                'catalog',
                'rimskies/compact',
                $compactMaterialId,
                true,
                $now,
                $now,
            ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
