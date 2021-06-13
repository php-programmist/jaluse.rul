<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
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
            ->setSearchFields(['id', 'name', 'calculation_type'])
            ->setPaginatorPageSize(100);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name             = TextField::new('name', 'Название');
        $materials        = AssociationField::new('materials', 'Кол-во материалов');
        $showMainPageCalc = Field::new('showMainPageCalc', 'Калькулятор на главной');
        $calculationType  = Field::new('calculationType', 'Тип рассчета');
        $products         = AssociationField::new('products', 'Кол-во товаров');
        $id               = IntegerField::new('id', 'ID');
        $showMainPageCalc = Field::new('show_main_page_calc');
        $calculationType  = TextField::new('calculation_type');
        $catalogs         = AssociationField::new('catalogs', 'Кол-во каталогов');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $products, $materials, $catalogs, $showMainPageCalc];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $showMainPageCalc, $calculationType, $products, $catalogs, $materials];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $materials, $showMainPageCalc, $calculationType, $products];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $materials, $showMainPageCalc, $calculationType, $products];
        }
    }
}
