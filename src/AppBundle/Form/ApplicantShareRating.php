<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ApplicantShareRating extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('rating',HiddenType::class)
            ->add('notes',TextareaType::class, ['attr' => ['cols'=>80, 'rows'=>4, ],'required' => false,])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-black btn-md', 'style' => 'line-height:10px;'],
                'label' => 'Submit Rating'
            ]);
    }
}

