<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ClientEditUsage extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
            ->add('startDate', DateType::class, array(
				'label' => 'Start Date',
				'attr' => array('class' => 'datepicker'),
				'html5' => false,
				'required'	=> true,
                'widget' => 'single_text',
			))
            ->add('endDate', DateType::class, array(
				'label' => 'End Date',
				'html5' => false,
				'required'	=> true,
                'widget' => 'single_text',
				'attr' => array('class' => 'datepicker'),
			))
			->add('save', SubmitType::class, array(
				'label' => 'Generate Report',
				'attr'	=> array('class' => 'btn btn-black'),
			)
		);
    }

}
