<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;



use App\Entity\Airport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchFlightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure_airport', EntityType::class, [
                'class' => Airport::class,
                'choice_label' => 'name',
                'placeholder' => 'Aéroport de départ',
                'label' => 'Départ de  ',
                'required' => false
            ])
            ->add('arrival_airport', EntityType::class, [
                'class' => Airport::class,
                'choice_label' => 'name',
                'placeholder' => "Aéroport d'arrivée",
                'label' => 'Destination ',
                'required' => false
            ])

            ->add('departure_datetime', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['min' => (new \DateTime())->format('Y-m-d')],
                'label' => 'Date de départ ',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'method' => 'GET',
                'crsf_protection' => false
            ]
        );
    }
}
