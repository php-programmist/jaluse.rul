<?php

namespace App\Controller\Admin;

use App\Entity\Color;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ColorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Color::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'name', 'alias', 'hex'])
            ->setPaginatorPageSize(500);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name     = TextField::new('name', 'Название');
        $alias    = TextField::new('alias', 'Алиас');
        $hex      = TextField::new('hex');
        $products = AssociationField::new('products', 'Кол-во товаров');
        $id       = IntegerField::new('id', 'ID');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $alias, $hex, $products];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $alias, $hex, $products];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $alias, $hex, $products];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $alias, $hex, $products];
        }
    }
}
