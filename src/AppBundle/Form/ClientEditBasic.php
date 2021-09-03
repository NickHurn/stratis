<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ClientEditBasic extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
            ->add('companyName', TextType::class, array('required'=>true, 'attr'=>array('help'=>'Your company name, as it should appear in formal communications')))
			->add('firstName', TextType::class, array('label'=>'Main User First Name'))
			->add('surname', TextType::class, array('label'=>'Main User Surname'))
			->add('mobileNumber', TextType::class, array('label'=>'Office / Mobile Number', 'attr'=>array('help'=>'This is only used for our communications with you regarding your account')))
			->add('emailAddress', EmailType::class, array('label'=>'Email Address'))
			->add('postcode', TextType::class, array('label'=>'Post Code'))
			->add('line1', TextType::class, array('label'=>'Address Line 1'))
			->add('line2', TextType::class, array('label'=>'Address Line 2', 'required'=>false))
			->add('town', TextType::class, array('label'=>'Town'))
			->add('county', TextType::class, array('label'=>'County'))
            ->add('save', SubmitType::class, array(
				'label' => 'Save Details',
				'attr'	=> array('class' => 'btn btn-black'),
			));
    }

}
