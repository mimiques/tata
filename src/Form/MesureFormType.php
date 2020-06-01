<?php

namespace App\Form;

use App\Entity\Mesure;

use App\Entity\Salle;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class MesureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('temperature')
            ->add('hygrometrie')
            ->add('salle',EntityType::class,[
                'class'=>Salle::class,
                'choice_label'=>'nom'
            ])

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mesure::class,

        ]);
    }
}
