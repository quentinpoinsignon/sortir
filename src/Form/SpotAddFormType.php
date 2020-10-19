<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Spot;
use App\Entity\Town;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpotAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('town', EntityType::class, [
                'class' => Town::class,
                'label' => 'Ville :',
                'choice_label' => 'name',
                'attr' => ['class' => 'w3-select'],
                'query_builder' => function (EntityRepository $entityRepository){
                    return $entityRepository ->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
            ])

            ->add('name', TextType::class, [
                'label' => 'Lieu :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('street', TextType::class, [
                'label' => 'Rue :',
                'attr' => ['class' => 'w3-input'],
            ])


            ->add('latitude', NumberType::class, [
                'label' => 'Latitude :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('longitude', NumberType::class, [
                'label' =>'Longitude :',
                'attr' => ['class' => 'w3-input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
        ]);
    }
}
