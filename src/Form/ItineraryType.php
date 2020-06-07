<?php

namespace App\Form;

use App\Entity\Itinerary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItineraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $rating = 1;
        if (array_key_exists('rating', $options)) {
            $rating = $options['rating'];
        }

        $builder->add('travel', TravelType::class);

        $builder->add('rating', ChoiceType::class, [
            'choices' => [
                'Terrible' => 1,
                'Bad' => 2,
                'Average' => 3,
                'Good' => 4,
                'Excellent' => 5
            ],
            'mapped' => false,
            'data' => $rating
        ]);


        $builder->add('location', CollectionType::class, [
            'entry_type' => LocationType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Itinerary::class,
        ]);
        $resolver->setDefaults(['rating' => 1]);
        $resolver->setAllowedTypes('rating', 'integer');
    }
}
