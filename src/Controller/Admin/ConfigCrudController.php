<?php

namespace App\Controller\Admin;

use App\Entity\Config;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
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
            ->setSearchFields(['id', 'name', 'value', 'title'])
            ->setPaginatorPageSize(100);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title', 'Название параметра');
        $name  = TextField::new('name', 'Системное имя');
        $value = TextField::new('value', 'Значение параметра');
        $id    = IntegerField::new('id', 'ID');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$title, $name, $value];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $value, $title];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title, $name, $value];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $name, $value];
        }
    }
}
