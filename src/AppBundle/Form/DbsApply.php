<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use AppBundle\Validator\Constraints as AppAssert;


class DbsApply extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('Title', ChoiceType::class, array(
                'choices'  => array(
					'Mr'		=> 'Mr',
					'Mrs'		=> 'Mrs',
					'Ms'		=> 'Ms',
					'Miss'		=> 'Miss',
					'Duchess'	=> 'Duchess',
					'Duke'		=> 'Duke',
					'Father'	=> 'Father',
					'Lady'		=> 'Lady',
					'Lord'		=> 'Lord',
					'Sir'		=> 'Sir',
					'Sister'	=> 'Sister',
					'Baron'		=> 'Baron',
					'Baroness'	=> 'Baroness',
					),
                'placeholder'=>'Select',
                'required' => true))
            ->add('Firstname', TextType::class, [
                'required' => true,
            ])

            ->add('Middlename1', TextType::class, [
                'required' => false,
                'label' => 'Middle name 1',

            ])
            ->add('Middlename2', TextType::class, [
                'required' => false,
                'label' => 'Middle name 2',

            ])
            ->add('Middlename3', TextType::class, [
                'required' => false,
                'label' => 'Middle name 3',

            ])
            ->add('Lastname', TextType::class, [
                'required' => true,
                'label' => 'Last Name',

            ])
			
			->add('BirthSurname', TextType::class, [
                'required' => false,
                'label' => 'Birth Surname (If Female and not Miss)',

            ])

            ->add('BirthSurnameUntil', ChoiceType::class, [
                'choices'  => $this->getYears(date('Y'), date('Y')-80),
                'placeholder'=>'Select',
                'required' => false
            ])

			
            ->add('Names', CollectionType::class, array(
                'entry_type' => PrevName::class,
                'allow_add'	=> true,
				'label'		=> false,
            ))
			

			->add('BirthDate', DateType::class, [
                'required'	=> true,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
				'label'		=> 'Date Of Birth',
            ])
			
			->add('BirthTown', TextType::class, [
                'required' => true,
                'label' => 'Birth Town',

            ])

			->add('BirthCounty', EntityType::class, [
				'class' => 'AppBundle:Counties',
				'choice_label' => 'county',
				'choice_value' => 'county',
				'required' => false,
				'label' => 'Birth County',
            ])

            ->add('BirthCountry', CountryType::class, [
                'required' => true,
				'label' => 'Birth Country',
                'preferred_choices' => array('GB'),
                'placeholder' => 'Please Select'
            ])

			->add('Nationality', TextType::class, [
                'required' => true,
				'label' => 'Birth Nationality'
            ])

			->add('MothersMaidenName', TextType::class, [
                'required' => true,
                'label' => 'Mothers Maiden Name',
            ])

			->add('PhoneNumber', TextType::class, [
                'required' => true,
                'label' => 'Phone Number',
            ])

            ->add('AddressLine1', TextType::class, [
                'required' => true,
                'label' => 'Address Line1',

            ])
            ->add('AddressLine2', TextType::class, [
                'required' => false,
                'label' => 'Address Line 2',

            ])
            ->add('AddressTownCity', TextType::class, [
                'required' => true,
                'label' => 'Town or City',

            ])
			->add('AddressCounty', EntityType::class, [
				'class' => 'AppBundle:Counties',
				'choice_label' => 'county',
				'choice_value' => 'county',
				'required' => false,
				'label' => 'County',
            ])
            ->add('AddressCountry', CountryType::class, [
                'required' => true,
                'label' => 'Country',
                'preferred_choices' => array('GB'),
				'placeholder' => 'Please Select'
            ])
            ->add('AddressPostcode', TextType::class, [
                'required' => true,
                'label' => 'Postcode',

            ])
            ->add('AddressStartDate', DateType::class, [
                'required'	=> true,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
                'label'		=> 'Date moved in',
            ])

			
			->add('Addresses', CollectionType::class, array(
                'entry_type' => PrevAddress::class,
                'allow_add'	=> true,
				'label'		=> false,
            ))

			->add('hasConvictions', ChoiceType::class, [
				'choices'  => array(
					'Yes' => '1',
					'No' => '0',
				),
                'placeholder'=>'Select',
                'required' => true,
				'label' => 'Do you have unspent convictions?',
			])

			->add('NINumber', TextType::class, [
                'required' => false,
                'label' => 'NI Number (if available)',
            ])
            ->add('DLNumber', TextType::class, [
                'required' => false,
                'label' => 'Driving Licence Number (if available)',
            ])
            ->add('DLCountry', CountryType::class, [
                'required' => false,
                'label' => 'Driving Licence Country of Issue',
                'preferred_choices' => array('GB'),
				'placeholder' => 'Please Select'
            ])

            ->add('PassportNumber', TextType::class, [
                'required' => false,
                'label' => 'Passport Number (if available)',
            ])
            ->add('PassportCountry', CountryType::class, [
                'required' => false,
                'label' => 'Passport Issuing Country',
                'preferred_choices' => array('GB'),
				'placeholder' => 'Please Select'

            ])
            ->add('IDCardNumber', TextType::class, [
                'required' => false,
                'label' => 'National ID Card (if available)',
            ])
			->add('IDCardCountry', CountryType::class, [
                'required' => false,
                'label' => 'ID Card Issuing Country',
                'preferred_choices' => array('GB'),
				'placeholder' => 'Please Select'

            ])
			->add('ApplicantDeclaration', CheckboxType::class, ['label' => 'I declare the above information to be true'])

            ->add('Submit', SubmitType::class, ['attr' => ['class' => 'btn btn-black appBtn appBtn-black']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }
	
	public function getYears($from, $to)
	{
        $years = [];
		$direction = ($from<$to) ? 1:-1;
		for($i=$from; $i<>$to; $i+=$direction) {
			$years[$i] = $i;
		}
        return $years;
    }
}
