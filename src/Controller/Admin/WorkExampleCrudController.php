<?php

namespace App\Controller\Admin;

use App\Entity\WorkExample;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WorkExampleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WorkExample::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Пример работы')
            ->setEntityLabelInPlural('Примеры работы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование примера работы #<b>%entity_id%</b>')
            ->setSearchFields([
                'id',
                'name',
            ])
            ->overrideTemplate('crud/edit', 'admin/our_works/edit.html.twig');
    }
    
    public function configureFields(string $pageName): iterable
    {
        $id          = IntegerField::new('id', 'ID');
        $name        = TextField::new('name', 'Название');
        $position    = IntegerField::new('position', 'Порядок');
        $address     = TextField::new('address', 'Адрес монтажа');
        $type        = TextField::new('type', 'Вид изделия');
        $collection  = TextField::new('collection', 'Коллекция');
        $color       = TextField::new('color', 'Цвет');
        $number      = IntegerField::new('number', 'Количество окон');
        $place       = TextField::new('place', 'Где устанавливали');
        $location    = TextField::new('location', 'Помещение');
        $makeDays    = IntegerField::new('makeDays', 'Срок изготовления');
        $installDays = IntegerField::new('installDays', 'Срок установки');
        
        $product = AssociationField::new('product', 'Товар')->autocomplete();
        $catalog = AssociationField::new('catalog', 'Каталог');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $product, $catalog, $position];
        }
        
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [
                $name,
                $position,
                $product,
                $catalog,
                $address,
                $type,
                $collection,
                $color,
                $number,
                $place,
                $location,
                $makeDays,
                $installDays,
                $totalPrice,
            ];
        }
    }
}
