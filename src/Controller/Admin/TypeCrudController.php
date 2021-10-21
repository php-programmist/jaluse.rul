<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Type::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Тип')
            ->setEntityLabelInPlural('Типы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование типа #<b>%entity_id%</b>')
            ->setSearchFields(['id', 'name', 'calculation_type']);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name             = TextField::new('name', 'Название');
        $materials        = AssociationField::new('materials', 'Кол-во материалов');
        $products         = AssociationField::new('products', 'Кол-во товаров');
        $id               = IntegerField::new('id', 'ID');
        $showMainPageCalc = BooleanField::new('showMainPageCalc', 'Калькулятор на главной');
        $calculationType  = TextField::new('calculationType', 'Тип расчета');
        $catalogs         = AssociationField::new('catalogs', 'Кол-во каталогов');
        $ordering         = IntegerField::new('ordering', 'Сортировка');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $products, $materials, $catalogs, $showMainPageCalc, $ordering];
        }
    
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [$name, $materials, $showMainPageCalc, $calculationType, $products, $ordering];
        }
    }
}
