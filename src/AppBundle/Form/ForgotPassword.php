<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ForgotPassword extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
			->add('emailaddress', EmailType::class, array(
				'required' => true, 
				'label' => 'Email Address',
//				'options' => array('attr' => array('class' => 'password-field')),
			))
			->add('save', SubmitType::class, [
			'attr' => ['class' => 'btn btn-black'],
			'label' => 'Send Link',
			'disabled' => false
			]);
    }
}

