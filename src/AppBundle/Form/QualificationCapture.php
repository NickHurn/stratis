<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;


class QualificationCapture extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'constraints' => new NotBlank(), 'label' => 'First name'))
            ->add('middleName', TextType::class, array(
                'constraints' => array(), 'label' => 'Middle name or Initial', 'required'=>false))
            ->add('lastName', TextType::class, array(
                'constraints' => array(new NotBlank())))
            ->add('email', EmailType::class, array(
                'constraints' => array(new NotBlank())))
            ->add('dob', DateType::class, [
                'constraints' => new NotBlank(), 'label' => 'Date Of Birth', 'years' => range(date('Y', strtotime('16 years ago')), date('Y', strtotime('70 years ago')))
            ])
            ->add('gender', ChoiceType::class, array(
                'choices'  => array(
                    'Male' => 'male',
                    'Female' => 'female',
                ),
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('studentId', TextType::class, array(
                'constraints' => array(new NotBlank())))
            ->add('membership', TextType::class, array(
                'constraints' => array(), 'required' => false, 'label' => 'Membershjp Type'))
            ->add('reference', TextType::class, array(
                'constraints' => array(), 'required' => false))
            ->add('courseTitle', TextType::class, array(
                'constraints' => array(new NotBlank()), 'label' => 'Degree / Course Title'))
            ->add('award', TextType::class, array(
                'constraints' => array(new NotBlank())))
            ->add('grade', TextType::class, array(
                'constraints' => array(new NotBlank()), 'label' => 'Class of Degree / Grade Achieved:'))
            ->add('enrolment', NumberType::class, array(
                'constraints' => array(new NotBlank()), 'label' => 'Year of Enrolment'))
            ->add('graduated', NumberType::class, array(
                'constraints' => array(new NotBlank()), 'label' => 'Year of Graduation'))

            ->add('submit', SubmitType::class,[])
        ;
    }

}

