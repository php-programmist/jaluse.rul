<?php

namespace App\Form;

use App\Entity\Catalog;
use App\Model\Admin\LocationImport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('xlsFile', FileType::class, ['label' => 'Файл xlsx с товарами'])
            ->add('firstRow', NumberType::class, ['label' => 'Начать со строки'])
            ->add('parent', EntityType::class, [
                'label'        => 'Родитель',
                'class'        => Catalog::class,
                'choice_label' => function (Catalog $catalog) {
                    return sprintf('%s (%s)', $catalog->getName(), $catalog->getPath());
                },
                'attr'         => [
                    'class' => 'chosen',
                ],
            ])
            ->add('catalog', EntityType::class, [
                'label'        => 'Базовый каталог',
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
                'help'     => 'Если не указать, то за основу будет взят URI родителя',
                'required' => false,
            ])
            ->add('removeFromName', TextType::class, [
                'label'    => 'Удалить из названия',
                'help'     => 'Указанный фрагмент будет удален из названия товара при генерации URL. Если не указать, то будет удалено название базового каталога',
                'required' => false,
            ])
            ->add('materials', TextType::class, [
                'label'    => 'Материалы',
                'help'     => 'Используется в тексте карточки',
                'required' => true,
            ])
            ->add('type', TextType::class, [
                'label'    => 'Тип',
                'help'     => 'Используется в тексте карточки',
                'required' => true,
            ])
            ->add('subTypes', TextType::class, [
                'label'    => 'Виды',
                'help'     => 'Используется в тексте карточки',
                'required' => true,
            ])
            ->add('geoProductType', TextType::class, [
                'label'    => 'Тип Гео-продукта',
                'help'     => 'zhalyuzi или rulonnyie-shtoryi',
                'required' => true,
            ])
            ->add('images', FileType::class, [
                'label'    => 'zip-файл c изображениями',
                'required' => false,
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LocationImport::class,
        ]);
    }
}
