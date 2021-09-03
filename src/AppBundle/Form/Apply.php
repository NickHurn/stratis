<?php

namespace AppBundle\Form;

use AppBundle\Entity\ApplicantPrevAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class Apply extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(

            'csrf_protection' => false,

        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('firstName', TextType::class, array(
                'label' => 'First Name',
                'required' => true,
                'attr'	=> array('class' => 'form-group')))
            ->add('surname', TextType::class, array(
                'label' => 'Surname',
                'required' => true,
                'attr'	=> array('class' => 'form-field')))
			->add('email', TextType::class, array(
                'label' => 'Email',
                'required' => true,
                'attr'	=> array('class' => 'form-field')))
			->add('mobiletel', TextType::class, array(
                'label' => 'Mobile Phone Number',
                'required' => false,
                'attr'	=> array('class' => 'form-field')))
			->add('hometel', TextType::class, array(
                'label' => 'Home Phone Number',
                'required' => false,
                'attr'	=> array('class' => 'form-field')))
            ->add('houseNumber', TextType::class, array(
                'label' => 'House Number',
                'attr' => array('class'=>'form-field housenumber'),
                'required' => false))
			->add('postcode', TextType::class, array(
                'label' => 'Postcode',
				'attr' => array('class'=>'datepicker postcode form-field'),
                'required' => false))
			->add('line1', TextType::class, array(
                'label' => 'Address Line 1',
                'required' => true,
                'attr'	=> array('class' => 'form-field')))
			->add('line2', TextType::class, array(
                'label' => 'Address Line 2',
                'required' => false,
                'attr'	=> array('class' => 'form-field')))
			->add('line3', TextType::class, array(
                'label' => 'Address Line 3',
                'required' => false,
                'attr'	=> array('class' => 'form-field')))
			->add('town', TextType::class, array(
                'label' => 'Town',
                'required' => true,
                'attr'	=> array('class' => 'form-field')))
			->add('county', TextType::class, array(
                'label' => 'County',
                'required' => false,
                'attr'	=> array('class' => 'form-field')))
            ->add('retention', ChoiceType::class, array(
                'choices'  => array(
					'Keep my data until I ask otherwise'		=> '0',
					'1 month after any job search activity'		=> '1',
					'3 months after any job search activity'	=> '3',
					'6 months after anyjob search activity'		=> '6',
					),
                'placeholder'=>'Select',
				'label' => 'GDPR: How long should we keep your data on file?',
                'required' => true))
			->add('submit', SubmitType::class, array(
                'label' => 'Sign Up',
				'attr'	=> array('class' => 'btn btn-sm btn-black')))
		;
    }
}
