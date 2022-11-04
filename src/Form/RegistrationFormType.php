<?php

namespace App\Form;

use App\Entity\Profession;
use App\Entity\User;
use App\Repository\ProfessionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('professions',EntityType::class ,[
                'class' => Profession::class,
                'query_builder' => function(ProfessionRepository $r){
                    return $r->createQueryBuilder('i')->orderBy('i.metier','ASC');
                },
                'choice_label'=>'metier',
                'multiple' => true ,
                'expanded' => true,
                'attr' =>[
                    'class' =>'p-2',
                    'label' =>'P-2'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' =>'Prenom'
                ],
                'label' => false
            ])
            ->add('nom',TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' =>'Nom'
                ],
                'label' => false
            ])

            ->add('adresse',TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' =>'Adresse'
                ],
                'label' => false
                ])

            ->add('codePostal', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' =>'Code Postal'
                ],
                'label' => false
            ])

            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' =>'Ville'
                ],
                'label' => false
            ])

            ->add('telephone',TelType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' =>'Téléphone'
                ],
                'label' => false
            ])
            ->add('nrSiret', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' =>'Numéro siret'
                ],
                'label' => false
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' =>'Email'
                ],
                'label' => false
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                'class' =>'form-control mb-3'
            ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
