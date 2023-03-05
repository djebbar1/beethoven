<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' =>'Votre prénom',
                'required' => true,
                'constraints' => new Length([
                    'min' => 3,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saissir votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' =>'Votre nom',
                'required' => true,
                'constraints' => new Length([
                    'min' => 3,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saissir votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' =>'Votre email',
                'required' => true,
                'constraints' => new Length([
                    'min' => 3,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saissir votre adresse email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la cobnfirmation doivent être identique.',
                'label' => 'Votre mot de passe',
                'constraints' => new Length([
                    'min' => 8,
                    'max' => 30
                ]),
                'required' => true,
                'first_options' => [ 'label' => 'Mot de passe', 
                'attr' => [
                    'placeholder' => 'Merci de saissir votre mot de passe'
                ] 
            ],
                'second_options' => [ 'label' => 'Confirmez votre mot de pssse', 
                'attr' => [
                    'placeholder' => 'Merci de confirmez votre mot de pssse'
                ] ]
            ])
           
            ->add('submit', SubmitType::class, [
                'label' => "S'inscire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
