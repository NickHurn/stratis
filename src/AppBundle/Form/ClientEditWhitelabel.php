<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class ClientEditWhitelabel extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
            ->add('domain1', TextType::class, array('required'=>true, 'label'=>'Domain Name', 'attr'=>array('help'=>'Your complete domain name, without the https protocol. Eg, demo.koine.com')))
			->add('companyName', TextType::class, array('required'=>true, 'attr'=>array('help'=>'Your company name, how it should appear on the website generally and in Emails')))
			->add('footerName', TextType::class, array('required'=>true, 'label'=>'Company Name (footer)', 'attr'=>array('help'=>'Your company name, how it should appear in the footer of each page')))
			->add('contactNumber', TextType::class, array('required'=>true))
			->add('companyEmail', EmailType::class, array('required'=>true, 'attr'=>array('help'=>'This is only used for our communications with you regarding your account')))
			->add('newLogo', FileType::class, array('required'=>false, 'label' => 'Upload New Logo', 'attr'=>array('help'=>'Should be 200 x 80 PNG. Images will be resized and padded as needed)')))
			->add('headerBackgroundColour', TextType::class, array('required'=>true))
			->add('footerBackgroundColour', TextType::class, array('required'=>true))
            ->add('save', SubmitType::class, array(
				'label' => 'Save Details',
				'attr'	=> array('class' => 'btn btn-black'),
			));
    }

}
