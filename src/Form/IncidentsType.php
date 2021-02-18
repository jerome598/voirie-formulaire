<?php

namespace App\Form;

use App\Entity\Tincidents;
use App\Entity\Tplaces;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class IncidentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'label'=>'Titre de votre demande : ',
                "attr"=>[
                    "class"=>"form-control"
                    ]
            ])
            ->add('description',TextareaType::class, [
                'label'=>'Détail de votre demande : ',
                "attr"=>[
                    "class"=>"form-control"
                ]
            ])
            ->add('nom',TextType::class, [
                'label'=>'Nom : ',
                "attr"=>[
                    "class"=>"form-control"
                ]
            ])
            ->add('tel',TextType::class, [
            'label'=>'Votre n° de téléphone : ',
                "attr"=>[
                    "class"=>"form-control"
                ]
             ])
            ->add('email', EmailType::class, [
                'label'=>'Votre Email : ',
                "attr"=>[
                    "class"=>"form-control"
                ],
                "required"=>false,
                ])
             ->add('places',EntityType::class, [
                 'label'=>'Lieu de L\'intervention : ',
                 'class'=>Tplaces::class,
                 'choice_label'=>'name',
                 "attr"=>[
                     "class"=>"form-control"
                 ]
             ])
            ->add('image', FileType::class, [
                'label'=>'Parcourir',
                'required'=>'false',
            ])
           ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label'=>' Cochez cette case ',
                "attr"=>[
                    "class"=>"form-control"
                ],
            ])
        ;
            /* ->add('technician',TextType::class)
            ->add('t_group',TextType::class)
            ->add('type',TextType::class)
           ->add('use',TextType::class)
            ->add('date_create',DateTimeType::class)
            ->add('date_modif',DateTimeType::class)
            ->add('date_import',DateTimeType::DEFAULT_DATE_FORMAT)
           ->add('state',TextType::class)
           ->add('priority',TextType::class)
            ->add('criticality',TextType::class)
            ->add('category',TextType::class)
            ->add('techread',TextType::class)
            ->add('disable',TextType::class)*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tincidents::class,
        ]);
    }
}
