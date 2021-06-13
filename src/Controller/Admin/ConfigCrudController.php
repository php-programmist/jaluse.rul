<?php

namespace App\Controller\Admin;

use App\Entity\Config;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConfigCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Config::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Параметр')
            ->setEntityLabelInPlural('Настройки')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование параметра #<b>%entity_id%</b>')
            ->setSearchFields(['id', 'name', 'value', 'title']);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title', 'Название параметра');
        $name  = TextField::new('name', 'Системное имя');
        $value = TextField::new('value', 'Значение параметра');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [$title, $name, $value];
        }
    
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [$title, $name, $value];
        }
    }
}
