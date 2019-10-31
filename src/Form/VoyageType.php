<?php

namespace App\Form;

use App\Entity\Destination;
use App\Entity\Voyage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['label' => 'Nom du voyage'])
            ->add('destination', EntityType::class, [
                'class' => Destination::class,
                'choice_label' => 'ville',
                'label' => 'Destination'
            ])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('note')
            ->add('dateDepart', DateTimeType::class, [
                'label' => 'Date de départ',
                'html5' => false
            ])
            // ->add('created')
            ->add('photos', FileType::class, [
                 // unmapped means that this field is not associated to any entity property
                 // Ne pas assiocier le champs de formulaire à l'attribut de l'objet
                'mapped' => false,
                // make it optional so you don't have to re-upload the photos
                // everytime you edit the Product details
                'required' => false,
                'multiple' => true,
                'label' => 'Photos du voyage',
            ])

            ->add('Enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
        ]);
    }
}
