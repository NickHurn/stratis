<?php

namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserEdit extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		
		$builder
			->add('firstname', TextType::class, array('required'=>true, 'label'=>'First Name'))
			->add('surname', TextType::class, array('required'=>true, 'label'=>'Surname'))
            ->add('emailaddress', TextType::class, array('required'=>true, 'label'=>'Email Address'))
			->add('hometel', TextType::class, array('required'=>false, 'label'=>'Home Telephone'))
			->add('mobiletel', TextType::class, array('required'=>true, 'label'=>'Mobile Telephone'))
			->add('postcode', TextType::class, array('required'=>true, 'label'=>'PostCode'))
			->add('line1', TextType::class, array('required'=>true, 'label'=>'Address Line 1'))
			->add('line2', TextType::class, array('required'=>false, 'label'=>'Address Line 2'))
			->add('line3', TextType::class, array('required'=>false, 'label'=>'Address Line 3'))
            ->add('town', TextType::class, array('required'=>true))
			->add('county', TextType::class, array('required'=>true))
			->add('retention', ChoiceType::class, array(
                'choices'  => array(
					'Keep my data until I ask otherwise'		=> '0',
					'1 month after any job search activity'		=> '1',
					'3 months after any job search activity'	=> '3',
					'6 months after any job search activity'	=> '6',
					),
				'label' => 'GDPR: How long should we keep your data on file?',
                'required' => true));

		$builder->add('save', SubmitType::class, array(
			'label' => 'Save',
			'attr'	=> array('class' => 'btn btn-black'),
		));
	}

}
