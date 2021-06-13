<?php

namespace App\Controller\Admin;

use App\Entity\Catalog;
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

class CatalogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Catalog::class;
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
                'matrix_folder',
                'price',
                'recommendedTitle',
            ])
            ->setPaginatorPageSize(100);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name             = TextField::new('name', 'Название');
        $uri              = TextField::new('uri');
        $parent           = AssociationField::new('parent', 'Родитель');
        $published        = Field::new('published', 'Опубликован');
        $type             = AssociationField::new('type');
        $material         = AssociationField::new('material');
        $ourWorksFolder   = TextField::new('ourWorksFolder');
        $price            = NumberField::new('price');
        $cardDescription  = TextareaField::new('cardDescription');
        $cardImageFile    = Field::new('cardImageFile', 'Изображение в карточке');
        $title            = TextField::new('title');
        $recommendedTitle = TextField::new('recommendedTitle');
        $description      = TextareaField::new('description');
        $showSeoText      = Field::new('showSeoText');
        $content          = TextareaField::new('content');
        $seoImageFile     = Field::new('seoImageFile', 'SEO-Изображение');
        $id               = IntegerField::new('id', 'ID');
        $yml              = Field::new('yml');
        $turbo            = Field::new('turbo');
        $createdAt        = DateTimeField::new('created_at');
        $modifiedAt       = DateTimeField::new('modified_at');
        $seoImage         = TextField::new('seoImage');
        $cardImage        = TextField::new('cardImage');
        $geoProductType   = TextField::new('geoProductType');
        $ratingValue      = NumberField::new('ratingValue');
        $ratingCount      = IntegerField::new('ratingCount');
        $matrixFolder     = TextField::new('matrix_folder');
        $pages            = AssociationField::new('pages');
        $path             = UrlField::new('path', 'Ссылка');
        $typeName         = TextareaField::new('type.name', 'Тип');
        $materialName     = TextareaField::new('material.name', 'Подтип');
        $seoImageUrl      = ImageField::new('seoImageUrl', 'SEO-Изображение');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $path, $parent, $published, $showSeoText, $typeName, $materialName, $seoImageUrl];
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
                $matrixFolder,
                $price,
                $recommendedTitle,
                $parent,
                $pages,
                $type,
                $material,
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [
                $name,
                $uri,
                $parent,
                $published,
                $type,
                $material,
                $ourWorksFolder,
                $price,
                $cardDescription,
                $cardImageFile,
                $title,
                $recommendedTitle,
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
                $type,
                $material,
                $ourWorksFolder,
                $price,
                $cardDescription,
                $cardImageFile,
                $title,
                $recommendedTitle,
                $description,
                $showSeoText,
                $content,
                $seoImageFile,
            ];
        }
    }
}
