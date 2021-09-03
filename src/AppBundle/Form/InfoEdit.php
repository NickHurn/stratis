<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class InfoEdit extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
            ->add('formName', TextType::class, array('required'=>true))
			->add('timeLimit', IntegerType::class, array('required'=>true, 'attr'=>array('help'=>'If you enter a value here, the time limit on the individual questions will be ignored, that this value used for the overall test time.')))
			->add('passScore', IntegerType::class, array('required'=>true))

            ->add('save', SubmitType::class, array(
				'label' => 'Save',
				'attr'	=> array('class' => 'btn btn-black left', 'value'=>1),
			))
		
			->add('delete', SubmitType::class, array(
				'label' => 'Delete',
				'attr'	=> array('class' => 'btn btn-danger', 'value'=>1),
			));

    }

}
