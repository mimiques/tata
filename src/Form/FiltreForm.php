<?php


namespace App\Form;


use App\Data\Filtres;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreForm Extends AbstractType
{
    //construction du formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date' , DateType::class,[
                //salle//
                'attr'=>[
                    'placeholder'=> 'Rechercher'
                ]
            ]);

    }


    //configuration des différentes options lié au formulaire
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> Filtres::class,
            'method' => 'GET',
            'csrf_protection'=>false

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}