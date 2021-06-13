<?php

namespace App\Controller\Admin;

use App\Entity\Simple;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
        $cardDescription = TextareaField::new('cardDescription');
        $cardImageFile   = Field::new('cardImageFile', 'Изображение в карточке');
        $title           = TextField::new('title');
        $description     = TextareaField::new('description');
        $showSeoText     = Field::new('showSeoText');
        $content         = TextareaField::new('content');
        $seoImageFile    = Field::new('seoImageFile', 'SEO-Изображение');
        $ratingValue     = NumberField::new('ratingValue');
        $ratingCount     = IntegerField::new('ratingCount');
        $id              = IntegerField::new('id', 'ID');
        $yml             = Field::new('yml');
        $turbo           = Field::new('turbo');
        $createdAt       = DateTimeField::new('created_at');
        $modifiedAt      = DateTimeField::new('modified_at');
        $seoImage        = TextField::new('seoImage');
        $cardImage       = TextField::new('cardImage');
        $geoProductType  = TextField::new('geoProductType');
        $pages           = AssociationField::new('pages');
        $path            = UrlField::new('path', 'Ссылка');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $path, $published];
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
                $cardDescription,
                $cardImageFile,
                $title,
                $description,
                $showSeoText,
                $content,
                $seoImageFile,
                $ratingValue,
                $ratingCount,
            ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [
                $name,
                $uri,
                $parent,
                $published,
                $ourWorksFolder,
                $cardDescription,
                $cardImageFile,
                $title,
                $description,
                $showSeoText,
                $content,
                $seoImageFile,
                $ratingValue,
                $ratingCount,
            ];
        }
    }
}
