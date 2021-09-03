<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ConsentImport;
use AppBundle\Entity\QualificationChecks;
use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QualificationController extends Controller
{

    /**
     * @Route("/qualification/institute/{token}", name="search_institute")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getInstituteAction(Request $request, $token)
    {

        $em = $this->getDoctrine()->getManager();
        $check = $em->getRepository('AppBundle:QualificationChecks')->findOneBy(['token' => $token]);
        $show=0;

        if(is_null($check)){
            return $this->render('@App/qualification/badtoken.html.twig', []);
        }

        if(!is_null($check->getInstituteId())){
            return $this->redirectToRoute('qualification_check', ['token' => $token]);
        }

        $form = $this->createForm('AppBundle\Form\InstituteSearch');

        $qual = $this->get('app.qualification_check');
        $authenticated = $qual->authenticate();

        $form->handleRequest($request);
        if($authenticated === false){
            $form->addError(new FormError('There has been a problem Accessing the Qualification system.  Please try again later.'));
            $this->sendAuthError();
        }

        $institutes = [];

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $institutes = $qual->searchInstitute($data['name']);
            $show = 1;
        }

        return $this->render('@App/qualification/institute.html.twig', [
            'form' => $form->createView(),
            'institutes' => $institutes,
            'token' => $token,
            'show' => $show
        ]);
    }

    /**
     * @Route("/qualification/institute/set/{instituteId}/{token}", name="set_institute")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setInstituteAction($instituteId, $token)
    {

        $em = $this->getDoctrine()->getManager();
        $check = $em->getRepository('AppBundle:QualificationChecks')->findOneBy(['token' => $token]);
        if(!is_null($check->getVerificationId())){
            return $this->render('@App/qualification/badtoken.html.twig', []);
        }

        if(is_null($check)){
            return new Response('Access Denied');
        }

        $check->setInstituteId($instituteId);
        $em->persist($check);
        $em->flush();

        return $this->redirectToRoute('qualification_check', ['token' => $token]);
    }

    /**
     * @Route("/checkabl/qualification/{token}", name="qualification_check")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $token )
    {
        $mailer = $this->get('mailer');
        $em = $this->getDoctrine()->getManager();
        $check = $em->getRepository('AppBundle:QualificationChecks')->findOneBy(['token' => $token]);
        $error = null;
        if(!is_null($check->getVerificationId())){
            return $this->render('@App/qualification/badtoken.html.twig', []);
        }

        if(is_null($check)){
            return new Response('Access Denied');
        }

        $qual = $this->get('app.qualification_check');
        $authenticated = $qual->authenticate();
        $institute = $qual->getInstitute($check->getInstituteId());

        $form = $this->createForm('AppBundle\Form\QualificationCapture', $check);
        $form->handleRequest($request);

        if($authenticated === false){
            $form->addError(new FormError('There has been a problem Accessing the Qualification system.  Please try again later.'));
            $this->sendAuthError();
        }

        if($form->isSubmitted() && $form->isValid()){

            /**
             * @var $check QualificationChecks
             */
            $check = $form->getData();

            $result = json_decode($qual->submitVerification($check, $institute), true);

            if ($result['result'] != 'Bad Request'){
                $check->setVerificationId($result['id']);
                $check->setVerificationResponse(json_encode($result));
                $check->setVerificationStatus($result['result']);

                $candidate = $em->getRepository('AppBundle:CombinedUser')->find($check->getUserId());
                $user = $em->getRepository('AppBundle:CombinedUser')->find($check->getCreatedBy());

                $em->persist($check);
                if ($result['result'] == 'VERIFIED') {
                    $job = $em->getRepository('AppBundle:Jobs')->find($check->getJobId());
                    $ec = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['jobCode' => $job->getUniqueid(), 'checkType' => 'Qualifications']);
                    $ec->setStatus('Completed');
                    $em->persist($ec);
                }
                if ($result['result'] == 'PENDING') {
                    $job = $em->getRepository('AppBundle:Jobs')->find($check->getJobId());
                    $ec = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['jobCode' => $job->getUniqueid(), 'checkType' => 'Qualifications']);
                    $ec->setStatus('Awaiting processing');
                    $em->persist($ec);
                }
                $em->flush();

                $messageParams = [
                    'status' => $check->getVerificationStatus(),
                    'name' => $user->getName(),
                    'candidate' => $candidate->getName()
                ];

                $message = (new \Swift_Message('Qualification Check Submitted'))
                    ->setFrom('recruitment@koine.com')
                    ->setTo('recruitment@koine.com')
                    ->setBody($this->renderView('@App/Emails/qualification.new.html.twig', $messageParams),'text/html' )
                    ->addPart(
                        $this->renderView('@App/Emails/qualification.new.text.twig',$messageParams),
                        'text/plain'
                    );
                $mailer->send($message);

                if($institute['consentFormRequired']){
                    return $this->redirectToRoute('qualification_consent_upload', ['token' => $token]);
                }
                $this->addFlash('notice', 'Your check has been submitted.  You will be emailed the result once the check has been completed.  Depending on the institute this could take a few minutes or a few days.  Thanks');
                return $this->redirect('/checkabl/'.$check->getJobId()->getUniqueId());
            }else{
                $error='There has been a problem Accessing the Qualification system.  Please try again later.';
            }

        }

        return $this->render('@App/qualification/check.html.twig', [
            'form' => $form->createView(),
            'institute' => $institute,
            'error'=>$error,
        ]);
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/qualification", name="qualification_view")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function qualificationViewAction(Request $request)
    {
        /**
         * @var $user Users
         */

        $em = $this->getDoctrine()->getManager();
        $employee = $this->getUser();

        $jobsForm = $this->createForm('AppBundle\Form\Jobs',[], ['employerId' => $employee->getEmployerId()]);
        $jobsForm->handleRequest($request);

        if($jobsForm->isSubmitted() && $jobsForm->isValid()){
            $job = $jobsForm->getData();
            if(is_null($job)){
                $checks = $em->getRepository('AppBundle:QualificationChecks')->findBy(['employer_id' => $employee->getEmployerId()]);
            } else {
                $checks = $em->getRepository('AppBundle:QualificationChecks')->findBy(['employer_id' => $employee->getEmployerId(), 'jobId' => $job]);
            }
        } else {
            $checks = $em->getRepository('AppBundle:QualificationChecks')->findBy(['employer_id' => $employee->getEmployerId()]);
        }


        return $this->render('@App/qualification/adminlist.html.twig',[
            'jobForm' => $jobsForm->createView(),
            'checks' => $checks,
            'openpage' => 'checkabl_qualification'
        ]);

    }


    /**
     * @Route("/qualification/consent/upload/{token}", name="qualification_consent_upload")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadConsentFormAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $consentImport = new ConsentImport();
        $check = $em->getRepository('AppBundle:QualificationChecks')->findOneBy(['token' => $token]);

        if(!is_null($check)){

            $form = $this->createForm('AppBundle\Form\ConsentImport', $consentImport);
            $qual = $this->get('app.qualification_check');
            $qual->authenticate();
            $institute = $qual->getInstitute($check->getInstituteId());

            $application = $qual->refreshStatus($check->getVerificationId());
            $imports = $em->getRepository('AppBundle:ConsentImport')->findBy(['qualificationId'=>$check->getId()]);
            if(isset($application['result'])){
                $check->setVerificationStatus($application['result']);
            }
            $em->persist($check);
            if ($application['result'] == 'PENDING') {
                $job = $em->getRepository('AppBundle:Jobs')->find($check->getJobId());
                $ec = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['jobCode' => $job->getUniqueid(), 'checkType' => 'Qualifications']);
                $ec->setStatus('Awaiting processing');
                $em->persist($ec);
            }
            $em->flush();

            if($application['result'] == 'AWAITING_CONSENT') {
                return $this->render('@App/qualification/loadconsent.html.twig', [
                    'form' => $form->createView(),
                    'token' => $check->getToken(),
                    'institute' => $institute,
                    'application' => $application,
                    'check' => $check,
                ]);
            } else {
                return $this->redirect('https://'.$_SERVER['HTTP_HOST'].'/checkabl/'.$check->getJobId()->getUniqueId());
            }

        } else {
            return $this->render('@App/qualification/badtoken.html.twig', []);
        }

    }

    /**
     * @Route("/qualification/consent/process", name="qualification_consent_process")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function processConsentFormAction(Request $request)
    {

        $consentImport = new ConsentImport();
        $form = $this->createForm('AppBundle\Form\ConsentImport', $consentImport);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consentImport = $form->getData();

            $check = $em->getRepository('AppBundle:QualificationChecks')->findOneBy(['token' => $request->request->get('token')]);
            // $file stores the uploaded PDF file
            /**
             * @var UploadedFile $file
             */
            $file = $consentImport->getConsentFile();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $consentImport->setMimeType($file->getMimeType());

            $file->move(
                $this->getParameter('consent_import'),
                $fileName
            );

            $consentImport->setConsentFile($fileName);
            $consentImport->setQualificationId($check->getId());
            $consentImport->setName($request->request->get('name'));
            $fullFilePath = $this->getParameter('consent_import').'/'.$fileName;
            $em->persist($consentImport);
            $em->flush();
            $qual = $this->get('app.qualification_check');
            $qual->authenticate();
            $application = $qual->refreshStatus($check->getVerificationId());
            $qual->postConsent($fullFilePath, $consentImport, $fileName, $application['id']);


            return $this->json(['success' => true, 'id'=>$consentImport->getId()]);
        } else {
            return $this->json(['success' => false, 'fileErrors'=>$this->getErrorMessages($form), 'formError' => $this->getFormError($form)]);
        }
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/qualification/refresh/{verificationId}/{token}", name="qualification_refresh")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function refreshStatusAction(Request $request, $verificationId, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $check = $em->getRepository('AppBundle:QualificationChecks')->findOneBy(['token' => $token, 'verificationId' => $verificationId]);
        if(is_null($check)){
            return $this->render('@App/qualification/badtoken.html.twig', []);
        }

        $qual = $this->get('app.qualification_check');
        $qual->authenticate();
        $result = $qual->refreshStatus($check->getVerificationId());
        if(isset($result['result'])){
            $check->setVerificationStatus($result['result']);
        }
        $em->persist($check);


        if ($result['result'] == 'VERIFIED' || $result['result'] == 'REJECTED' || $result['result'] == 'NOT_VERIFIED') {
            $job = $em->getRepository('AppBundle:Jobs')->find($check->getJobId());
            $ec = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['jobCode' => $job->getUniqueid(), 'checkType' => 'Qualifications']);
            $ec->setStatus('Completed');
            $em->persist($ec);
        }
        $em->flush();

        $this->addFlash('notice', 'The verification has been successfully updated');

        return $this->redirectToRoute('qualification_view');
    }


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
        return $errors;
    }

    private function getFormError(Form $form) {
        /**
         * @var $field Form
         */
        $errors = array();
        if($form->getErrors()->count() >= 1) {
            return $form->getErrors()->current()->getMessage();
        }
        return $errors;
    }

    private function sendAuthError()
    {
        $mailer = $this->get('mailer');
        $message = (new \Swift_Message('Qualification API Auth Failure'))
            ->setFrom('scott@erigan.co.uk')
            ->setTo('scott@erigan.co.uk')
            ->setBody(
                $this->renderView(
                    '@App/qualification/authfailed.html.twig',
                    array()
                ),
                'text/html'
            );

        $mailer->send($message);

    }

    /**
     * @Route("/qualification/add", name="checkabl_qualification_add")
     */
    public function qualificationAddAction()
    {
        return $this->render('@App/qualification/qualification.add.html.twig', [
            'openpage' => 'checkabl_qualification_add'
        ]);
    }

}
