<?php

namespace App\Form;

use App\Entity\Matiere;
use App\Entity\Category;
use App\Entity\Produit; // App = src
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if($options['ajouter'] == true)
        {
            $builder
                ->add('nom', TextType::class, [
                    'required' => false,
                    'label' => false,

                    'attr' => [
                        'placeholder' => "Saisir le nom",
                        'class' => "bg-warning"
                    ],

                    // 'constraints' => [
                    //     new NotBlank([
                    //         'message' => "Veuillez renseigner le nom"
                    //     ]),
                    //     new Length([
                    //         'min' => 2,
                    //         'minMessage' => "2 caractères minimum",
                    //         'max' =>  10,
                    //         'maxMessage' => "10 caractères maximum"
                    //     ])
                    // ]

                ])


                ->add('prix', NumberType::class, [
                    'required' => false,
                    'label' => false,
                    

                    'attr' => [
                        'placeholder' => "Saisir le prix",
                        'invalid_message'=> "doit être un nombre"

                    ],

                    // 'constraints' => [
                    //     new NotBlank([
                    //         'message' => "Veuillez renseigner le prix"
                    //     ]),
                    //     new Positive([
                    //         'message' => "Veuillez renseigner un prix supérieur à zéro"
                    //     ])
                    // ]
                    

                ])

                ->add('image', FileType::class, [
                    "required" => false,
                    'constraints' => [
                        new File([
                                'mimeTypes' => [
                                    "image/png",
                                    "image/jpg",
                                    "image/jpeg",

                                ],
                                'mimeTypesMessage' => "Extensions Autorisées : PNG JPG JPEG"
                            ])
                    ]
                ])
                // ->add('Ajouter', SubmitType::class)


                ->add('category', EntityType::class, [  // cet input est une Entity
                    "class" => Category::class,         // quelle Entity ?
                    "choice_label" => "nom",             // quelle propriété ?

                ])

                ->add('matieres', EntityType::class, [
                    "class" => Matiere::class,
                    "choice_label" => "nom",
                    'multiple' => true,
                    //"expanded" => true // checkbox
                    'attr' => [
                        'class' => "select2",
                        'data-placeholder' => "Sélectionnez une ou des sous-catégories"
                    ]
                    
                ])
            ;

        }// fermeture if($options['ajouter'] == true)


        elseif($options['modifier'] == true)
        {
            $builder
                ->add('nom', TextType::class, [
                    'required' => false,
                    'label' => false,

                    'attr' => [
                        'placeholder' => "Saisir le nom",
                        'class' => "bg-light"
                    ],

                    // 'constraints' => [
                    //     new NotBlank([
                    //         'message' => "Veuillez renseigner le nom"
                    //     ]),
                    //     new Length([
                    //         'min' => 2,
                    //         'minMessage' => "2 caractères minimum",
                    //         'max' =>  10,
                    //         'maxMessage' => "10 caractères maximum"
                    //     ])
                    // ]

                ])


                ->add('prix', NumberType::class, [
                    'required' => false,
                    'label' => false,
                    

                    'attr' => [
                        'placeholder' => "Saisir le prix",
                        'invalid_message'=> "doit être un nombre"

                    ],

                    // 'constraints' => [
                    //     new NotBlank([
                    //         'message' => "Veuillez renseigner le prix"
                    //     ]),
                    //     new Positive([
                    //         'message' => "Veuillez renseigner un prix supérieur à zéro"
                    //     ])
                    // ]
                    

                ])

                ->add('imageFile', FileType::class, [
                    "required" => false,
                    'mapped' => false,
                    'constraints' => [
                        new File([
                                'mimeTypes' => [
                                    "image/png",
                                    "image/jpg",
                                    "image/jpeg",

                                ],
                                'mimeTypesMessage' => "Extensions Autorisées : PNG JPG JPEG"
                            ])
                    ]

                ])
                // ->add('Ajouter', SubmitType::class)

                ->add('category', EntityType::class, [  // cet input est une Entity
                    "class" => Category::class,         // quelle Entity ?
                    "choice_label" => "nom"             // quelle propriété ?
                ])

                ->add('matieres', EntityType::class, [
                    "class" => Matiere::class,
                    "choice_label" => "nom",
                    'multiple' => true,
                    //"expanded" => true // checkbox
                    'attr' => [
                        'class' => "select2",
                        'data-placeholder' => "Sélectionnez une ou des matières" 
                    ]
                ])

            ;

        }// fermeture if($options['modifier'] == true)




    }// fermeture function buildForm

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'ajouter' => false,
            'modifier' => false
        ]);
    }
}
