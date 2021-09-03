<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApplicantDisclosureData;
use AppBundle\Entity\ApplicantDisclosureVerification;
use AppBundle\Entity\ExtraChecks;
use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DbsController extends Controller
{
    /**
     * @Route("/dbs/apply/{id}/{job_code}", name="dbs_apply_user")
     */
    public function indexAction(Request $request, $id, $job_code)
    {
        $em = $this->getDoctrine()->getManager();
        $extraCheck = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['id'=>$id,'jobCode'=>$job_code]);
        $dbs = $em->getRepository('AppBundle:ApplicantDisclosures')->findOneBy(['job_id'=>$extraCheck->getJobCode(), 'applicant_id'=>$extraCheck->getUserId()]);
		if(!$dbs)
		{
			return $this->render('@App/error/usererror.html.twig', array(
				'title' => 'Invalid Request',
				'msg' => 'The page requested is using an incorrect code. Either you have entered the code incorrectly or a link you followed 
					contains an error.',
			));
		}
		//  (extrachecks = test has been requested)
		//  (applicantdisclosures = test started)
		if(is_null($dbs))
		{
			return $this->render('@App/error/usererror.html.twig', array(
				'title' => 'Invalid Request',
				'msg' => 'The page requested is using an incorrect code. Either you have entered the code incorrectly or a link you followed 
					contains an error.',
			));
        }
        if($dbs->getApplicantStatus() == 'Completed' && $dbs->getGbgStatusCode() !== 3){
            return $this->render('@App/dbs/completed.html.twig', [
				'hireabl_status' => $dbs->getHireablStatus(),
				'gbg_status' => $dbs->getGbgStatus(),
				'status_date' => $dbs->getStatusDate(),
				'jobcode' => $job_code,
			]);
        }
        $applicantData = $em->getRepository('AppBundle:ApplicantDisclosureData')->findOneBy(['applicant_id' => $dbs->getEmployeeId()]);
		if(is_null($applicantData)){
            $applicantData = new ApplicantDisclosureData();
            $applicantData->setApplicantId($dbs->getApplicantId());
            $applicantData->setJobId($dbs->getJobId());
        }
        $form = $this->createForm('AppBundle\Form\DbsApply',$applicantData,[]);
        $form->handleRequest($request);
		$result = null;
        if($form->isSubmitted() && $form->isValid()) 
		{
		    $user_id = $dbs->getApplicantId();
            $code=$dbs->getCode();

            $applicantData = $form->getData();
            $applicantData->setBirthCountry($request->request->get('dbs_apply')['BirthCountry']);
            $em->persist($applicantData);
			$applicantData->setApplicantId($user_id);
            $em->flush();
			$disclosure = $this->get('app.disclosures');

			$sbm_data = $applicantData->getDataForSubmission($code, $this->getParameter('disclosure_position'));
			
			if($dbs->getGbgStatusCode() === 3) { 
                $result = $disclosure->updateApplication($sbm_data);
            } else {
                $result = $disclosure->createApplication($sbm_data);
            }
			//  If OK, update applicant_disclosure_status to completed, re-direct to alt.domain/checkabl
			//  If Not OK, assign error messages to view
			if($result == null) {
				$dbs->setApplicantStatus('Completed');
                $dbs->setHireablStatus('Started');
				$dbs->setStatusDate(new \DateTime('now'));
				$em->persist($dbs);

				$extraCheck->setStatus('Confirm Required');
				$extraCheck->setDateCompleted(new \DateTime('now'));
                $em->persist($extraCheck);

                $em->flush();

				return $this->render('@App/dbs/completed.html.twig', []);
			}
        }

        return $this->render('@App/dbs/index.html.twig', [
            'form' => $form->createView(),
			'errors' => $result,
			'jobcode' => $job_code,
        ]);
    }

    /**
     * @Route("/dbs/positions", name="dbs_get_positions")
     */
    public function getPositions()
    {
        $disclosure = $this->get('app.disclosures');
       // var_dump($disclosure->getPositions());
       // exit;
    }

    /**
     * @param Request $request
     * @param $code
     * @Route("/dbs/verify/{code}", name="dbs_verify_id")
     * @return Response
     */
    public function verifyDisclosureAction(Request $request, $code)
    {
        /**
         * @var ApplicantDisclosureVerification $verification
         * @var Users $user
         */
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $dbs = $em->getRepository('AppBundle:ApplicantDisclosures')->findOneBy(['code' => $code, 'employer_id' => $user->getEmployerId()]);
        if(is_null($dbs)){
            return new Response('Access Denied');
        }

        if($dbs->getHireablStatus() === 'Completed'){
            return $this->render('@App/dbs/verify.success.html.twig', []);
        }
        $verification = $em->getRepository('AppBundle:ApplicantDisclosureVerification')->findOneBy(['application' => $dbs]);

        if(is_null($verification)){
            $verification = new ApplicantDisclosureVerification();
            $verification->setApplication($dbs);
        }

		//  grab dbsdata from candidate input (applicant_disclosure_data) to pre-populate verification form

		$job_code = $dbs->getJobId();
		$candidateId =  $dbs->getEmployeeId();
		$add = $em->getRepository('AppBundle:ApplicantDisclosureData')->findOneBy(['job_id' => $job_code, 'applicant_id' => $candidateId]);
		$dbsdata = array();
		if($add)
		{
			$dbsdata['drivingLicenceNumber'] = $add->getDLNumber();
			$dbsdata['drivingLicenceDob'] = $add->getBirthDate();
			//$dbsdata['drivingLicenceStart'] = '';
			$dbsdata['drivingLicenceCountry'] = $add->getDLCountry();
			//$dbsdata['drivingLicenceIssue'] = '';
			$dbsdata['passportNumber'] = $add->getPassportNumber();
			//$dbsdata['passportDob'] = '';
			//$dbsdata['passportIssue'] = '';
			$dbsdata['passportNationality'] = $add->getPassportCountry();
		}
        //$form = $this->createForm('AppBundle\Form\DbsVerify', $verification);
		$form = $this->createForm('AppBundle\Form\DbsVerify', $dbsdata);
        $form->handleRequest($request);
        $result = null;
        if($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();
            $verification->setDrivingLicenceCountry($formData['drivingLicenceCountry']);
            $verification->setDrivingLicenceNumber($formData['drivingLicenceNumber']);
            $verification->setDrivingLicenceCountry($formData['drivingLicenceCountry']);
            $verification->setPassportNumber($formData['passportNumber']);
            $verification->setPassportNationality($formData['passportNationality']);
            $verification->setCreatedBy($user->getId());
            $em->persist($verification);
            $em->flush();
            $disclosure = $this->get('app.disclosures');
            $result = $disclosure->verifyApplication($verification->getDataForSubmission($em, $this->getParameter('disclosure_position'), $this->getParameter('disclosure_product'), $user));

            if(is_null($result)){
                $dbs->setHireablStatus('Completed');
                $statusResult = $disclosure->getApplicationStatus($dbs->getCode());
                // $dbs->setGbgStatus($statusResult['StatusName']);
				$dbs->setGbgStatus('Awaiting processing');
                $dbs->setStatusDate(new \DateTime('now'));
                $em->persist($dbs);
                $extraChecks = $em->getRepository('AppBundle:ApplicantDisclosures')->getExtraCheck($dbs->getApplicantId(), $dbs->getJobId());

                foreach ($extraChecks as $ec){
                    /**
                     * @var $ec ExtraChecks
                     */
                    $e = $em->getRepository('AppBundle:ExtraChecks')->find($ec['id']);
                    $e->setStatus($dbs->getGbgStatus());
                    $em->persist($e);
                }

                $em->flush();
                return $this->render('@App/dbs/verify.success.html.twig', []);
            }
        }

        return $this->render('@App/dbs/verify.html.twig', [
            'form' => $form->createView(),
            'errors' => $result,
        ]);
    }
}
