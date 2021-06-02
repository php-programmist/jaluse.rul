<?php

namespace App\Form;

use App\Entity\Catalog;
use App\Entity\Material;
use App\Entity\Type;
use App\Model\Admin\ProductImport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('xlsFile', FileType::class, ['label' => 'Файл xlsx с товарами'])
            ->add('firstRow', NumberType::class, ['label' => 'Начать со строки'])
            ->add('catalog', EntityType::class, [
                'label'        => 'Каталог',
                'class'        => Catalog::class,
                'choice_label' => 'name',
                'attr'         => [
                    'class' => 'chosen',
                ],
            ])
            ->add('type', EntityType::class, [
                'label'        => 'Тип',
                'class'        => Type::class,
                'choice_label' => 'name',
            ])
            ->add('material', EntityType::class, [
                'label'        => 'Подтип',
                'class'        => Material::class,
                'choice_label' => 'name',
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
