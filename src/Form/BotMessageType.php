<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BotMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
   
        ->add('choice_reseau', ChoiceType::class,[
            'choices' =>[
                'Mamot'=> 1,
                'Twitter' => 2
            ],
            'required' => true,
            'multiple' => true,
            'expanded' => true,
            'label' =>false
        ])
             ->add('message',  TextareaType::class, [
            'label' => false,
            'required' => true,
            'attr'=>[
                'placeholder' => 'Votre messsage',
                'maxlength' => 240
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
