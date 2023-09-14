<?php

namespace App\Controller\Admin;

use App\Entity\Subdomain;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubdomainCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Subdomain::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Поддомен')
            ->setEntityLabelInPlural('Поддомены')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование поддомена #<b>%entity_id%</b>')
            ->setSearchFields([
                'id',
                'name',
            ]);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $id                         = IntegerField::new('id', 'ID');
        $name                       = TextField::new('name', 'Название');
        $cityPrepositional          = TextField::new('cityPrepositional', 'Город в предложном падеже');
        $cityAndRegionPrepositional = TextField::new('cityAndRegionPrepositional',
            'Город и область в предложном падеже');
        $cityGenitive               = TextField::new('cityGenitive', 'Город в родительном падеже');
        $redirects                  = ArrayField::new('redirects', 'Редиректы');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name];
        }
    
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [
                $name,
                $cityPrepositional,
                $cityAndRegionPrepositional,
                $cityGenitive,
                $redirects,
            ];
        }
    
        return [];
    }
}
