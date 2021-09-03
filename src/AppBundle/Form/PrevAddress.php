<?php

namespace AppBundle\Form;

use AppBundle\Entity\ApplicantPrevAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PrevAddress extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Line1', TextType::class)
            ->add('Line2', TextType::class, [
				'required' => false,
			])
			->add('TownCity', TextType::class)

			->add('County', EntityType::class, [
				'class' => 'AppBundle:Counties',
				'choice_label' => 'county',
				'choice_value' => 'county',
				'required' => false,
				'label' => 'County',
            ])

			->add('Country', CountryType::class, [
				'preferred_choices' => array('GB'),
				'placeholder' => 'Please Select',
			])
			->add('Postcode', TextType::class)
			->add('StartOn', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
                'required' => true,
				'label' => 'Date Moved In',
            ])
            ->add('EndOn', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
                'required' => true,
				'label' => 'Date Moved Out',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ApplicantPrevAddress::class,
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