<?php

namespace App\Controller\Admin;

use App\Entity\Catalog;
use App\Form\FaqItemType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
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
            ->setEntityLabelInSingular('Каталог')
            ->setEntityLabelInPlural('Каталоги')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование каталога #<b>%entity_id%</b>')
            ->setSearchFields([
                'id',
                'name',
                'uri',
                'title',
                'description',
                'content',
                'cardDescription',
            ]);
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name           = TextField::new('name', 'Название');
        $parent         = AssociationField::new('parent', 'Родитель');
        $published      = Field::new('published', 'Опубликован');
        $type           = AssociationField::new('type', 'Тип');
        $material       = AssociationField::new('material', 'Подтип');
        $ourWorksFolder = TextField::new('ourWorksFolder', 'Папка изображений наших работ');
        $showSeoText    = Field::new('showSeoText', 'SEO-текст');
        $price          = NumberField::new('price', 'Цена');
        $id             = IntegerField::new('id', 'ID');
        $path           = UrlField::new('path', 'Ссылка');
        $typeName       = TextareaField::new('type.name', 'Тип');
        $materialName   = TextareaField::new('material.name', 'Подтип');
        $seoImageUrl = ImageField::new('seoImageUrl', 'SEO-Изображение');
        $recommendedTitle = TextField::new('recommendedTitle', 'Заголовок рекомендуемых товаров');
        $faqPanel = FormField::addPanel('FAQ')->collapsible();
        $faqTitle = TextField::new('faqTitle', 'Заголовок');
        $faq = CollectionField::new('faq', 'Вопросы и ответы')
                              ->setEntryType(FaqItemType::class)
                              ->showEntryLabel(false)
                              ->allowAdd()
                              ->allowDelete()
                              ->setEntryIsComplex(false)
                              ->addCssClass('w-100');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                $id,
                $name,
                $path,
                $parent,
                $published,
                $showSeoText,
                $typeName,
                $materialName,
                $price,
                $seoImageUrl,
            ];
        }
    
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [
                ...DashboardController::getMainBlock(),
                $type,
                $material,
                $ourWorksFolder,
                ...DashboardController::getCardBlock(),
                $price,
                ...DashboardController::getSeoBlock(),
                $recommendedTitle,
                $faqPanel,
                $faqTitle,
                $faq,
            ];
        }
    }
}
