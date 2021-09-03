<?php

namespace FormBundle\Factory;
use AppBundle\Entity\Employers;
use AppBundle\Entity\Jobs;
use AppBundle\Entity\Users;
use Doctrine\Common\Persistence\ObjectManager;
use FormBundle\Entity\Field;
use FormBundle\Entity\Form;
use FormBundle\Entity\FormType;
use FormBundle\Form\BaseForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;


class FormFactory extends Controller
{
    /**
     * @var ObjectManager $em
     */
    private $em;
    protected $container;
    private $formFactory;

    public function __construct(ObjectManager $em, $formFactory, Container $container)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->container = $container;
    }

    /**
     * @param $formType FormType
     * @param $employer Employers
     * @param $jobId Jobs
     * @param bool $disable
     * @return Form|null|object
     */
    public function getForm($formType, $employer, $job, $disable = false)
    {
       $form = $this->em->getRepository('FormBundle:Form')->findOneBy(['formType' => $formType, 'employer' => $employer, 'job' => $job]);

        $formParams = [
            'name' => 'TestForm',
            'action' => '',
            'method' => 'post',
            'submit' => 'Send Data!',
            'disabled' => $disable,
            'formTypeId' => $form->getFormType()->getId(),
            'jobId' => $job->getUniqueId()
        ];


        /**
         * @var $field Field
         */
        foreach($form->getFields() as $key=>$field){
           $field->setOField($this->em->getRepository($field->getType())->find($field->getTypeId()));
        }

        $fields = $form->getFieldParameters();

        $form = $this->formFactory->create(BaseForm::class, [], ['fields' => $fields, 'formParams' => $formParams, ]);
        return $form;
    }

    /**
     * @param int $id
     * @param Form $form
     * @return Field
     */
    public function getField($id, Form $form)
    {
        return $this->em->getRepository('FormBundle:Field')->findOneBy(['id' => $id, 'form' => $form]);
    }


    /**
     * @param $formType
     * @param $employer
     * @return \FormBundle\Entity\Form
     */
    public function getFormEntity($formType, $employer, $job)
    {
        return $this->em->getRepository('FormBundle:Form')->findOneBy(['formType' => $formType, 'employer' => $employer, 'job' => $job]);
    }

    public function getAllFormFields($formType, $employer, $job)
    {
        $fe = $this->getFormEntity($formType, $employer, $job);
        $fields = $fe->getFields();
        return $fields;
    }


    public function getFieldEntity(Field $field)
    {
        $value = $this->em->getRepository($field->getType())->findOneBy(['id' => $field->getTypeId()]);
        return $value;
    }

    /**
     * @param Field $field
     * @param Form $form
     * @param Users $user
     * @return null|object
     */
    public function getValue(Field $field, Form $form, Users $user)
    {
        $value = $this->em->getRepository($field->getValueType())->findOneBy(['formId' => $form->getId(), 'fieldId' => $field->getId(), 'userId' => $user->getId()]);
        if(is_null($value)){
            $valueType = $field->getValueType();
            $value = new $valueType();
            $value->setFormId($form->getId());
            $value->setFieldId($field->getId());
            $value->setUserId($user->getId());
        }
        return $value;
    }

    /**
     * @param Field $field
     * @param Form $form
     * @param Users $user
     * @return null|object
     */
    public function getAllValue(Field $field, Form $form, Users $user)
    {
        $value = $this->em->getRepository($field->getValueType())->findBy(['formId' => $form->getId(), 'fieldId' => $field->getId()]);
        if(is_null($value)){
            $valueType = $field->getValueType();
            $value = new $valueType();
            $value->setFormId($form->getId());
            $value->setFieldId($field->getId());
            $value->setUserId($user->getId());
        }
        return $value;
    }

}
