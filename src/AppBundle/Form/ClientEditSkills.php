<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClientEditSkills extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('skills', EntityType::class, array(
			  'class' => 'AppBundle:Skills',
			  'label' => 'Choose skill sets ',
			  'choice_label' => 'Skill',
			  'expanded' => true,
			  'multiple' => true,
			))
			->add('save', SubmitType::class, array(
				'label' => 'Save Details',
				'attr'	=> array('class' => 'btn btn-black'),
			))
		;
    }
}
