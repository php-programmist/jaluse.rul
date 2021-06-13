<?php

namespace App\Controller\Admin;

use App\Entity\Color;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
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
            ->setEntityLabelInSingular('Цвет')
            ->setEntityLabelInPlural('Цвета')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование цвета #<b>%entity_id%</b>')
            ->setSearchFields(['id', 'name', 'alias', 'hex']);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name     = TextField::new('name', 'Название');
        $alias    = TextField::new('alias', 'Алиас');
        $hex      = ColorField::new('hex');
        $products = AssociationField::new('products', 'Кол-во товаров');
        $id       = IntegerField::new('id', 'ID');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $alias, $hex, $products];
        }
    
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [$name, $alias, $hex, $products];
        }
    }
}
