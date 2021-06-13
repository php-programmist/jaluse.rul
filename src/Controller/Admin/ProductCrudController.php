<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Товар')
            ->setEntityLabelInPlural('Товары')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование товара #<b>%entity_id%</b>')
            ->setSearchFields([
                'id',
                'name',
                'uri',
                'title',
                'description',
                'content',
            ]);
    }
    
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('name', 'Название'))
            ->add(TextFilter::new('uri', 'Ссылка'))
            ->add(NumericFilter::new('price', 'Цена'))
            ->add(EntityFilter::new('type', 'Тип'))
            ->add(EntityFilter::new('material', 'Подтип'))
            ->add(EntityFilter::new('color', 'Цвет'))
            ->add(EntityFilter::new('category', 'Категория'))
            ->add(BooleanFilter::new('popular', 'Популярный'))
            ->add(BooleanFilter::new('published', 'Опубликован'))
            ->add(BooleanFilter::new('yml', 'YML'));
    }
    
    public function configureFields(string $pageName): iterable
    {
        $name             = TextField::new('name', 'Название');
        $price            = NumberField::new('price', 'Цена');
        $discount         = IntegerField::new('discount', 'Скидка');
        $type             = AssociationField::new('type', 'Тип');
        $material         = AssociationField::new('material', 'Подтип');
        $color            = AssociationField::new('color', 'Цвет');
        $category         = AssociationField::new('category', 'Категория');
        $popular          = Field::new('popular', 'Популярный');
        $published        = Field::new('published', 'Опубликован');
        $yml              = Field::new('yml', 'YML');
        $imageSmallFile   = VichImageField::new('imageSmallFile', 'Маленькое изображение');
        $imageBigFile     = VichImageField::new('imageBigFile', 'Большое изображение');
        $imageCatalogFile = VichImageField::new('imageCatalogFile', 'Изображение в каталоге');
        $id               = IntegerField::new('id', 'ID');
        $path             = UrlField::new('path', 'Ссылка');
        $imageSmall       = ImageField::new('imageSmall', 'Изображение');
        $parentName       = TextareaField::new('parent.name', 'Родитель');
        $typeName         = TextareaField::new('type.name', 'Тип');
        $materialName     = TextareaField::new('material.name', 'Подтип');
        $colorName        = TextareaField::new('color.name', 'Цвет');
        $categoryName     = TextareaField::new('category.name', 'Категория');
    
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                $id,
                $name,
                $path,
                $price,
                $imageSmall,
                $parentName,
                $typeName,
                $materialName,
                $colorName,
                $categoryName,
                $popular,
                $published,
                $yml,
            ];
        }
    
        if (in_array($pageName, [Crud::PAGE_EDIT, Crud::PAGE_NEW], true)) {
            return [
                ...DashboardController::getMainBlock(),
                $price,
                $discount,
                $type,
                $material,
                $color,
                $category,
                $popular,
                $yml,
                $imageSmallFile,
                $imageBigFile,
                $imageCatalogFile,
                ...DashboardController::getSeoBlock(),
            ];
        }
    }
}
