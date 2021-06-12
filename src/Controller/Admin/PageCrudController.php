<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
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
            ->setPaginatorPageSize(500);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name            = TextField::new('name');
        $uri             = TextField::new('uri');
        $title           = TextField::new('title');
        $description     = TextareaField::new('description');
        $published       = Field::new('published');
        $yml             = Field::new('yml');
        $turbo           = Field::new('turbo');
        $showSeoText     = Field::new('showSeoText');
        $createdAt       = DateTimeField::new('created_at');
        $modifiedAt      = DateTimeField::new('modified_at');
        $content         = TextareaField::new('content');
        $seoImage        = TextField::new('seoImage');
        $ourWorksFolder  = TextField::new('ourWorksFolder');
        $cardImage       = TextField::new('cardImage');
        $cardDescription = TextareaField::new('cardDescription');
        $geoProductType  = TextField::new('geoProductType');
        $ratingValue     = NumberField::new('ratingValue');
        $ratingCount     = IntegerField::new('ratingCount');
        $parent          = AssociationField::new('parent');
        $pages           = AssociationField::new('pages');
        $id              = IntegerField::new('id', 'ID');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $uri, $title, $published, $yml, $turbo];
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
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [
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
        }
    }
}
