<?php

namespace App\Controller\Admin;

use App\Entity\Material;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MaterialCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Material::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'name'])
            ->setPaginatorPageSize(100);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name     = TextField::new('name', 'Название');
        $type     = AssociationField::new('type');
        $products = AssociationField::new('products', 'Кол-во товаров');
        $id       = IntegerField::new('id', 'ID');
        $catalogs = AssociationField::new('catalogs', 'Кол-во каталогов');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $products, $catalogs];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $products, $catalogs, $type];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $type, $products];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $type, $products];
        }
    }
}
