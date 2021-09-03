<?php

namespace AppBundle\Form;

use AppBundle\Entity\ApplicantPrevAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\JobCategories;



class Job extends AbstractType
{
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('entity_manager');
    }

	
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$arr_jobtypes = array(0=>"Full Time", "Part Time", "Contract", "Internship", "Temp" );
		foreach($arr_jobtypes as $job=>$idx) $jobtypes[$idx] = $job;

		$em = $options['entity_manager'];
		$cats = $em->getRepository('AppBundle:JobCategories')->findBy(array(), array('category' => 'ASC'));
		foreach($cats as $cat) {
			$categories[$cat->getCategory()] = $cat->getId();
		}
		
        $builder
			->add(
				'category', ChoiceType::class, [
					'label' => 'Category',
					'choices' => $categories])

			->add('type', ChoiceType::class, array(
				'label'		=> 'Job Type',
				'choices'	=> $jobtypes))

			->add('title', TextType::class, array(
                'label' => 'Job Title',
				'attr' => array('maxlength' => 50),
                'required' => true))

            ->add('standfirst', TextareaType::class, array(
                'label' => 'Standfirst',
                'attr' => array('style'=>'height:300px'),
                'required' => false))

			->add('description', TextareaType::class, array(
                'label' => 'Description',
				'attr' => array('style'=>'height:300px'),
                'required' => false))

			->add('county', TextType::class, array(
                'label' => 'Location',
                'required' => true))

			->add('startDate', DateType::class, array(
                'label' => 'Start Date',
				'widget' => 'single_text',
				'format' => 'dd-MM-yyyy',
				'attr' => array('autocomplete' => 'off'),
                'required' => true))

			->add('salary', TextType::class, array(
                'label' => 'Salary',
				'attr' => array('maxlength' => 50),
                'required' => true))

			->add('positions', IntegerType::class, array(
                'label' => 'Number of Positions',
				'attr' => array('min'=>'1', 'max' => 100, 'step'=>'1'),
                'required' => true))

			->add('active', ChoiceType::class, array(
                'label' => 'Active',
				'required' => true,
				'choices' => array(
					'No' => '0',
					'Yes' => '1')))

			->add('Functionality', ChoiceType::class, [
	            'choices' => ['Checkabl'=>'CHK', 'Testabl'=>'TEST', 'Personabl'=>'PERS'],
	            'multiple' => true,
	            'expanded' => true,
	        ])
			
			->add('chkoptions', ChoiceType::class, [
	            'choices' => ['Pre Screen Form'=>'PRE', 'Employment and Education History'=>'HIS'],
				'label' => 'Checkabl Filter Options',
				'attr'	=> [ 'class' => 'chkoptions', 'id' => 'chkoptions', ],
	            'multiple' => true,
	            'expanded' => true,
	        ])

			->add('jobboards', ChoiceType::class, [
	            'choices' => ['indeed.com'=>'INDEED', 'monster.com'=>'MONSTER', 'cv-library.co.uk'=>'CVLIBRARY'],
				'label' => 'Include on Job Board(s)',
	            'multiple' => true,
	            'expanded' => true,
                'disabled' => true
	        ])

			->add('employmentMax', IntegerType::class, array(
                'label' => 'Employment History Maximum',
				'attr' => array('min'=>'0', 'max' => 10, 'step'=>'1'),
                'required' => true))

			->add('educationMax', IntegerType::class, array(
                'label' => 'Education History Maximum',
				'attr' => array('min'=>'0', 'max' => 10, 'step'=>'1'),
                'required' => true))

			->add('submit', SubmitType::class, array(
                'label' => 'Save',
				'attr'	=> array('class' => 'btn btn-black saveButton')))
    ;

		
	}
}
