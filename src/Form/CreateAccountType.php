<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class,[
                "attr"=>['class'=>'form-control border-primary bg-black color-white',"placeholder"=> "Username",'style'=>"border:2px solid; color:white"],
                "required" => true,
                "row_attr"=>["style"=>"color:white"]
                ])
            
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password', 'attr' => ['class' => 'password-field form-control border-primary bg-transparent text-white ','style'=>"border:2px solid; color:white","placeholder"=> "Password"]],
                'second_options' => ['label' => 'Confirm Password', 'attr' => ['class' => 'password-field form-control border-primary bg-transparent text-white','style'=>"border:2px solid; color:white","placeholder"=> "Password"]],
                
                
                
            
            
             ]) ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
