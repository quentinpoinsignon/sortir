<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use function Sodium\add;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['attr' => ['class' => 'w3-input w3-margin']])
            ->add('roles', ChoiceType::class, ['multiple'=>true, 'choices' => [
                'ROLE_USER' => 'ROLE_USER',
                'ROLE_ADMIN' => 'ROLE_ADMIN',
            ],'attr' => ['class' => 'w3-select w3-margin']])

            ->add('password', PasswordType::class, ['attr' => ['class' => 'w3-input w3-margin']])
            ->add('name', TextType::class, ['attr' => ['class' => 'w3-input w3-margin']])
            ->add('firstName', TextType::class, ['attr' => ['class' => 'w3-input w3-margin']])
            ->add('phoneNumber', TextType::class, ['attr' => ['class' => 'w3-input w3-margin']])
            ->add('emailAdress', EmailType::class, ['attr' => ['class' => 'w3-input w3-margin']])
            ->add('administrator', CheckboxType::class, ['attr' => ['class' => 'w3-check w3-margin']])
            ->add('active', CheckboxType::class, ['attr' => ['class' => 'w3-check w3-margin']])
            ->add('campus', EntityType::class, ['class' =>Campus::class, 'choice_label' => 'name',
                'attr' => ['class' => 'w3-select w3-margin']])
            ->add('save', SubmitType::class, ['attr' => ['class' => 'w3-btn w3-blue']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
