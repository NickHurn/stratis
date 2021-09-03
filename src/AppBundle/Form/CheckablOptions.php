<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use AppBundle\Validator\Constraints as AppAssert;

class CheckablOptions extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cv', CheckboxType::class, array(
                'label' => 'CV Uploads',
                'required' => false))
            ->add('skills', EntityType::class, array(
                'class' => 'AppBundle:Skills',
                'label' => 'Skills',
                'choice_label' => 'Skill',
                'expanded' => true,
                'multiple' => true,
            ));
    }

}

