<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'attr' => [
                    "class" => "form-control",
                    "placeholder" =>'titre'
                ],
                "label"=>false
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    "class" => "form-control",
                    "placeholder" =>'description'
                ],
                "label"=>false
            ])
            ->add('codePostal', TextType::class,[
                'attr' => [
                    "class" => "form-control",
                    "placeholder" =>'code postal du chantier'
                ],
                "label"=>false
            ])
            ->add('ville',  TextType::class,[
                'attr' => [
                    "class" => "form-control",
                    "placeholder" =>'ville du projet'
                ],
                "label"=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
