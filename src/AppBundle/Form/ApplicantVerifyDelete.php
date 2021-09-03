<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ApplicantVerifyDelete extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('confirm', TextType::class, array('required'=>true))
            ->add('save', SubmitType::class, array(
				'label' => 'Confirm Deletion',
				'attr'	=> array('class' => 'btn btn-red'),
			));
    }
}

