<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ClientEditCredits extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$creditvalues = array();
		for($i=1; $i<=10; $i++) $creditvalues[$i]=$i;
		for($i=15; $i<=50; $i+=5) $creditvalues[$i]=$i;
		for($i=60; $i<=100; $i+=10) $creditvalues[$i]=$i;
		
		$builder
            ->add('addremove', ChoiceType::class, array(
				'label'		=> 'Add or remove credits',
				'choices'	=> array(
					'Add' => 'Add',
					'Remove' => 'Remove',
				),
			))
            ->add('numcredits', ChoiceType::class, array(
				'label' => 'Number of Credits',
				'choices' => $creditvalues,
			))
            ->add('save', SubmitType::class, array(
				'label' => 'Save Details',
				'attr'	=> array('class' => 'btn btn-black'),
			)
		);
    }

}
