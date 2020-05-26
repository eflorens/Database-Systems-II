<?php

namespace App\Form;

use App\Entity\Travel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TravelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('origin', CountryType::class)
            ->add('destination', CountryType::class)
            ->add('cost');

        $builder->add('rating', ChoiceType::class, [
            'choices' => [
                'Terrible' => 1,
                'Bad' => 2,
                'Average' => 3,
                'Good' => 4,
                'Excellent' => 5
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Travel::class,
        ]);
    }
}
