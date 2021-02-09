<?php

namespace App\Form;

use App\Entity\UserInfo2020;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInfo2020Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label' => "Nom du scout"
            ])
            ->add('prenoms', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label' => "Prénoms du scout"
            ])
            //->add('dateNaissance')
            //->add('lieuNaissance')
            //->add('sexe')
            //->add('contact')
            //->add('urgence')
            //->add('contactParent')
            //->add('branche')
            ->add('idTransaction', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label' => "Identifiant de la transaction"
            ])
            //->add('statusPaiement')
            ->add('contact', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label' => "Numero de paiment "
            ])
            //->add('statut')
            //->add('matricule')
            //->add('region')
            //->add('district')
            //->add('groupe')
            //->add('fonction')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserInfo2020::class,
        ]);
    }
}
