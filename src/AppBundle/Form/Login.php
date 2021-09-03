<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class Login extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
            ->add('emailaddress', TextType::class, array('required'=>true, 'label'=>'Email Address'))
			->add('password', PasswordType::class, array('required'=>true, 'label'=>'Password'))
			->add('login', HiddenType::class, array('data'=>1))
			->add('signin', SubmitType::class, array(
				'label' => 'Log On',
				'attr'	=> array('class' => 'btn btn-sm btn-black'),
			));
    }

}
