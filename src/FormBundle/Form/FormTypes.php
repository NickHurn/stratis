<?php
/**
 * Created by PhpStorm.
 * User: scottbaverstock
 * Date: 27/06/2017
 * Time: 12:12
 */

namespace FormBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class FormTypes extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('formType', EntityType::class, array(
        'class' => 'FormBundle\Entity\FormType',
        'label' => 'Form Types',
        'choice_label' => 'name'
        ));

        $builder->add('job', EntityType::class, array(
            'class' => 'AppBundle\Entity\Jobs',
            'query_builder' => function (EntityRepository $er) use ($options)  {
                return $er->createQueryBuilder('j')
                    ->where('j.employerId = ?1')
                    ->orderBy('j.title', 'ASC')
                    ->setParameter(1, $options['employerId']);
            },
            'label' => 'Job',
            'choice_label' => 'title',
            'placeholder' => 'Select Job...',
            'required' => true
        ));

        $builder->add('EditForm', SubmitType::class, ['attr' => ['class' => 'btn btn-black btn-lrg']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'employerId' => '',
        ));
    }

}