<?php

namespace App\Form;

use App\Entity\SearchFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('metier', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'metier',
                    // 'class'=>'form-control my-3'
                ]
            ])
            ->add('codePostal', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'code postal',
                    // 'class'=>'form-control '
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchFilter::class,
            'method' => 'get',
            'csrf_protection' => false
            // Configure your form options here
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
