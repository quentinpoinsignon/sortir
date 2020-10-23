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
            ->add('username', TextType::class, [
                'label' => 'Pseudo :',
                'attr' => ['class' => 'w3-input w3-margin']])
            ->add('roles', ChoiceType::class, [
                'multiple'=>true, 'choices' => [
                'ROLE_USER' => 'ROLE_USER',
                'ROLE_ADMIN' => 'ROLE_ADMIN',
            ],'attr' => ['class' => 'w3-select w3-margin']])

            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe :',
                'attr' => ['class' => 'w3-input w3-margin']])
            ->add('name', TextType::class, [
                'label' => 'Nom :',
                'attr' => ['class' => 'w3-input w3-margin']])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
                'attr' => ['class' => 'w3-input w3-margin']])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Téléphone :',
                'attr' => ['class' => 'w3-input w3-margin']])
            ->add('emailAdress', EmailType::class, [
                'label' => 'Email :',
                'attr' => ['class' => 'w3-input w3-margin']])
            ->add('campus', EntityType::class, ['class' =>Campus::class,
                'label' => 'Campus :',
                'choice_label' => 'name',
                'attr' => ['class' => 'w3-select w3-margin']])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer :',
                'attr' => ['class' => 'w3-btn w3-indigo']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
