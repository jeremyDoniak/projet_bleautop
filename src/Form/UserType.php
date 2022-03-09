<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'attr' => [
                    'maxLength' => 100,
                    'placeholder' => 'Ex.: nom de l\'utilisateur'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'maxLength' => 100,
                    'placeholder' => 'Ex.: johndoe@gmail.com'
                ]
            ])
            ->add('phone', IntegerType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'attr' => [
                    'min' => 0,
                    'max' => 99999,
                    'placeholder' => 'Ex.: 0123456789'
                ]
            ])
            ->add('company', TextType::class, [
                'required' => false,
                'label' => 'Entreprise',
                'attr' => [
                    'maxLength' => 100,
                    'placeholder' => 'Ex.: nom de l\'entreprise'
                ]
            ])
            // ->add('roles', TextType::class, [
            //     'required' => false,
            //     'label' => 'Roles',
            //     'attr' => [
            //         'maxLength' => 20,
            //         'placeholder' => 'Ex.: role de l\'utilisateur'
            //     ]
            // ])
            ->add('addresses', EntityType::class, [
                'class' => Address::class,
                'choice_label' => 'name',
                'label' => 'Adresses',
                'multiple' => true
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
