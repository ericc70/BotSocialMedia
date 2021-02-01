<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class WelcomMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',  TextType::class, [
            'label' => false,
            'required' => true,
            'attr'=>[
                'placeholder' => 'Nom du message'
            ]
        ])

        ->add('message',  TextType::class, [
            'label' => false,
            'required' => true,
            'attr'=>[
                'placeholder' => 'Votre messsage'
            ]
        ])
     
        ->add('Envoyer', SubmitType::class)
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
