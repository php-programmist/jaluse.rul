<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Помещение')
            ->setEntityLabelInPlural('Помещения')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование помещения #<b>%entity_id%</b>')
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
        $id             = IntegerField::new('id', 'ID');
        $path           = UrlField::new('path', 'Ссылка');
        $cardImageUrl   = ImageField::new('cardImageUrl', 'Изображение в карточке');
        $seoImageUrl    = ImageField::new('seoImageUrl', 'SEO-Изображение');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $path, $published, $cardImageUrl, $seoImageUrl];
        }
    
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [
                ...DashboardController::getMainBlock(),
                $ourWorksFolder,
                ...DashboardController::getCardBlock(),
                ...DashboardController::getSeoBlock(),
            ];
        }
    }
}
