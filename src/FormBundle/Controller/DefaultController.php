<?php

namespace FormBundle\Controller;

use FormBundle\Entity\CompletedForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/formgen/{formname}/{jobId}")
     */
    public function indexAction(Request $request, $formname, $jobId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $formType = $em->getRepository('FormBundle:FormType')->findOneBy(['name' => $formname]);
        $job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $jobId]);

        $usersjob = $em->getRepository('AppBundle:UsersJob')->findOneBy(['userId' => $user->getId(), 'jobId' => $jobId]);

        if(!is_null($usersjob)) {
            $employer = $em->getRepository('AppBundle:Employers')->find($job->getEmployerId());
        } else {
        $employer = $em->getRepository('AppBundle:Employers')->find($user->getEmployerId());
        }

        $formFactory = $this->get('app.form_factory');
        $form = $formFactory->getForm($formType->getId(), $employer, $job);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $formEntity = $formFactory->getFormEntity($formType->getId(), $employer, $job);

            $completedForm = new CompletedForm();
            $completedForm->setFormType($formType);
            $completedForm->setUser($user);
            $completedForm->setJob($job);
            $completedForm->setForm($formEntity);
            $completedForm->setEmployer($employer);

            $em->persist($completedForm);

            $preScreenPass = 1;

            foreach($data as $fieldId => $formValue)
            {
                $field = $formFactory->getField($fieldId, $formEntity);
                $fieldEntity = $formFactory->getFieldEntity($field);
                $value = $formFactory->getValue($field, $formEntity, $user);
                $value->setValue($formValue);

                $filtered = 0;

                if(get_class($fieldEntity) == 'FormBundle\Entity\Fields\ChoicesField'){
                    $options = $fieldEntity->getOptions();
                    foreach($options as $o){
                        if($o->getValue() == $formValue){
                            $filtered = $o->getFilterOn();
                        }
                    }
                } else {
                    $filtered = (method_exists($fieldEntity, 'getFilterable') && $fieldEntity->getFilterable() === 1 ? $fieldEntity->filtered($formValue) : 0);
                }

                if($filtered === 1){
                    $preScreenPass = 0;
                }

                $em->persist($value);
            }

            $usersjob->setPreScreenPass($preScreenPass);
            $em->persist($usersjob);

            $em->flush();

            //redirect here
            $whiteLabel=$this->get('app.whitelabel');
            $path = 'https://'.$_SERVER['HTTP_HOST'];

            return $this->redirect($path.'/checkabl');



        }
        return $this->render('FormBundle:Default:index.html.twig', ['form' => $form->createView()]);
    }

}
