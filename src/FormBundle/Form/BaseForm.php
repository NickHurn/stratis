<?php
/**
 * Created by PhpStorm.
 * User: scottbaverstock
 * Date: 27/06/2017
 * Time: 12:12
 */

namespace FormBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['formParams']['disabled'] === true){
            $builder->setDisabled(true);
        }

        foreach($options['fields'] as $field){
            if($field['type'] === 'text'){
                $builder->add($field['fieldId'], TextType::class, ['required' => $field['required'], 'label' => $field['name'],  'label_attr' => ['data-id' => $field['fieldId'], 'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ]]);
            }
            if($field['type'] === 'textarea'){
                $builder->add($field['fieldId'], TextareaType::class, ['required' => $field['required'], 'label' => $field['name'],  'label_attr' => ['data-id' => $field['fieldId'],'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ]]);
            }
            if($field['type'] === 'integer'){
                $builder->add($field['fieldId'], NumberType::class, ['required' => $field['required'], 'label' => $field['name'],  'label_attr' => ['data-id' => $field['fieldId'],'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ]]);
            }
            if($field['type'] === 'email'){
                $builder->add($field['fieldId'], EmailType::class, ['required' => $field['required'], 'label' => $field['name'],  'label_attr' => ['data-id' => $field['fieldId'],'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ]]);
            }
            if($field['type'] === 'url'){
                $builder->add($field['fieldId'], UrlType::class, ['required' => $field['required'], 'label' => $field['name'], 'default_protocol' => 'http://',  'label_attr' => ['data-id' => $field['fieldId'],'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ]]);
            }
            if($field['type'] === 'date'){
                $builder->add($field['fieldId'], DateType::class, ['required' => $field['required'], 'label' => $field['name'], 'widget' => 'single_text','html5' => false,'attr' => ['class' => 'datepicker'],  'label_attr' => ['data-id' => $field['fieldId'],'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ]]);
            }
            if($field['type'] === 'yesno'){
                $builder->add($field['fieldId'], ChoiceType::class, ['required' => $field['required'], 'label' => $field['name'], 'choices'  => array(
                    'Yes' => true,
                    'No' => false,),
                    'expanded' => true,
                    'multiple' => false
                    ,  'label_attr' => ['data-id' => $field['fieldId'],'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ]]);
            }
            if($field['type'] === 'country'){
                $builder->add($field['fieldId'], CountryType::class, ['required' => $field['required'], 'label' => $field['name'], 'preferred_choices' => array($field['defaultCountry']) ,  'label_attr' => ['data-id' => $field['fieldId'],'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ]] );
            }
            if($field['type'] === 'numberRange'){

                $range = [];
                for($i=$field['min']; $i<=$field['max']; $i++){
                    $range[$i] = $i;
                }
                $builder->add($field['fieldId'], ChoiceType::class, ['required' => $field['required'], 'label' => $field['name'], 'label_attr' => ['data-id' => $field['fieldId'],'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ], 'choices'  => $range, 'placeholder'=>'Please Select...'] );
            }

            if($field['type'] === 'choice'){

                $o=[];
                foreach($field['choiceOptions'] as $option){
                    $o[$option->getName()] = $option->getValue();
                }

                $defaultOption = [
                    'required' => $field['required'],
                    'label' => $field['name'],
                    'choices' =>$o,
                    'label_attr' => ['data-id' => $field['fieldId'],'data-jobid' => $options['formParams']['jobId'], 'data-formtypeid' => $options['formParams']['formTypeId'] ],
                ];

                if($field['fieldType'] == 'radio'){
                    $typeOptions = ['expanded' => true, 'multiple' => false ];
                }elseif($field['fieldType'] == 'checkbox'){
                    $typeOptions = ['expanded' => true, 'multiple' => true ];
                }else{
                    $typeOptions = ['expanded' => false, 'multiple' => false ];
                }

                $builder->add($field['fieldId'], ChoiceType::class, array_merge($defaultOption, $typeOptions) );
            }
        }
        $builder->add($this->camelCase($options['formParams']['submit']), SubmitType::class, ['attr' => ['class' => 'btn btn-black btn-lrg']]);
    }

    public function camelCase($string){
        $bits = explode(' ',strtolower($string));
        for($i=0; $i<count($bits); $i++){
            if($i > 0){
                $bits[$i] = ucfirst($bits[$i]);
            }
        }
        return implode('', $bits);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'formParams' => [],
            'fields' => [],
        ));
    }
}