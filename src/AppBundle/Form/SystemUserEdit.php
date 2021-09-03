<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class SystemUserEdit extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('firstName', TextType::class, array('required'=>true, 'label'=>'First Name'))
			->add('surname', TextType::class, array('required'=>true, 'label'=>'Surname'))
            ->add('emailaddress', TextType::class, array('required'=>true, 'label'=>'Email Address'))
			->add('hometel', TextType::class, array('required'=>false, 'label'=>'Home Telephone'))
			->add('mobiletel', TextType::class, array('required'=>true, 'label'=>'Mobile Telephone'))
			->add('save', SubmitType::class, array(
				'label' => 'Save',
				'attr'	=> array('class' => 'btn btn-black'),
			));
    }

}
