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
            ->setEntityLabelInSingular('Подтип')
            ->setEntityLabelInPlural('Подтипы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование подтипа #<b>%entity_id%</b>')
            ->setSearchFields(['id', 'name']);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name     = TextField::new('name', 'Название');
        $type     = AssociationField::new('type', 'Тип');
        $products = AssociationField::new('products', 'Кол-во товаров');
        $id       = IntegerField::new('id', 'ID');
        $catalogs = AssociationField::new('catalogs', 'Кол-во каталогов');
        $ordering = IntegerField::new('ordering', 'Сортировка');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $products, $catalogs, $ordering];
        }
    
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [$name, $type, $products, $ordering];
        }
    }
}
