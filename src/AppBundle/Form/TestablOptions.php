<?php

namespace AppBundle\Form;

use AppBundle\AppBundle;
use AppBundle\Entity\ClassmarkerLinks;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class TestablOptions extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tests', EntityType::class, array(
            'class' => 'AppBundle:ClassmarkerLinks',
            'label' => 'Classmarker Tests',
            'choice_label' => 'LinkName',
            'expanded' => true,
            'multiple' => true,
        ));

        $builder->add('exceltests', EntityType::class, array(
            'class' => 'AppBundle:ExcelTests',
            'label' => 'Excel Tests',
            'choice_label' => 'Name',
            'expanded' => true,
            'multiple' => true,
        ));

    }

}

