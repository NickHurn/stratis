<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class TermsEdit extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
            ->add('title', TextType::class, array('required'=>true))
			->add('terms', TextareaType::class, array(
				'attr'	=> array('rows' => 15),
			))
            ->add('save', SubmitType::class, array(
				'label' => 'Save',
				'attr'	=> array('class' => 'btn btn-black'),
			));
    }

}
