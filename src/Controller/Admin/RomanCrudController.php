<?php

namespace App\Controller\Admin;

use App\Entity\Roman;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class RomanCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Roman::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Римская штора')
            ->setEntityLabelInPlural('Римские шторы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование римской шторы #<b>%entity_id%</b>')
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
        $price          = IntegerField::new('price', 'Цена');
        $id             = IntegerField::new('id', 'ID');
        $path           = UrlField::new('path', 'Ссылка');
        $cardImageUrl   = ImageField::new('cardImageUrl', 'Изображение в карточке');
        $seoImageUrl    = ImageField::new('seoImageUrl', 'SEO-Изображение');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $path, $price, $published, $cardImageUrl, $seoImageUrl];
        }
    
        if (Crud::PAGE_EDIT === $pageName) {
            return [
                ...DashboardController::getMainBlock(),
                $ourWorksFolder,
                $price,
                ...DashboardController::getCardBlock(),
                ...DashboardController::getSeoBlock(),
            ];
        }
    }
}
