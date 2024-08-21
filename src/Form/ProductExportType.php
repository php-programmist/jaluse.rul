<?php

namespace App\Form;

use App\Entity\Catalog;
use App\Entity\Page;
use App\Entity\Product;
use App\Model\Admin\ProductExport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductExportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('catalog', EntityType::class, [
                'label'        => 'Каталог',
                'class'        => Catalog::class,
                'choice_label' => function (Catalog $catalog) {
                    return sprintf('%s (%s) - %d',
                        $catalog->getName(),
                        $catalog->getPath(),
                        $catalog
                            ->getPages()
                            ->filter(fn(Page $page) => $page instanceof Product)
                            ->count()
                    );
                },
                'attr'         => [
                    'class' => 'chosen',
                ],
                'required'     => false,
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductExport::class,
        ]);
    }
}
