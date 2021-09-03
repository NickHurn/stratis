<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use AppBundle\Validator\Constraints as AppAssert;


class EmploymentHistory extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('CompanyName', TextType::class, [])
            ->add('JobTitle', TextType::class, [])
			->add('StartDate', TextType::class, ['widget'=>'single_text', 'format'=>'dd-MM-yyyy'])
			->add('EndDate', TextType::class, ['widget'=>'single_text', 'format'=>'dd-MM-yyyy'])
			->add('Description', TextareaType::class, ['attr'=>['rows'=>15]])
            ->add('Submit', SubmitType::class, ['attr' => ['class' => 'btn btn-black']]);
    }

}
