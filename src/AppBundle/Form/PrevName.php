<?php

namespace AppBundle\Form;

use AppBundle\Entity\ApplicantPrevName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrevName extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Name', TextType::class)
            ->add('Type', ChoiceType::class, [
                'choices'  => array(
                    'Forename' => 'Forename',
                    'Surname' => 'Surname',
                ),
                'placeholder'=>'Select',
                'required' => true
            ])
            ->add('StartDate', ChoiceType::class, [
                'choices'  => $this->getYears(date('Y'), date('Y')-80),
                'placeholder'=>'Select',
                'required' => true
            ])
            ->add('EndDate', ChoiceType::class, [
                'choices'  => $this->getYears(date('Y'), date('Y')-80),
                'placeholder'=>'Select',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ApplicantPrevName::class,
        ));
    }

    public function getYears($from, $to){
        $years = [];
		$direction = ($from<$to) ? 1:-1;
		for($i=$from; $i<>$to; $i+=$direction) {
			$years[$i] = $i;
		}
        return $years;
    }
}