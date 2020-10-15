<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Spot;
use App\Entity\Town;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EventAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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

            ->add('eventInfos', TextareaType::class,[
                'label' => 'Description et infos :',
                'attr' => ['class' => 'w3-input'],
            ])



            ->add('spot', SpotAddFormType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
