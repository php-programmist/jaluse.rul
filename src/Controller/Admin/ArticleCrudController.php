<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Field\CKEditorField;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Статья')
            ->setEntityLabelInPlural('Статьи')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование статьи #<b>%entity_id%</b>')
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
        $id           = IntegerField::new('id', 'ID');
        $path         = UrlField::new('path', 'Ссылка');
        $cardImageUrl = ImageField::new('cardImageUrl', 'Изображение в анонсе');
        $name         = TextField::new('name', 'Название');
        $uri          = TextField::new('uri', 'Ссылка');
        $published    = Field::new('published', 'Опубликован');
        $views        = NumberField::new('views', 'Просмотры');
        $content      = CKEditorField::new('content', 'Текст статьи');
        $mainPanel    = FormField::addPanel('Основные')->collapsible();
        $products     = AssociationField::new('products', 'Товары')->autocomplete();
        
        $mainBlock = [
            $mainPanel,
            $name,
            $uri,
            $views,
            $published,
            $products,
            $content,
        ];
        
        $cardDescription = CKEditorField::new('cardDescription', 'Описание в анонсе');
        $cardImageFile   = VichImageField::new('cardImageFile', 'Изображение в анонсе');
        
        $cardPanel = FormField::addPanel('Анонс')->collapsible();
        
        $anons = [
            $cardPanel,
            $cardDescription,
            $cardImageFile,
        ];
        
        $title       = TextField::new('title', 'Заголовок страницы');
        $description = TextareaField::new('description', 'Мета-описание');
        $seoPanel    = FormField::addPanel('SEO')->collapsible();
        
        $seo = [
            $seoPanel,
            $title,
            $description,
        ];
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $path, $published, $cardImageUrl, $views];
        }
        
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [
                ...$mainBlock,
                ...$anons,
                ...$seo,
            ];
        }
    }
}
