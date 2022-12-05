<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TypeTextType::class,[
                'label'=>"Titre de l'article",
                "row_attr" =>['class'=>"text-white col-md-4 fs-3 offset-4"],
                "attr" =>['class'=>"form-control"]
            ])
            ->add('image',UrlType::class,[
                'label'=>"Image de l'article",
                "row_attr" =>['class'=>"text-white col-md-4 fs-3 offset-4"],
                "attr" =>['class'=>"form-control"]
            ])
            ->add('price',NumberType::class,[
                'label'=>"Prix",
                "row_attr" =>['class'=>"text-white col-md-4 fs-3 offset-4"],
                "attr" =>['class'=>"form-control"]   
            ])
            ->add('ReleaseDate', DateType::class,[
                "row_attr" =>['class'=>"text-white col-md-4 fs-3 offset-4"],
                "attr" =>['class'=>"form-control"]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
