<?php

namespace App\Form;

use App\Entity\District;
use App\Entity\Region;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DistrictType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,['attr'=>['class'=>'form-control', 'placeholder'=>"Le nom du district", 'autocomplete'=>"off"]])
            ->add('doyenne', TextType::class,['attr'=>['class'=>'form-control', 'placeholder'=>"Le doyenne", 'autocomplete'=>"off"], 'required'=>false])
            //->add('slug')
            //->add('publiePar')
            //->add('modifiePar')
            //->add('publieLe')
            //->add('modifieLe')
            ->add('region', EntityType::class,[
                'attr'=>['class'=>'form-control select js-select2'],
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
            'data_class' => District::class,
        ]);
    }
}
