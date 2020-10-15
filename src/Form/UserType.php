<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Campus;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('name')
            ->add('firstName')
            ->add('phoneNumber')
            ->add('emailAdress')
            ->add('administrator')
            ->add('active')
            ->add('campus', EntityType::class, [ 'class' => Campus::class,
                'label' => 'Campus',
                'choice_label' => 'name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'username'=>'data', 'name'=>'data', 'firstName'=>'data',
            'phoneNumber'=>'data','emailAdress'=>'data', 'campus'=>'data'
        ]);
    }
}
