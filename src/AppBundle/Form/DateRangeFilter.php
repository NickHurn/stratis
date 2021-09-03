<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DateRangeFilter extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'dateFrom'=>'Date From:',
            'dateTo'=>'Date To:',
            'submitLabel'=>'Submit',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('fromDate', DateTimeType::class, [
                'required'	=> true,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
                'label'		=> $options['dateFrom'],
                'format' => 'dd-MM-y',
            ])
            ->add('toDate', DateTimeType::class, [
                'required'	=> true,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
                'label'		=> $options['dateTo'],
                'format' => 'dd-MM-y',
            ])
            ->add('save', SubmitType::class, [
        'attr' => ['class' => 'btn-black',],
        'label' => $options['submitLabel'],
    ]);
    }
}

