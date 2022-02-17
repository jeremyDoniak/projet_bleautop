<?php

namespace App\Form;

use App\Entity\Size;
use App\Entity\Angle;
use App\Entity\Color;
use App\Entity\Types;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Drilling;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'required' => true,
            'label' => 'Nom',
            'attr' => [
                'maxLength' => 100,
                'placeholder' => 'Ex.: nom de produit'
            ]
        ])
        ->add('description', TextareaType::class, [
            'required' => true,
            'label' => 'Description',
            'attr' => [
                'maxLength' => 65535,
                'placeholder' => 'Ex.: option, qualité ...'
            ]
        ])
        ->add('price', IntegerType::class, [
            'required' => true,
            'label' => 'Prix (€)',
            'attr' => [
                'min' => 0,
                'max' => 9999999,
                'placeholder' => 'Ex.: 123 456'
            ]
        ])
        ->add('height', IntegerType::class, [
            'required' => false,
            'label' => 'Hauteur (cm)',
            'attr' => [
                'min' => 0,
                'max' => 9999999,
                'placeholder' => 'Ex.: 123 456'
            ]
        ])
        ->add('width', IntegerType::class, [
            'required' => false,
            'label' => 'Largeur (cm)',
            'attr' => [
                'min' => 0,
                'max' => 9999999,
                'placeholder' => 'Ex.: 123 456'
            ]
        ])
        ->add('length', IntegerType::class, [
            'required' => false,
            'label' => 'Longueur (cm)',
            'attr' => [
                'min' => 0,
                'max' => 9999999,
                'placeholder' => 'Ex.: 123 456'
            ]
        ])
        ->add('img', FileType::class, [
            'required' => true,
            'label' => 'Photo',
            'mapped' => false,
            'help' => 'png, jpg, jpeg, jp2 ou webp - 1 Mo maximum',
            'constraints' => [
                new Image([
                    'maxSize' => '1M',
                    'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} Mo). Maximum autorisé : {{ limit }} Mo.',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpg',
                        'image/jpeg',
                        'image/jp2',
                        'image/webp',
                    ],
                    'mimeTypesMessage' => 'Merci de sélectionner une image au format PNG, JPG, JPEG, JP2 ou WEBP'
                ])
            ]
        ])
        ->add('category', EntityType::class, [
            'required' => true,
            'class' => Category::class,
            'choice_label' => 'title'
        ])
        ->add('types', EntityType::class, [
            'required' => false,
            'class' => Types::class,
            'choice_label' => 'name'
        ])
        ->add('size', EntityType::class, [
            'required' => false,
            'class' => Size::class,
            'choice_label' => 'name'
        ])
        ->add('color', EntityType::class, [
            'required' => false,
            'class' => Color::class,
            'choice_label' => 'name'
        ])
        ->add('angle', EntityType::class, [
            'required' => false,
            'class' => Angle::class,
            'choice_label' => 'name'
        ])
        ->add('drilling', EntityType::class, [
            'required' => false,
            'class' => Drilling::class,
            'choice_label' => 'name'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
