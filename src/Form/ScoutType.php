<?php

namespace App\Form;

use App\Entity\Fonctions;
use App\Entity\Groupe;
use App\Entity\Region;
use App\Entity\Scout;
use App\Entity\Statut;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off", 'readonly'=>true],
                'label' => "Matricule",
                'required' => false
            ])
            ->add('nom', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label' => "Nom de famille"
            ])
            ->add('prenoms', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label' => "Prenoms"
            ])
            ->add('datenaiss', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label' => "Date de naissance",
                'required' => false
                //'widget' => "single_text"
            ])
            ->add('lieunaiss', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label'=>"Lieu de naissance",
                'required' => false
            ])
            ->add('sexe', ChoiceType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'choices' => [
                    'HOMME' => "HOMME",
                    'FEMME' => 'FEMME'
                ],
                'label' => "Sexe",
                'required' => false
            ])
            ->add('branche', ChoiceType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'choices'=> [
                    '' => '',
                    'LOUVETEAU' => 'LOUVETEAU',
                    'ECLAIREUR' => 'ECLAIREUR',
                    'CHEMINOT' => 'CHEMINOT',
                    'ROUTIER' => 'ROUTIER'
                ],
                'label' => "Branche",
                'required' => false
            ])
            ->add('fonction', TextType::class,[
                'attr'=>['class'=>'form-control'],
                'label' => "Fonction",
                'required' => false
            ])
            ->add('contact', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'label' => "Contact",
                'required' => false
            ])
            ->add('contactparent', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'required' => false,
                'label' => "Contact parent"
            ])
            ->add('email', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off"],
                'required' => false,
                'label' => "Adresse email"
            ])
            ->add('carte', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off", 'readonly'=>true],
                'label' => "Numero de la carte",
                'required' => false
            ])
            ->add('cotisation', TextType::class,[
                'attr'=>['class'=>"form-control", 'autocomplete'=>"off", 'readonly'=>true],
                'required' => false,
                'label' => "Annee"
            ])
            //->add('slug')
            //->add('publiePar')
            //->add('modifiePar')
            //->add('publieLe')
            //->add('modifieLe')
            ->add('urgence', ChoiceType::class,[
                'attr'=>['class'=>"form-control"],
                'choices' => [
                    'PERE' => 'PERE',
                    'MERE' => 'MERE',
                    'AUTRE' => 'AUTRE'
                ],
                'label' => "En cas d'urgence",
                'required' => false
            ])
            ->add('groupe', EntityType::class,[
                'attr'=>['class'=>'form-control select'],
                'class'=>Groupe::class,
                'query_builder'=>function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label'=>'paroisse'
            ])
            ->add('statut', EntityType::class,[
                'attr'=>['class'=>'form-control select2'],
                'class'=>Statut::class,
                'query_builder'=>function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label'=>'libelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Scout::class,
        ]);
    }
}
