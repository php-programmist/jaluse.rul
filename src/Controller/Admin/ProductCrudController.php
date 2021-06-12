<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
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
                'discount',
                'matrix_id',
                'imageSmallName',
                'imageBigName',
                'imageCatalogName',
            ])
            ->setPaginatorPageSize(500);
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
        $uri              = TextField::new('uri');
        $price            = NumberField::new('price', 'Цена');
        $discount         = IntegerField::new('discount');
        $parent           = AssociationField::new('parent');
        $type             = AssociationField::new('type');
        $material         = AssociationField::new('material');
        $color            = AssociationField::new('color');
        $category         = AssociationField::new('category');
        $popular          = Field::new('popular', 'Популярный');
        $published        = Field::new('published', 'Опубликован');
        $yml              = Field::new('yml', 'YML');
        $imageSmallFile   = Field::new('imageSmallFile', 'Маленькое изображение');
        $imageBigFile     = Field::new('imageBigFile', 'Большое изображение');
        $imageCatalogFile = Field::new('imageCatalogFile', 'Изображение в каталоге');
        $title            = TextField::new('title');
        $description      = TextareaField::new('description');
        $showSeoText      = Field::new('showSeoText');
        $content          = TextareaField::new('content');
        $seoImageFile     = Field::new('seoImageFile', 'SEO-Изображение');
        $id               = IntegerField::new('id', 'ID');
        $turbo            = Field::new('turbo');
        $createdAt        = DateTimeField::new('created_at');
        $modifiedAt       = DateTimeField::new('modified_at');
        $seoImage         = TextField::new('seoImage');
        $ourWorksFolder   = TextField::new('ourWorksFolder');
        $cardImage        = TextField::new('cardImage');
        $cardDescription  = TextareaField::new('cardDescription');
        $geoProductType   = TextField::new('geoProductType');
        $ratingValue      = NumberField::new('ratingValue');
        $ratingCount      = IntegerField::new('ratingCount');
        $matrixId         = IntegerField::new('matrix_id');
        $imageSmallName   = TextField::new('imageSmallName');
        $imageBigName     = TextField::new('imageBigName');
        $imageCatalogName = TextField::new('imageCatalogName');
        $pages            = AssociationField::new('pages');
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
                $popular,
                $discount,
                $matrixId,
                $imageSmallName,
                $imageBigName,
                $imageCatalogName,
                $parent,
                $pages,
                $color,
                $type,
                $material,
                $category,
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [
                $name,
                $uri,
                $price,
                $discount,
                $parent,
                $type,
                $material,
                $color,
                $category,
                $popular,
                $published,
                $yml,
                $imageSmallFile,
                $imageBigFile,
                $imageCatalogFile,
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
                $price,
                $discount,
                $parent,
                $type,
                $material,
                $color,
                $category,
                $popular,
                $published,
                $yml,
                $imageSmallFile,
                $imageBigFile,
                $imageCatalogFile,
                $title,
                $description,
                $showSeoText,
                $content,
                $seoImageFile,
            ];
        }
    }
}
