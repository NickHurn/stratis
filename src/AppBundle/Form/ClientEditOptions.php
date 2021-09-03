<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class ClientEditOptions extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
            ->add('checkabl', CheckboxType::class, array('label'=>'Checkabl', 'required'=>false))
			->add('personabl', CheckboxType::class, array('required'=>false))
			->add('testabl', CheckboxType::class, array('required'=>false))
//			->add('dbs', CheckboxType::class, array('label'=>'DBS Checks', 'required'=>false))
			->add('cv', CheckboxType::class, array('label'=>'CV Uploads', 'required'=>false))
            ->add('save', SubmitType::class, array(
				'label' => 'Save Details',
				'attr'	=> array('class' => 'btn btn-black'),
			)
		);
    }

}
