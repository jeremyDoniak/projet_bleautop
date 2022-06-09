<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Address;
use App\Form\UserAddressType;
use App\Repository\AddressRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OrderAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('order_date', DateTimeType::class, [
            //     'required' => true,
            //     'label' => 'Date de commande',
            //     'attr' => [
            //         'maxLength' => 100,
            //     ]
            // ])
            // ->add('payment_date', DateTimeType::class, [
            //     'required' => false,
            //     'label' => 'Date de paiement',
            //     'attr' => [
            //         'maxLength' => 100,
            //     ]
            // ])
            // ->add('amount', IntegerType::class, [
            //     'required' => true,
            //     'label' => 'Montant total',
            //     'attr' => [
            //         'maxLength' => 100,
            //     ]
            // ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'name'
            // ])
            ->add('address', EntityType::class, [
                'required' => true,
                'class' => Address::class,
                'query_builder' => function(AddressRepository $address) {
                    return $address->getAdresseClient($this->getUser());
                },
                
                'choice_label' => function ($address) {
                    return $address->getName() . ' ' . $address->getStreet() . ' ' . $address->getComplement() . ' ' . $address->getZip() . ' ' . $address->getCity();
                },
                
            ])

           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
