<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'maxLength' => 100,
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'maxLength' => 100,
                    'placeholder' => 'Ex.: johndoe@gmail.com'
                ]
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'maxLength' => 1000,
                    'placeholder' => 'Votre message'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Vous affirmez avoir pris connaissance de notre Politique de confidentialité.',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions générales d\'utilisation.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
