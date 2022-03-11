<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom de l\'adresse',
                'attr' => [
                    'maxLength' => 25,
                    'placeholder' => 'Ex.: domicile'
                ]
            ])
            ->add('street', TextType::class, [
                'required' => true,
                'label' => 'Adresse',
                'attr' => [
                    'maxLength' => 255,
                    'placeholder' => 'Ex.: 3 place de la gare'
                ]
            ])
            ->add('complement', TextType::class, [
                'required' => false,
                'label' => 'Complément d\'adresse',
                'attr' => [
                    'maxLength' => 255,
                    'placeholder' => 'Ex.: bat. 2 étage 3'
                ]
            ])
            ->add('zip', IntegerType::class, [
                'required' => true,
                'label' => 'Code postal',
                'attr' => [
                    'min' => 0,
                    'max' => 99999,
                    'placeholder' => 'Ex.: 75 000'
                ]
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'label' => 'Ville',
                'attr' => [
                    'maxLength' => 255,
                    'placeholder' => 'Ex.: Paris'
                ]
            ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'name'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
