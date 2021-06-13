<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
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
        $products = AssociationField::new('products', 'Кол-во товаров');
        $id       = IntegerField::new('id', 'ID');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $products];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $products];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $products];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $products];
        }
    }
}
