<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints\File;

class UserEditFormType extends AbstractType
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
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'label' => 'Campus',
                'choice_label' => 'name',
                'attr' => ['class' => 'w3-select'],
            ])
            ->add('pictureFilename', FileType::class, [
                'label' => 'Choisissez une photo pour votre profil',
                'mapped' => false,
                'attr' => ['class' => 'w3-input'],
                'required' => false,
                'attr' => ['class' => 'w3-input'],
                'constraints' => [
                    new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/svg+xml',
                    ],
                    'mimeTypesMessage' => 'Fichiers acceptés : .jpg et .png'
                    ])
                ],
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
