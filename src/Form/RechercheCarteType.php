<?php

namespace App\Form;

use App\Entity\Recherche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheCarteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('matricule')
            ->add('nom', TextType::class,['attr'=>['class'=>"form-control", 'placeholder'=>"Nom de famille", 'autocomplete'=>"off"]])
            ->add('prenoms', TextType::class,['attr'=>['class'=>"form-control", 'placeholder'=>"Prénoms", 'autocomplete'=>"off"]])
            ->add('dateNaissance', TextType::class,['attr'=>['class'=>"form-control datepicker", 'placeholder'=>"Date de naissance", 'autocomplete'=>"off"]])
            //->add('lieuNaissance', TextType::class,['attr'=>['class'=>"form-control", 'placeholder'=>"Lieu de naissance", 'autocomplete'=>"off"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recherche::class,
        ]);
    }
}
