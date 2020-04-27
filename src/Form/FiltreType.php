<?php


namespace App\Form;


use App\Data\Filtre;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType Extends AbstractType
{
    //construction du formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date' , DateType::class,[
            'libel'=>false,
                'required' => false,
                'attr'=>[
                    'placeholder'=> 'Rechercher'
                ]
            ]);

    }


    //configuration des différentes options lié au formulaire
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> Filtre::class,
            'method' => 'GET',
            'csrf_protection'=>false

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}