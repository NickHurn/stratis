<?php
/**
 * Created by PhpStorm.
 * User: scottbaverstock
 * Date: 27/06/2017
 * Time: 12:12
 */

namespace FormBundle\Form;


use FormBundle\Entity\ChoiceOption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ChoicesOptionParams extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'Option Name eg. Yes']);
        $builder->add('value', TextType::class, ['label' => 'Option Value eg. 1']);
        $builder->add('filterOn', ChoiceType::class, ['label' => 'Filter on this option', 'choices'  => array(
            'No' => 0,
            'Yes' => 1)]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ChoiceOption::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
        ));
    }

}