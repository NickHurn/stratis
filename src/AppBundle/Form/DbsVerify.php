<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use AppBundle\Validator\Constraints as AppAssert;


class DbsVerify extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('agreeDob', CheckboxType::class, ['label' => 'I confirm that at least one of the documents I have seen contains a date of birth'])
            ->add('agreeAddress', CheckboxType::class, ['label' => 'I confirm that at least one of the documents I have seen contains a current address'])
            ->add('agreeName', CheckboxType::class, ['label' => 'I agree that I have seen documentary evidence for all name changes'])

            ->add('drivingLicenceNumber', TextType::class, [
                'required' => false,
                'label' => 'Driving Licence Number',
            ])
            ->add('drivingLicenceDob', DateType::class, [
                'required' => false,
                'label' => 'Driving Licence Date of Birth',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepickerdob'],
            ])
            ->add('drivingLicenceStart', DateType::class, [
                'required' => false,
                'label' => 'Driving Licence Start Date',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepickerdob'],
            ])
            ->add('drivingLicenceCountry', CountryType::class, [
                'required' => false,
                'label' => 'Driving Licence Country of Issue',
                'preferred_choices' => array('GB'),
                'placeholder' => 'Please Select'
            ])
            ->add('drivingLicenceIssue', DateType::class, array(
                'required' => false,
                'label' => 'Driving Licence Date of Issue',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepickerissue'],
            ))
            ->add('passportNumber', TextType::class, [
                'required' => false,
                'label' => 'Passport Number',
            ])
            ->add('passportDob', DateType::class, [
                'required' => false,
                'label' => 'Passport Date of Birth',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepickerdob'],
            ])
            ->add('passportIssue', DateType::class, array(
                'required' => false,
                'label' => 'Passport Date of Issue',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepickerissue'],
            ))
            ->add('passportNationality', CountryType::class, [
                'required' => false,
                'label' => 'Passport Country of Issue',
                'preferred_choices' => array('GB'),
                'placeholder' => 'Please Select'
            ])
            ->add('birthCertificateIssue', DateType::class, [
                'required' => false,
                'label' => 'Certificate Date of Issue',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepickerissue'],
            ])
            ->add('birthDob', DateType::class, [
                'required' => false,
                'label' => 'Certificate Date of Birth',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepickerdob'],
            ])

           ->add('Submit', SubmitType::class, ['attr' => ['class' => 'btn btn-black']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }
}

