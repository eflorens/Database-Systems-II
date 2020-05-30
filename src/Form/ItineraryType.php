<?php

namespace App\Form;

use App\Entity\Itinerary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItineraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cost', IntegerType::class)
            ->add('travel', TravelType::class)
            ->add('location', LocationType::class);

        $builder->add('transportation', ChoiceType::class, [
            "choices" => [
                'Car' => 'Car',
                'Plane' => 'Plane',
                'Train' => 'Train',
                'Boat' => 'Boat'
            ],
            "mapped" => true
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Itinerary::class,
        ]);
    }
}
