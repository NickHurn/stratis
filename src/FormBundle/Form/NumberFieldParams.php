<?php
/**
 * Created by PhpStorm.
 * User: scottbaverstock
 * Date: 27/06/2017
 * Time: 12:12
 */

namespace FormBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NumberFieldParams extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, []);
        $builder->add('heading', TextType::class, ['attr' => ['placeholder' => 'Enter a short name for this field.  eg. \'DOB\' instead of Date of Birth']]);
        $builder->add('formId', HiddenType::class, ['data' => $options['formId'],]);
        $builder->add('required', ChoiceType::class, ['choices'  => array(
            'Yes' => true,
            'No' => false,),
            'expanded' => true,
            'multiple' => false]);
        $builder->add('filterable', ChoiceType::class, ['choices'  => array(
            'Yes' => 1,
            'No' => 0,)]);

        $builder->add('filterOperator', ChoiceType::class, ['choices'  => array(
            'Less Than' => 'lt',
            'Greater Than' => 'gt',
            'Equal' => 'eq',),
            'label' => 'Filter Operator. Eg.  Filter if value is "less than" 6',
            ]);


        $builder->add('filterOn', NumberType::class, ['label' => 'Filter On. Eg. Filter if value is less than "6" ']);


        $builder->add('Add Number Input', SubmitType::class, ['attr' => ['class' => 'btn btn-black btn-lrg']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'formId' => '',
        ));
    }

}