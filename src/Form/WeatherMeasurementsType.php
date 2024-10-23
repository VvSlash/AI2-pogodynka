<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\WeatherMeasurements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class WeatherMeasurementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date',DateType::class, [
                'widget' => 'single_text',
                //'widget' => 'choice',
                'html5' => false,
                //'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('Celsius')
            ->add('Fahrenheit')
            ->add('Kelvin')
            ->add('Rain_Prediction')
            ->add('Wind_Speed')
            ->add('Humidity')
            ->add('Air_Pressure')
            ->add('Visibility')
            ->add('UV_Index')
            ->add('Weather_Description')
            ->add('Location', EntityType::class, [
                'class' => Location::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WeatherMeasurements::class,
        ]);
    }
}
