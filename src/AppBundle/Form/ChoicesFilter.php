<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ChoicesFilter extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'data'=>[],
            'name'=>'',
            'label'=>'',
            'placeholder'=>'',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add($options['name'], ChoiceType::class,['choices'=>$options['data']['choices'],'label'=>$options['label'],'placeholder'=>$options['placeholder'], 'required'=>false]);
    }
}

