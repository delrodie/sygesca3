<?php

namespace App\Form;

use App\Entity\Region;
use App\Entity\Requete;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequeteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label'=>' Nom du scout',
                'required'=> false
            ])
            ->add('prenoms', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label'=> 'prenoms du scout',
                'required'=> false
            ])
            ->add('datenaissance', DateType::class,[
                'attr'=>['class'=>"form-control"],
                'label' => "Date de naisance",
                'widget' => 'single_text'
            ])
            ->add('lieunaissance', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label'=> 'Lieu de naissance',
                'required'=> false
            ])
            ->add('contact', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label'=> 'Contact',
                'required'=> false
            ])
            ->add('message', TextareaType::class,[
                'attr'=>['class'=>'form-control', 'rows'=>5]
            ])
            //->add('media')
            ->add('statut', ChoiceType::class,[
                'attr'=>['class'=>"form-control"],
                'choices'=>[
                    'PAS ENCORE RESOLU' => "PAS ENCORE RESOLU",
                    'EN ATTENTE' => "EN ATTENTE",
                    'RESOLU' => "RESOLU"
                ]
            ])
            //->add('createdAt')
            ->add('region', EntityType::class,[
                'attr'=>['class'=>'form-control select'],
                'class'=>Region::class,
                'query_builder'=>function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label'=>'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Requete::class,
        ]);
    }
}
