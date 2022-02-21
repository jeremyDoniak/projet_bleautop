<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('billingAddress', TextType::class, [
                'required' => true,
                'label' => 'Adresse de facturation',
                'attr' => [
                    'maxLength' => 255,
                    'placeholder' => 'Ex.: 12 rue de la gare'
                ]
            ])
            ->add('deliveryAddress', TextType::class, [
                'required' => true,
                'label' => 'Adresse de livraison',
                'attr' => [
                    'maxLength' => 255,
                    'placeholder' => 'Ex.: 3 place de la gare'
                ]
            ])
            ->add('zipCode', IntegerType::class, [
                'required' => true,
                'label' => 'Code postal',
                'attr' => [
                    'min' => 0,
                    'max' => 99999,
                    'placeholder' => 'Ex.: 75 456'
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
