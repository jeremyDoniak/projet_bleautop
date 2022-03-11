<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('order_date', TextType::class, [
                'required' => true,
                'label' => 'Date de commande',
                'attr' => [
                    'maxLength' => 100,
                ]
            ])
            ->add('payment_date', TextType::class, [
                'required' => false,
                'label' => 'Date de paiement',
                'attr' => [
                    'maxLength' => 100,
                ]
            ])
            ->add('amount', TextType::class, [
                'required' => true,
                'label' => 'Montant total',
                'attr' => [
                    'maxLength' => 100,
                ]
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name'
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
