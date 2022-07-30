<?php

namespace App\Form;

use App\Entity\Catalog;
use App\Entity\Material;
use App\Entity\Type;
use App\Model\Admin\ProductImport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matrix', CheckboxType::class, ['label' => 'Расчет цены по матрице?', 'required' => false])
            ->add('xlsFile', FileType::class, ['label' => 'Файл xlsx с товарами'])
            ->add('firstRow', NumberType::class, ['label' => 'Начать со строки'])
            ->add('catalog', EntityType::class, [
                'label'        => 'Каталог',
                'class'        => Catalog::class,
                'choice_label' => function (Catalog $catalog) {
                    return sprintf('%s (%s)', $catalog->getName(), $catalog->getPath());
                },
                'attr'         => [
                    'class' => 'chosen',
                ],
            ])
            ->add('baseUri', TextType::class, [
                'label'    => 'Базовый URI',
                'help'     => 'Если не указать, то за основу будет взят URI каталога',
                'required' => false,
            ])
            ->add('removeFromName', TextType::class, [
                'label'    => 'Удалить из названия',
                'help'     => 'Указанный фрагмент будет удален из названия товара при генерации URL',
                'required' => false,
            ])
            ->add('type', EntityType::class, [
                'label'        => 'Тип',
                'class'        => Type::class,
                'choice_label' => 'name',
                'placeholder'  => '-- Не указано --',
                'required'     => false,
            ])
            ->add('material', EntityType::class, [
                'label'        => 'Подтип',
                'class'        => Material::class,
                'choice_label' => 'name',
                'placeholder'  => '-- Не указано --',
                'required'     => false,
            ])
            ->add('imagesSmall', FileType::class, [
                'label'    => 'zip-файл c маленькими изображениями',
                'required' => false,
            ])
            ->add('imagesBig', FileType::class, [
                'label'    => 'zip-файл c большими изображениями',
                'required' => false,
            ])
            ->add('imagesCatalog', FileType::class, [
                'label'    => 'zip-файл c изображениями товаров в каталоге',
                'required' => false,
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductImport::class,
        ]);
    }
}
