<?php

namespace App\Controller\Admin;

use App\Entity\Roll;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class RollCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Roll::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields([
                'id',
                'name',
                'uri',
                'title',
                'description',
                'content',
                'seoImage',
                'ourWorksFolder',
                'cardImage',
                'cardDescription',
                'geoProductType',
                'ratingValue',
                'ratingCount',
                'price',
            ])
            ->setPaginatorPageSize(100);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name            = TextField::new('name', 'Название');
        $uri             = TextField::new('uri');
        $parent          = AssociationField::new('parent');
        $published       = Field::new('published', 'Опубликован');
        $ourWorksFolder  = TextField::new('ourWorksFolder');
        $price           = IntegerField::new('price', 'Цена');
        $cardDescription = TextareaField::new('cardDescription');
        $cardImageFile   = Field::new('cardImageFile', 'Изображение в карточке');
        $title           = TextField::new('title');
        $description     = TextareaField::new('description');
        $showSeoText     = Field::new('showSeoText');
        $content         = TextareaField::new('content');
        $seoImageFile    = Field::new('seoImageFile', 'SEO-Изображение');
        $id              = IntegerField::new('id', 'ID');
        $yml             = Field::new('yml');
        $turbo           = Field::new('turbo');
        $createdAt       = DateTimeField::new('created_at');
        $modifiedAt      = DateTimeField::new('modified_at');
        $seoImage        = TextField::new('seoImage');
        $cardImage       = TextField::new('cardImage');
        $geoProductType  = TextField::new('geoProductType');
        $ratingValue     = NumberField::new('ratingValue');
        $ratingCount     = IntegerField::new('ratingCount');
        $pages           = AssociationField::new('pages');
        $path            = UrlField::new('path', 'Ссылка');
        $cardImageUrl    = ImageField::new('cardImageUrl', 'Изображение в карточке');
        $seoImageUrl     = ImageField::new('seoImageUrl', 'SEO-Изображение');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $path, $price, $published, $cardImageUrl, $seoImageUrl];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [
                $id,
                $name,
                $uri,
                $title,
                $description,
                $published,
                $yml,
                $turbo,
                $showSeoText,
                $createdAt,
                $modifiedAt,
                $content,
                $seoImage,
                $ourWorksFolder,
                $cardImage,
                $cardDescription,
                $geoProductType,
                $ratingValue,
                $ratingCount,
                $price,
                $parent,
                $pages,
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [
                $name,
                $uri,
                $parent,
                $published,
                $ourWorksFolder,
                $price,
                $cardDescription,
                $cardImageFile,
                $title,
                $description,
                $showSeoText,
                $content,
                $seoImageFile,
            ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [
                $name,
                $uri,
                $parent,
                $published,
                $ourWorksFolder,
                $price,
                $cardDescription,
                $cardImageFile,
                $title,
                $description,
                $showSeoText,
                $content,
                $seoImageFile,
            ];
        }
    }
}
