<?php

namespace App\Form;

use App\Entity\Details;
use App\Entity\Log;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('timestemp')
            ->add('level')
            ->add('client_ip')
            ->add('message')
            ->add('log', EntityType::class, [
                'class' => Log::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function registerDetails(FormBuilderInterface $builder, array $opts, array $details): void
    {
        $builder
            ->add('timestamp')
            ->add('level')
            ->add('client_ip')
            ->add('message')
            ->add('log', EntityType::class, [
                'class'=> Log::class,
                'choice_label' => 'id',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Details::class,
        ]);
    }
}
