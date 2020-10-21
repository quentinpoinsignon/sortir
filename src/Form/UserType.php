<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Campus;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add(
                'currentPassword',
                PasswordType::class,
                ['constraints' => new SecurityAssert\UserPassword(['message' => 'Wrong value for your current password'
                    ]),
                'mapped' => false,
                    'label' => 'Mot de passe',
                    'attr' => ['class' => 'w3-input'],
            ]
            )
            ->add('newPassword', PasswordType::class, [
                'mapped'=>false,
                'label' => 'Nouveau mot de passe',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Téléphone :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('emailAdress', EmailType::class, [
                'label' => 'Email :',
                'attr' => ['class' => 'w3-input'],
            ])
            ->add('administrator', CheckboxType::class, [
                'label' => 'Administrateur',
                'attr' => ['class' => 'w3-check'],
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Acti.f(ve)',
                'attr' => ['class' => 'w3-check'],
            ])
            ->add('campus', EntityType::class, [ 'class' => Campus::class,
                'label' => 'Campus',
                'choice_label' => 'name',
                'attr' => ['class' => 'w3-select'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
          ]);
    }
}
