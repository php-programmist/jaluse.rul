<?php

declare(strict_types = 1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaqItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextType::class, [
                'label'    => 'Вопрос',
                'required' => true,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'Введите вопрос',
                ],
                'row_attr' => [
                    'class' => 'form-group col-12',
                ],
            ])
            ->add('answer', TextareaType::class, [
                'label'    => 'Ответ',
                'required' => true,
                'attr'     => [
                    'class'       => 'form-control',
                    'rows'        => 3,
                    'placeholder' => 'Введите ответ',
                ],
                'row_attr' => [
                    'class' => 'form-group col-12',
                ],
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr'       => [
                'class' => 'row',
            ],
        ]);
    }
}
