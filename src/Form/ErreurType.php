<?php

namespace App\Form;

use App\Entity\Region;
use App\Entity\Requete;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ErreurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>['class'=>"form-control", 'placeholder'=>"Nom de famille", 'autocomplete'=>"off"],
                'label' => "Nom de famille"
            ])
            ->add('prenoms', TextType::class,[
                'attr'=>['class'=>"form-control", 'placeholder'=>"Prenoms", 'autocomplete'=>"off"],
                'label' => "Prenoms"
            ])
            ->add('datenaissance', DateType::class,[
                'attr'=>['class'=>"form-control", 'placeholder'=>"Date de naissance", 'autocomplete'=>"off"],
                'label' => "Date de naissance",
                'widget' => 'single_text'
            ])
            ->add('lieunaissance', TextType::class,[
                'attr'=>['class'=>"form-control", 'placeholder'=>"Lieu de naissance", 'autocomplete'=>"off"],
                'label' => "Lieu de naissance"
            ])
            ->add('contact', TelType::class,[
                'attr'=>['class'=>"form-control", 'placeholder'=>"", 'autocomplete'=>"off"]
            ])
            ->add('message', TextareaType::class,[
                'attr'=>["class"=>"form-control", 'rows'=>5],
                'label' => "Message (decrivez votre soucis)"
            ])
            ->add('media', FileType::class,[
                'attr'=>['class'=>"custom-file-input", 'data-preview' => ".preview"],
                'label' => "Télécharger le réçu cinetpay",
                'mapped' => false,
                'multiple' => false,
                'constraints' => [
                    new File([
                        'maxSize' => "1000000k",
                        'mimeTypes' =>[
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/webp',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => "Votre fichier doit être de type image ou pdf"
                    ])
                ],
                'required' => false
            ])
            //->add('statut')
            //->add('createdAt')
            ->add('region', EntityType::class,[
                'attr'=>['class'=>'form-control js-select2'],
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
