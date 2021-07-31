<?php

namespace App\Controller\Admin;

use App\Entity\Calculator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class CalculatorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Calculator::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Калькулятор')
            ->setEntityLabelInPlural('Калькуляторы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование калькулятора #<b>%entity_id%</b>')
            ->setSearchFields([
                'id',
                'name',
                'uri',
                'title',
                'description',
                'content',
            ]);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name      = TextField::new('name', 'Название');
        $published = Field::new('published', 'Опубликован');
        $id        = IntegerField::new('id', 'ID');
        $path      = UrlField::new('path', 'Ссылка');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $path, $published];
        }
        
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [
                ...DashboardController::getMainBlock(),
                ...DashboardController::getSeoBlock(),
            ];
        }
    }
}
