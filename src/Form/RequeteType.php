<?php

namespace App\Form;

use App\Entity\Requete;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequeteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenoms')
            ->add('datenaissance')
            ->add('lieunaissance')
            ->add('contact')
            ->add('message')
            ->add('media')
            ->add('statut')
            ->add('createdAt')
            ->add('region')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Requete::class,
        ]);
    }
}
