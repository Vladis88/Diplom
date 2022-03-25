<?php

namespace App\Form;

use App\Entity\User\Subscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SubscriptionForm
 */
class SubscriptionForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mark', EntityType::class, [
                'class' => 'App\Entity\CarMark',
                'required' => true
            ])
            ->add('model', EntityType::class, [
                'class' => 'App\Entity\CarModel',
                'required' => false
            ])
            ->add('generation', EntityType::class, [
                'class' => 'App\Entity\CarGeneration',
                'required' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => Subscription::class,
            'csrf_protection' => false
        ]);
    }
}
