<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ApplicantDelete extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
            ->add('email', EmailType::class, array('required'=>true, 'label'=>'Enter the email address of the applicant to delete'))
            ->add('save', SubmitType::class, array(
				'label' => 'Continue',
				'attr'	=> array('class' => 'btn btn-red'),
			));
    }
}

