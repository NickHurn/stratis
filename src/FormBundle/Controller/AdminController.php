<?php

namespace FormBundle\Controller;

use AppBundle\Entity\Users;
use FormBundle\Entity\Field;
use FormBundle\Entity\Fields\ChoicesField;
use FormBundle\Entity\Fields\CountryField;
use FormBundle\Entity\Fields\DateField;
use FormBundle\Entity\Fields\EmailField;
use FormBundle\Entity\Fields\IntegerField;
use FormBundle\Entity\Fields\NumberRangeField;
use FormBundle\Entity\Fields\TextAreaField;
use FormBundle\Entity\Fields\TextField;
use FormBundle\Entity\Fields\UrlField;
use FormBundle\Entity\Fields\YesNoField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/admin", name="form_create_admin")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        /**
         * @var Users $user
         */
        $user = $this->getUser();
        $formFactory = $this->get('app.form_factory');
        $form = $this->createForm('FormBundle\Form\FormTypes', [], ['employerId' => $user->getEmployerId()]);
        $show = false;
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $job = [];

        if($form->isSubmitted() && $form->isValid()){
            $show = true;

            $formType = $form->get('formType')->getData();
            $employer = $em->getRepository('AppBundle:Employers')->find($user->getEmployerId());
            $job = $form->get('job')->getData();
            $customForm = $formFactory->getForm($formType, $employer, $job, true);
            $textFieldParams = $this->createForm('FormBundle\Form\TextFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            $textAreaFieldParams = $this->createForm('FormBundle\Form\TextAreaFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            $emailFieldParams = $this->createForm('FormBundle\Form\EmailFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            $urlFieldParams = $this->createForm('FormBundle\Form\UrlFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            $numberFieldParams = $this->createForm('FormBundle\Form\NumberFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            $dateFieldParams = $this->createForm('FormBundle\Form\DateFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            $yesNoFieldParams = $this->createForm('FormBundle\Form\YesNoFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            $countryFieldParams = $this->createForm('FormBundle\Form\CountryFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            $numberRangeFieldParams = $this->createForm('FormBundle\Form\NumberRangeFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            $choiceFieldParams = $this->createForm('FormBundle\Form\ChoicesFieldParams',[], ['formId' => $formFactory->getFormEntity($formType, $employer, $job)->getId()]);
            return $this->render('FormBundle:Admin:admin.html.twig', ['form'=>$form->createView(), 'customForm' => $customForm->createView(),
                    'textFieldParams' =>  $textFieldParams->createView(),
                    'numberFieldParams' =>  $numberFieldParams->createView(),
                    'emailFieldParams' =>  $emailFieldParams->createView(),
                    'urlFieldParams' =>  $urlFieldParams->createView(),
                    'dateFieldParams' =>  $dateFieldParams->createView(),
                    'yesNoFieldParams' => $yesNoFieldParams->createView(),
                    'countryFieldParams' => $countryFieldParams->createView(),
                    'numberRangeFieldParams' => $numberRangeFieldParams->createView(),
                    'choiceFieldParams' => $choiceFieldParams->createView(),
                    'textAreaFieldParams' => $textAreaFieldParams->createView(),
                    'openpage' => 'checkabl_form',
                    'show' => $show, 'formTypeId' => $formType,'job' => $job]);
        }

        return $this->render('FormBundle:Admin:admin.html.twig', ['form'=>$form->createView(), 'show' => $show, 'job' => $job]);
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/textfield", name="form_add_textfield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addTextFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $textField = new TextField();
        $textFieldParams = $this->createForm('FormBundle\Form\TextFieldParams',$textField);
        $textFieldParams->submit($request->query->get($textFieldParams->getName()));
        if($textFieldParams->isSubmitted() && $textFieldParams->isValid())
        {
            $textField = $textFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($textField->getFormId());
            $em->persist($textField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\TextField');
            $field->setForm($form);
            $field->setName($textField->getName());
            $field->setOrder(3);
            $field->setTypeId($textField->getId());
            $field->setValueType('FormBundle\Entity\Values\TextValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($textFieldParams), 500);
        }

        return new Response();
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/textareafield", name="form_add_textareafield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addTextAreaFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $textAreaField = new TextAreaField();
        $textAreaFieldParams = $this->createForm('FormBundle\Form\TextAreaFieldParams',$textAreaField);
        $textAreaFieldParams->submit($request->query->get($textAreaFieldParams->getName()));
        if($textAreaFieldParams->isSubmitted() && $textAreaFieldParams->isValid())
        {
            $textAreaField = $textAreaFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($textAreaField->getFormId());
            $em->persist($textAreaField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\TextAreaField');
            $field->setForm($form);
            $field->setName($textAreaField->getName());
            $field->setOrder(3);
            $field->setTypeId($textAreaField->getId());
            $field->setValueType('FormBundle\Entity\Values\TextAreaValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($textAreaFieldParams), 500);
        }

        return new Response();
    }


    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/emailfield", name="form_add_emailfield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addEmailFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $emailField = new EmailField();
        $emailFieldParams = $this->createForm('FormBundle\Form\EmailFieldParams',$emailField);
        $emailFieldParams->submit($request->query->get($emailFieldParams->getName()));
        if($emailFieldParams->isSubmitted() && $emailFieldParams->isValid())
        {
            $emailField = $emailFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($emailField->getFormId());
            $em->persist($emailField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\EmailField');
            $field->setForm($form);
            $field->setName($emailField->getName());
            $field->setOrder(3);
            $field->setTypeId($emailField->getId());
            $field->setValueType('FormBundle\Entity\Values\TextValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($emailFieldParams), 500);
        }

        return new Response();
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/urlfield", name="form_add_urlfield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addUrlFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $urlField = new UrlField();
        $urlFieldParams = $this->createForm('FormBundle\Form\UrlFieldParams',$urlField);
        $urlFieldParams->submit($request->query->get($urlFieldParams->getName()));
        if($urlFieldParams->isSubmitted() && $urlFieldParams->isValid())
        {
            $urlField = $urlFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($urlField->getFormId());
            $em->persist($urlField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\UrlField');
            $field->setForm($form);
            $field->setName($urlField->getName());
            $field->setOrder(4);
            $field->setTypeId($urlField->getId());
            $field->setValueType('FormBundle\Entity\Values\TextValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($urlFieldParams), 500);
        }

        return new Response();
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/numberfield", name="form_add_numberfield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addNumberFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $numberField = new IntegerField();
        $numberFieldParams = $this->createForm('FormBundle\Form\NumberFieldParams',$numberField);
        $numberFieldParams->submit($request->query->get($numberFieldParams->getName()));
        if($numberFieldParams->isSubmitted() && $numberFieldParams->isValid())
        {
            $numberField = $numberFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($numberField->getFormId());
            $em->persist($numberField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\IntegerField');
            $field->setForm($form);
            $field->setName($numberField->getName());
            $field->setOrder(3);
            $field->setTypeId($numberField->getId());
            $field->setValueType('FormBundle\Entity\Values\NumberValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($numberFieldParams), 500);
        }

        return new Response();
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/datefield", name="form_add_datefield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addDateFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dateField = new DateField();
        $dateFieldParams = $this->createForm('FormBundle\Form\DateFieldParams',$dateField);
        $dateFieldParams->submit($request->query->get($dateFieldParams->getName()));
        if($dateFieldParams->isSubmitted() && $dateFieldParams->isValid())
        {
            $dateField = $dateFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($dateField->getFormId());
            $em->persist($dateField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\DateField');
            $field->setForm($form);
            $field->setName($dateField->getName());
            $field->setOrder(4);
            $field->setTypeId($dateField->getId());
            $field->setValueType('FormBundle\Entity\Values\DateValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($dateFieldParams), 500);
        }

        return new Response();
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/yesnofield", name="form_add_yesnofield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addYesNoFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $yesnoField = new YesNoField();
        $yesnoFieldParams = $this->createForm('FormBundle\Form\YesNoFieldParams',$yesnoField);
        $yesnoFieldParams->submit($request->query->get($yesnoFieldParams->getName()));
        if($yesnoFieldParams->isSubmitted() && $yesnoFieldParams->isValid())
        {
            $yesnoField = $yesnoFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($yesnoField->getFormId());
            $em->persist($yesnoField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\YesNoField');
            $field->setForm($form);
            $field->setName($yesnoField->getName());
            $field->setOrder(5);
            $field->setTypeId($yesnoField->getId());
            $field->setValueType('FormBundle\Entity\Values\NumberValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($yesnoFieldParams), 500);
        }
        return new Response();
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/countryfield", name="form_add_countryfield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addCountryFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $countryField = new CountryField();
        $countryFieldParams = $this->createForm('FormBundle\Form\CountryFieldParams',$countryField);
        $countryFieldParams->submit($request->query->get($countryFieldParams->getName()));
        if($countryFieldParams->isSubmitted() && $countryFieldParams->isValid())
        {
            $countryField = $countryFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($countryField->getFormId());
            $em->persist($countryField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\CountryField');
            $field->setForm($form);
            $field->setName($countryField->getName());
            $field->setOrder(5);
            $field->setTypeId($countryField->getId());
            $field->setValueType('FormBundle\Entity\Values\TextValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($countryFieldParams), 500);
        }
        return new Response();
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/numberrangefield", name="form_add_numberrangefield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addNumberRangeFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $numberRangeField = new NumberRangeField();
        $numberRangeFieldParams = $this->createForm('FormBundle\Form\NumberRangeFieldParams',$numberRangeField);
        $numberRangeFieldParams->submit($request->query->get($numberRangeFieldParams->getName()));
        if($numberRangeFieldParams->isSubmitted() && $numberRangeFieldParams->isValid())
        {
            $numberRangeField = $numberRangeFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($numberRangeField->getFormId());
            $em->persist($numberRangeField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\NumberRangeField');
            $field->setForm($form);
            $field->setName($numberRangeField->getName());
            $field->setOrder(5);
            $field->setTypeId($numberRangeField->getId());
            $field->setValueType('FormBundle\Entity\Values\NumberValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($numberRangeFieldParams), 500);
        }
        return new Response();
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/add/choicesfield", name="form_add_choicesfield")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addChoiceFieldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $choicesField = new ChoicesField();
        $choicesFieldParams = $this->createForm('FormBundle\Form\ChoicesFieldParams',$choicesField);
        $choicesFieldParams->submit($request->query->get($choicesFieldParams->getName()));
        if($choicesFieldParams->isSubmitted() && $choicesFieldParams->isValid())
        {
            $choicesField = $choicesFieldParams->getData();
            $form = $em->getRepository('FormBundle:Form')->find($choicesField->getFormId());
            $em->persist($choicesField);
            $em->flush();

            $field = new Field();
            $field->setType('FormBundle\Entity\Fields\ChoicesField');
            $field->setForm($form);
            $field->setName($choicesField->getName());
            $field->setOrder(5);
            $field->setTypeId($choicesField->getId());
            $field->setValueType('FormBundle\Entity\Values\TextValue');
            $em->persist($field);
            $em->flush();
        } else {
            return $this->json($this->getErrorMessages($choicesFieldParams), 500);
        }
        return new Response();
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/results", name="form_results")
     */
    public function viewValuesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $clientUser = $this->getUser();

        $form = $this->createForm('FormBundle\Form\FormTypes', [], ['employerId' => $clientUser->getEmployerId()]);
        $form->handleRequest($request);
        $employer = $this->getDoctrine()->getManager()->getRepository('AppBundle:Employers')->find($clientUser->getEmployerId());
        $formFactory = $this->get('app.form_factory');


        $show = false;

        $data = [];
        $headers = [];

        if($form->isSubmitted() && $form->isValid()){
            $show = true;
            $job = $form->get('job')->getData();
            $fields = $formFactory->getAllFormFields(1, $employer, $job);
            $formType = $form->get('formType')->getData();
            $formEntity = $formFactory->getFormEntity($formType->getId(), $employer, $job);
            $data = [];
            foreach($fields as $field) {
                $fieldEntity = $formFactory->getFieldEntity($field);
                $valueEntities = $formFactory->getAllValue($field, $formEntity, $clientUser);

                $headers[] = $fieldEntity->getHeading();

                foreach($valueEntities as $valueEntity) {
                    $filtered = 0;
                    if(get_class($fieldEntity) == 'FormBundle\Entity\Fields\ChoicesField'){
                        $options = $fieldEntity->getOptions();
                        foreach($options as $o){
                            if($o->getValue() == $valueEntity->getValue()){
                                $filtered = $o->getFilterOn();
                            }
                        }
                    } else {
                        $filtered = (method_exists($fieldEntity, 'getFilterable') && $fieldEntity->getFilterable() === 1 ? $fieldEntity->filtered($valueEntity->getValue()) : 0);
                    }

                    $data[$valueEntity->getUserId()][$fieldEntity->getHeading()] = ["value" => $valueEntity->getValue(),
                        "filtered" => $filtered,
                    ];
                    $data[$valueEntity->getUserId()]['Filtered'] = ['value' => 'No', 'filtered' => 0];
                }
            }
            $headers[] = 'Filtered';

            foreach($data as $key => $d){
                foreach($d as $field=>$v){

                    if($v['filtered'] === 1){
                        $data[$key]['Filtered'] = ['value' => 'Yes', 'filtered' => 0];
                    }
                }

            }
        }

        return $this->render('FormBundle:Admin:results.html.twig', ['form' => $form->createView(), 'show' => $show, 'data' => $data, 'headers' => $headers, 'openpage' => 'checkabl_form',]);
    }


    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/get/{formTypeId}/rendered/{jobId}", name="form_get_rendered")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFormAction(Request $request, $formTypeId, $jobId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $formFactory = $this->get('app.form_factory');
        $employer = $em->getRepository('AppBundle:Employers')->find($user->getEmployerId());
        $job = $em->getRepository('AppBundle:Jobs')->find($jobId);
        $customForm = $formFactory->getForm($formTypeId, $employer,$job, true);
        return $this->render('FormBundle:Admin:form.html.twig', ['customForm' => $customForm->createView()]);
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/{formTypeId}/delete/field/{fieldId}/{jobId}", name="form_delete_field")
     * @param Request $request
     * @param int $formTypeId
     * @param int $fieldId
     * @param int $jobId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteField(Request $request, $formTypeId, $fieldId, $jobId)
    {
        $em = $this->getDoctrine()->getManager();
        $formFactory = $this->get('app.form_factory');
        $user = $this->getUser();
        $employer = $em->getRepository('AppBundle:Employers')->find($user->getEmployerId());
        $job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $jobId]);
        $formEntity = $formFactory->getFormEntity($formTypeId, $employer, $job);

        $field = $formFactory->getField($fieldId, $formEntity);
        $fieldEntity = $formFactory->getFieldEntity($field);

        $values = $formFactory->getAllValue($field, $formEntity, $user);

        foreach ($values as $v){
            $em->remove($v);
        }
        $em->remove($field);
        $em->remove($fieldEntity);

        $em->flush();

        return $this->json(['removed']);
    }


    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/form/{formTypeId}/edit/choice/{fieldId}/{jobId}", name="form_edit_choice_field")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getChoicesFieldAction($formTypeId, $fieldId = null, $jobId)
    {
        $em = $this->getDoctrine()->getManager();
        $formFactory = $this->get('app.form_factory');
        $user = $this->getUser();
        $employer = $em->getRepository('AppBundle:Employers')->find($user->getEmployerId());
        $job = $em->getRepository('AppBundle:Job')->find($jobId);
        if(is_null($fieldId)){
            $choiceField = [];
        } else {
            $field = $em->getRepository('FormBundle:Field')->findOneBy(['id' => $fieldId]);
            $choiceField = $em->getRepository('FormBundle:Fields\ChoicesField')->findOneBy(['id' => $field->getTypeId()]);
        }

        $choiceFieldParams = $this->createForm('FormBundle\Form\ChoicesFieldParams',$choiceField, ['formId' => $formFactory->getFormEntity($formTypeId, $employer, $job)->getId()]);

        return $this->render('@Form/Admin/Forms/choices.html.twig', ['choiceFieldParams' => $choiceFieldParams->createView()]);
    }

    /**
     * @param Form $form
     * @return array
     */
    private function getErrorMessages(Form $form) {
        /**
         * @var $field Form
         */
        $errors = array();
        foreach($form->all() as $field){
            if($field->getErrors()->count() > 0){
                $errors[$field->getName()]= $field->getErrors()->current()->getMessage();
            }
        }

        if(count($form->getErrors()) >= 1){
            $errors['Form']= $form->getErrors()->current()->getMessage();
        }
        return $errors;
    }

}
