<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Campus;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('currentPassword', PasswordType::class,
                ['constraints' => new SecurityAssert\UserPassword
                (['message' => 'Wrong value for your current password'
                    ]),
                'mapped' => false
            ])
            ->add('newPassword', PasswordType::class, ['mapped'=>false])
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
          ]);
    }
}
