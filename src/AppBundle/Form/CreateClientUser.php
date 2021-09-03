<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use AppBundle\Validator\Constraints as AppAssert;

class CreateClientUser extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyname', TextType::class, array(
                'constraints' => new NotBlank(), 'label' => 'Company Name', 'attr'=>array('help'=>'As it should appear in emails, screen footers, etc')))
            ->add('firstname', TextType::class, array(
                'constraints' => new NotBlank(), 'label' => 'Main User First Name', 'attr'=>array('help'=>'This will be the main administrative user')))
            ->add('surname', TextType::class, array(
                'constraints' => new NotBlank(), 'label' => 'Main User Surname'))
            ->add('email', EmailType::class, array('constraints' => array(
                new Email(),new NotBlank(), new AppAssert\UserCheck()), 'label' => 'Email Address'))
            ->add('mobile', TextType::class, array(
                'constraints' => new NotBlank(), 'label' => 'Office / Mobile Number'))
			->add('postcode', TextType::class, array('label'=>'Post Code'))
			->add('address1', TextType::class, array('label'=>'Address Line 1'))
			->add('address2', TextType::class, array('label'=>'Address Line 2'))
			->add('town', TextType::class, array('label'=>'Town'))
			->add('county', TextType::class, array('label'=>'County'));
    }
}

