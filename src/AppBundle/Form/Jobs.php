<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class Jobs extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('jobs', EntityType::class, array(
                'class' => 'AppBundle:Jobs',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('j')
                        ->where('j.employerId = '.$options['employerId'] )
                        ->orderBy('j.startDate', 'DESC');
                },
                'label' => 'Job Title',
                'choice_label' => 'title',
                'choice_value' => 'id',
                'placeholder' => 'Choose a job to filter the results',
            ))
        ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-black']]);
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'employerId' => '0',
        ));
    }

}

