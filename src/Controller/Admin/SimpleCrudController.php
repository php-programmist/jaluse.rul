<?php

namespace App\Controller\Admin;

use App\Entity\Simple;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SimpleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Simple::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Простая страница')
            ->setEntityLabelInPlural('Простые страницы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование простой страницы #<b>%entity_id%</b>')
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
        $name           = TextField::new('name', 'Название');
        $published      = Field::new('published', 'Опубликован');
        $ourWorksFolder = TextField::new('ourWorksFolder', 'Папка изображений наших работ');
        $ratingValue    = NumberField::new('ratingValue', 'Значение рейтинга');
        $ratingCount    = IntegerField::new('ratingCount', 'Кол-во голосов');
        $id             = IntegerField::new('id', 'ID');
        $path           = UrlField::new('path', 'Ссылка');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $path, $published];
        }
    
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [
                ...DashboardController::getMainBlock(),
                $ourWorksFolder,
                ...DashboardController::getCardBlock(),
                ...DashboardController::getSeoBlock(),
                $ratingValue,
                $ratingCount,
            ];
        }
    }
}
