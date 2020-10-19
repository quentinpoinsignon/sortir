<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Spot;
use App\Entity\Town;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EventAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isCreate = 'create' == $options['use_type'];
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la sortie :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('startDateTime', DateTimeType::class, [
                'label' => 'Date et heure de la sortie :',
                'attr' => ['type' => 'date'],
                'date_widget' => 'single_text'
            ])
            ->add('registrationLimitDate', DateTimeType::class, [
                'label' => 'Date limite d\'inscription :',
                'attr' => ['type' => 'date'],
                'date_widget' => 'single_text'
            ])
            ->add('registrationMaxNb', IntegerType::class, [
                'label' => 'Nombre de places :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('eventInfos', TextareaType::class, [
                'label' => 'Description et infos :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('spot', HiddenType::class, [])

            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'w3-btn w3-teal w3-round'],
            ])

            ->add('publish', SubmitType::class, [
                'label' => 'Publier',
                'attr' => ['class' => 'w3-btn w3-yellow w3-round'],
            ])

            ->add('cancel', ButtonType::class, [
                'label' => 'Annuler',
                'attr' => ['class' => 'w3-btn w3-black w3-round'],
            ])
            ;

        if ($isCreate) {
            $builder->add('delete', SubmitType::class, [
                'label' => 'Supprimer',
                'attr' => ['class' => 'w3-btn w3-red w3-round'],
            ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'use_type' => 'create',
        ]);
    }
}
