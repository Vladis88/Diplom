<?php

namespace App\Form\Filter;

use App\Model\Filter\SimpleFilterModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SimpleFilterForm
 */
class SimpleFilterForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mark', IntegerType::class)
            ->add('model', IntegerType::class, [
                'required' => false
            ])
            ->add('generation', IntegerType::class, [
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
            'data_class' => SimpleFilterModel::class,
            'csrf_protection' => false
        ]);
    }
}
