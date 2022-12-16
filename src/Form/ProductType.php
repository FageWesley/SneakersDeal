<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TypeTextType::class, [
                'label' => "Nom du produit",
                "row_attr" => ['class' => "text-white col-md-4 fs-3 offset-4"],
                "attr" => ['class' => "form-control"],
                "required" => true,
            ])
            ->add('image', FileType::class, [
                'label' => "Image du produit",
                "row_attr" => ['class' => "text-white col-md-4 fs-3 offset-4"],
                "attr" => ['class' => "form-control"],
                "mapped" => false,
                "required" => true,
                "constraints" => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes'=>[
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage'=>'Please upload a JPG,JPEG,PNG',
                    ])
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => "Prix",
                "row_attr" => ['class' => "text-white col-md-4 fs-3 offset-4"],
                "attr" => ['class' => "form-control"],
                "required" => true,
            ])
            ->add('ReleaseDate', DateType::class, [
                "row_attr" => ['class' => "text-white col-md-4 fs-3 offset-4"],
                "attr" => ['class' => "form-control"],
                "required" => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
