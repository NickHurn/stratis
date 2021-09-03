<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class AML extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
            ->add('Title', ChoiceType::class, array(
				'choices' => array(
					'Mr' => 'Mr',
					'Mrs' => 'Mrs',
					'Ms' => 'Ms',
					'Miss' => 'Miss',
					'Duchess' => 'Duchess',
					'Duke' => 'Duke',
					'Father' => 'Father',
					'Lady' => 'Lady',
					'Lord' => 'Lord',
					'Sir' => 'Sir',
					'Sister' => 'Sister',
					'Baron' => 'Baron',
					'Baroness' => 'Baroness',
				),
				'placeholder' => 'Select',
				'required' => true))
			->add('Forename', TextType::class, array('required'=>true, 'label'=>'Forename'))
			->add('Middlename', TextType::class, array('required'=>false, 'label'=>'Midde Name'))
			->add('Surname', TextType::class, array('required'=>true, 'label'=>'Surname'))
			->add('Gender', ChoiceType::class, array('required'=>true, 'label'=>'Gender', 'choices'  => array('Male' => 'Male', 'Female' => 'Female'), 'placeholder'=>'Select'))
            ->add('DOB', DateType::class, [
                'required'	=> true,
                'widget' => 'single_text',
				'format' => 'dd/MM/yyyy',
                'label'		=> 'Date Of Birth',
            ])
			->add('MothersMaidenName', TextType::class, array('required'=>false, 'label'=>'Mothers Maiden Name'))
			->add('SurnameAtBirth', TextType::class, array('required'=>false, 'label'=>'Surname At Birth'))
			->add('TownAtBirth', TextType::class, array('required'=>false, 'label'=>'Town Of Birth'))
			
			->add('AddressLine1', TextType::class, array('required'=>true, 'label'=>'Address Line 1'))
			->add('AddressLine2', TextType::class, array('required'=>false, 'label'=>'Address Line 2'))
			->add('AddressLine3', TextType::class, array('required'=>true, 'label'=>'Town/City'))
			->add('AddressLine4', TextType::class, array('required'=>false, 'label'=>'County'))
			->add('AddressLine5', TextType::class, array('required'=>true, 'label'=>'Post Code'))
			->add('Telephone', TextType::class, array('required'=>false, 'label'=>'Landline Telephone Number'))
			->add('Mobile', TextType::class, array('required'=>false, 'label'=>'Mobile Number'))
			->add('ResidentFrom', DateType::class, array('required'=>true, 'widget' => 'single_text', 'format' => 'MM-yyyy', 'label'=>'Resident From'))
			->add('ResidentTo', DateType::class, array('required'=>true, 'widget' => 'single_text', 'format' => 'MM-yyyy', 'label'=>'Resident Until'))
			->add('PrevAddressLine1', TextType::class, array('required'=>false, 'label'=>'Address Line 1'))
			->add('PrevAddressLine2', TextType::class, array('required'=>false, 'label'=>'Address Line 2'))
			->add('PrevAddressLine3', TextType::class, array('required'=>false, 'label'=>'Town/City'))
			->add('PrevAddressLine4', TextType::class, array('required'=>false, 'label'=>'County'))
			->add('PrevAddressLine5', TextType::class, array('required'=>false, 'label'=>'Post Code'))
			->add('PrevResidentFrom', DateType::class, array('required'=>false, 'widget' => 'single_text', 'format' => 'MM-yyyy', 'label'=>'Resident From'))
			->add('PrevResidentTo', DateType::class, array('required'=>false, 'widget' => 'single_text', 'format' => 'MM-yyyy', 'label'=>'Resident Until'))

			->add('LongPassportNumber', TextType::class, array('required'=>false, 'label'=>'Long (MRZ) Passport Number'))
			->add('ShortPassportNumber', TextType::class, array('required'=>false, 'label'=>'Short Passport Number'))
			->add('PassportIssue', DateType::class, array('required'=>false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'label'=>'Issue Date'))
			->add('PassportExpiry', DateType::class, array('required'=>false, 'widget' => 'single_text', 'format' => 'dd-MM-yyyy', 'label'=>'Expiry Date'))
			->add('PassportIssueCountry', TextType::class, array('required'=>false, 'label'=>'Country Of Issue'))
			->add('DLNumber', TextType::class, array('required'=>false, 'label'=>'Driving Licence Number'))
			->add('DLForename', TextType::class, array('required'=>false, 'label'=>'Forename'))
			->add('DLSurname', TextType::class, array('required'=>false, 'label'=>'Surname'))
			->add('NINumber', TextType::class, array('required'=>false, 'label'=>'National Insurance Number'))
            ->add('save', SubmitType::class, array(
				'label' => 'Save Details',
				'attr'	=> array('class' => 'btn btn-black appBtn appBtn-black'),
			));
    }

}
