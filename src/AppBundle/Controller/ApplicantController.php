<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApplicantRating;
use AppBundle\Entity\Employers;
use AppBundle\Entity\Jobs;
use AppBundle\Entity\Watch;
use AppBundle\Form\ApplicantViewDateFilters;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\UsersJob;
use AppBundle\Entity\ApplicantShare;
use AppBundle\Entity\Users;
use AppBundle\Form\ApplicantDelete;
use AppBundle\Form\ApplicantVerifyDelete;


class ApplicantController extends Controller
{
    /**
     * @Route("/applicant/send", name="admin_applicant_send")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/applicant/share", name="applicant_share")

     */
    public function shareAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $jobId = $request->request->get('jobId');
        $applicantId = $request->request->get('userId');
        $applicant = $em->getRepository('users')->find($applicantId);

        $emailAddresses =  $request->request->get('sharedEmailAddresses');
        $employeeId =  $request->request->get('employeeId');

        $applicantExists = $em->getRepository('AppBundle:UsersJob')->findBy(array('jobId'=>$jobId,'userId'=>$applicantId));
        $whiteLabel=$this->get('app.whitelabel');
        $path = $whiteLabel->getHost();
        $client = $whiteLabel->getWhiteLabel()->getCompanyName();

        $emailFrom = $whiteLabel->getWhiteLabel()->getEmailFrom();
        if(is_null($emailFrom)){
            $emailFrom = 'sales@koine.com';
        }


        if ($applicantExists >=1){
            $emailArray = explode(',',$emailAddresses);
            foreach ($emailArray as $ea){
                $email = trim($ea);
                $shareExists = $em->getRepository('AppBundle:ApplicantShare')->findOneBy(array('applicantId'=>$applicantId, 'email'=>trim($email), 'employerId'=>$employeeId, 'jobId'=>$jobId));
                if (is_null($shareExists)) {
                    $uniqueId = $em->getRepository('AppBundle:ApplicantShare')->addNewShare($applicantId, $email, $employeeId, $jobId);
                    $url='https://'.$path.'/applicant/applicantShareRating/' . $uniqueId;

                    $message = \Swift_Message::newInstance()
                        ->setSubject('View Shared Applicant')
                        ->setFrom($emailFrom)
                        ->setTo($email)
                        ->setBody($this->renderView('@App/Emails/applicant.bulkshare.html.twig', [
                            'urls' => [$url],
                            'client' => $client,
                        ]),'text/html' );
                    $this->get('mailer')->send($message);
                }else{
                    return new Response('A link has already been sent to '.$email);
                }
            }
        }
        return new Response('Emails Sent.');
    }

    /**
     * @Route("/applicant/bulkshare", name="applicant_share_bulk")

     */
    public function bulkShareAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $applicants = json_decode($request->request->get('applicants'),true);
        $emails = $request->request->get('emails');
        $emailArray = explode(',',$emails);

        foreach($emailArray as $email){
            $email = trim($email);
            $urls = [];
            $whiteLabel = $this->get('app.whitelabel');
            $path = $whiteLabel->getHost();
            $client = $whiteLabel->getWhiteLabel()->getCompanyName();
            $emailFrom = $whiteLabel->getWhiteLabel()->getEmailFrom();
            if (is_null($emailFrom)) {
                $emailFrom = 'sales@koine.com';
            }


            foreach($applicants as $d) {
                $jobId = $d['jobId'];
                $applicantId = $d['userId'];
                $employerId = $d['employerId'];

                $applicantExists = $em->getRepository('AppBundle:UsersJob')->findOneBy(array('jobId' => $jobId, 'userId' => $applicantId));
                $shareExists = $em->getRepository('AppBundle:ApplicantShare')->findOneBy(array('applicantId' => $applicantId, 'email' => $email, 'employerId' => $employerId, 'jobId' => $jobId));
                if (is_null($shareExists) && !is_null($applicantExists)) {
                    $uniqueId = $em->getRepository('AppBundle:ApplicantShare')->addNewShare($applicantId, $email, $employerId, $jobId);

                    $urls[] = 'https://' . $path . '/applicant/applicantShareRating/' . $uniqueId;
                }
            }

            if(count($urls) >= 1){
                $message = \Swift_Message::newInstance()
                    ->setSubject('View Shared Applicant')
                    ->setFrom($emailFrom)
                    ->setTo($email)
                    ->setBody($this->renderView('@App/Emails/applicant.bulkshare.html.twig', [
                        'urls' => $urls,
                        'client' => $client,
                    ]),'text/html' );

                $this->get('mailer')->send($message);
            }
        }
        return new Response('Emails Sent');

    }




    /**
     * @Route("/applicant/applicantShareRating/{code}", name="applicant_share_rating")

     */
    public function applicantShareRatingAction(Request $request, $code)
    {
        $em = $this->getDoctrine()->getManager();

        $applicantShare = $em->getRepository('AppBundle:ApplicantShare')->findOneBy(['uniqueId'=>$code]);
        if (is_null($applicantShare)){
            return $this->render('@App/applicant/error.html.twig', [
            ]);
        }
        $checkablProgress = NULL;
        $testablProgress = NULL;
        $personablProgress = NULL;
        $message ='';

        $user = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$applicantShare->getApplicantId()]);
        $employmentHistory = $em->getRepository('AppBundle:HistoryEmployment')->findBy(array('userId'=>$applicantShare->getApplicantId()));
        $educationHistory = $em->getRepository('AppBundle:HistoryEducation')->findBy(array('userId'=>$applicantShare->getApplicantId()));
        $classamrkercompleted = $em->getRepository('AppBundle:ClassmarkerLinks')->completedTests($applicantShare->getJobId(),$applicantShare->getApplicantId() );
        $excelcompleted = $em->getRepository('AppBundle:ExcelTestResults')->completedExcelResults($applicantShare->getJobId(),$applicantShare->getApplicantId() );
        $employer = $em->getRepository('AppBundle:Employers')->find($applicantShare->getEmployerId());
        $job =$em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$applicantShare->getJobId()]);
        $ratingExists = $em->getRepository('AppBundle:ApplicantRating')->findOneBy(['uniqueId'=>$code]);
        if(!is_null($ratingExists)){
            $rating = $ratingExists->getRating();
        }else{
            $rating = NULL;
        }
        $form = $this->createForm('AppBundle\Form\ApplicantShareRating');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $submitedRating = $form->getData();
            $shareDeatils = $em->getRepository('AppBundle:ApplicantShare')->findOneBy(['uniqueId'=>$code]);
            if (is_null($ratingExists)){
                $rating = new ApplicantRating();
                $rating->setRating($submitedRating["rating"]);
                $rating->setNotes($submitedRating["notes"]);
                $rating->setUniqueId($code);
                $rating->setJobId($shareDeatils->getJobId());
                $rating->setApplicantId($shareDeatils->getApplicantId());
                $rating->setEmployerId($shareDeatils->getEmployerId());
                $em->persist($rating);
                $em->flush();
                $message = 'Rating has been applied.';
            }
            $rating = $submitedRating["rating"];
        }

        $progress = $this->get('app.progress');
        $preScreen = $em->getRepository('AppBundle:PreScreen')->getPreScreenStatus($applicantShare->getApplicantId(), $job->getUniqueid());
		$preScreenScore = $em->getRepository('AppBundle:PreScreen')->getPreScreenScore($applicantShare->getApplicantId(), $job->getUniqueid());
		$res = $progress->getCheckablProgressNew($job->getUniqueid(), $applicantShare->getApplicantId());
        $checkablProgress = $res['percentdone'];
        $res = $progress->getTestablProgressNew($job->getUniqueid(), $applicantShare->getApplicantId());
        $testablProgress = $res['percentdone'];
        $res = $progress->getPersonablProgressNew($job->getUniqueid(), $applicantShare->getApplicantId());
        $personablProgress = $res['percentdone'];
        //$activeQ = $em->getRepository('AppBundle:VideoQuestions')->getActiveQuestionsByUser($applicantShare->getJobId(),$applicantShare->getApplicantId());
        $activeQ = null;
        return $this->render('@App/applicant/applicantShareRating.html.twig', [
            'checkablProgress'=>$checkablProgress,
            'testablProgress'=>$testablProgress,
            'personablProgress'=>$personablProgress,
            'user'=>$user,
            'camertagAppId' => $employer->getCameratagAppId(),
            'form' => $form->createView(),
            'employmentHistory'=>$employmentHistory,
            'educationHistory'=>$educationHistory,
            'classamrkercompleted'=>$classamrkercompleted,
            'excelcompleted'=>$excelcompleted,
            'videos' => $activeQ,
            'job' => $job,
            'message'=>$message,
            'rating'=>$rating,
            'preScreen' => $preScreen,
            'preScreenScore' => $preScreenScore,
        ]);
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/sharedapplicants", name="shared_applicants")
     */
    public function sharedApplicantAction(Request $request)
    {
        /**
         * @var $user Users
         */

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $applicationSharesDetails = $em->getRepository('AppBundle:ApplicantShare')->getSharedApplicantsDetails($user->getEmployerId());
        $role ='';

        return $this->render('@App/applicant/sharedApplicants.html.twig', [
            'applicationSharesByEmployerId' => $applicationSharesDetails,
            'openpage' => 'ats_shared'
        ]);
    }


    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/updateRating", name="update_rating")
     */
    public function updateRatingAction (Request $request){
        $em = $this->getDoctrine()->getManager();
        $ratingId = $request->query->get('ratingId');
        $newRating=$request->query->get('newRating');

        $shareRating = $em->getRepository('AppBundle:ApplicantRating')->findOneBy(['id'=>$ratingId]);
        $shareRating->setRating($newRating);
        $em->persist($shareRating);
        $em->flush();
        return $this->json(array('status'=>'ok'));
    }


    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/view/{jobId}", name="applicant_view")
     */
    public function viewAction (Request $request, $jobId = NULL)
    {
		// for this empoyer, get a list of all users and jobs, and process progressNew() for each one
		$em = $this->getDoctrine()->getManager();
		$progress = new \AppBundle\Model\Progress($em,null);
		$pr = null;

		//  This loop is very slow. move individual calls to getXProcessNew() at
		//  the places the data is edited or modified.
		
		$ujs = $em->getRepository('AppBundle:UsersJob')->findAll();
		foreach($ujs as $uj)
		{
			$job_code = $uj->getJobId();
			$user_id = $uj->getUserId();
//			$progress->getCheckablProgressNew($job_code, $user_id);
			$progress->getPersonablProgressNew($job_code, $user_id);
			$progress->getTestablProgressNew($job_code, $user_id);
			$key = $job_code.'--'.$user_id;
			/*if($uj->getTestablCompleted()==0){
			    $pr[$key]['Ntestabl_progress'] = 0;
            }else{
			    $pr[$key]['Ntestabl_progress'] = round(($uj->getTestablCompleted()/$uj->getTestablCount())*100);
            }
			if($uj->getPersonablCompleted()==0){
			    $pr[$key]['Npersonabl_progress'] = 0;
            }else{
			    $pr[$key]['Npersonabl_progress'] = round(($uj->getPersonablCompleted()/$uj->getPersonablCount())*100);
            }*/

		}
		
        $show = FALSE;
        $filterFactory = $this->get('app.filter_factory');
        $fromDate2 = new \DateTime( '1 year ago');
        $toDate = new \DateTime('+ 1 year');
        $user=$this->getUser();
        $errorMessage = '';
        $applicantResults = NULL;
        $appMessage='';

        if (!is_null($request->query->get('appmessage'))) {
            if ($request->query->get('appmessage')=='appaccepted'){
                $appMessage = 'The applicant has been accepted and a message has been sent';
            }
            if ($request->query->get('appmessage')=='apprejected'){
                $appMessage = 'The applicant has been rejected and a message has been sent';
            }
        }

        $applicantViewDateForm = $filterFactory->getDateRangeForm($fromDate2, $toDate, 'To Date:', 'From Date:', 'Apply Filters');

        $applicantViewDateForm->handleRequest($request);

        $searchTerm = $request->query->get('applicantSearch');
        if (empty($searchTerm)){
            $searchTerm = null;
        }

        $filterFactory->setFromDate($fromDate2);
        $filterFactory->setToDate($toDate);
        if (!is_null($jobId)){
            $show=TRUE;
        }
        if ($request->query->get('choices_filter')['jobList'] !=''){
            $joblistData = $request->query->get('choices_filter');
            $filterFactory->setJobId($joblistData['jobList']);
        }else{
            $filterFactory->setJobId($jobId);
        }

        $filterFactory->setUpInitialData($searchTerm);

        $jobListForm = $filterFactory->getJobDropDownForm();
        $checkablForm = $filterFactory->getCheckablDropDownForm();
        $testablForm = $filterFactory->getTestablDropDownForm();
        $personablForm = $filterFactory->getPersonablDropDownForm();
        $idCheckForm = $filterFactory->getIdCheckDropDownForm();
        $dbsForm = $filterFactory->getDbsDropDownForm();
        $qualificationsForm = $filterFactory->getQualificationssDropDownForm();
        $refForm = $filterFactory->getRefDropDownForm();
        $interviewForm = $filterFactory->getInterviewDropDownForm();
        $preScreenForm = $filterFactory->getPreScreenDropDownForm();
        $applicantStatusForm = $filterFactory->getApplicantStatusForm();
        $watchStatusForm = $filterFactory->getWatchStatusForm();
        $avgRatingForm = $filterFactory->getAvgRatingForm($user);

        if ($applicantViewDateForm->isSubmitted() && $applicantViewDateForm->isValid()) {
            $show = TRUE;
            $message='';
            $formData = $applicantViewDateForm->getData();


            $toDate = $formData["toDate"]->format('Y-m-d 23:59:59');
            $toDate = new \DateTime($toDate);
            $filterFactory->setFromDate($formData["fromDate"]);
            $filterFactory->setToDate($toDate);

            /*if (!is_null($request->query->get('choices_filter'))) {
                $jobListForm->submit($request->query->get('choices_filter'));
            }*/
            if ($jobListForm->isSubmitted() && $jobListForm->isValid()) {
                $joblistData = $jobListForm->getData();
                $show = TRUE;
                $filterFactory->setJobId($joblistData['jobList']);
            }
            /*
            if (!is_null($request->query->get('choices_filter'))) {
                $checkablForm->submit($request->query->get('choices_filter'));
            }
            if ($checkablForm->isSubmitted() && $checkablForm->isValid()) {
                $checkablData = $checkablForm->getData();
                if (!is_null($checkablData['checkabl'])) {
                    $checkablRange = explode(',', $checkablData['checkabl']);
                    $filterFactory->setCheckablLower($checkablRange[0]);
                    $filterFactory->setCheckablUpper($checkablRange[1]);
                    $show = TRUE;
                }
            }

            if (!is_null($request->query->get('choices_filter'))) {
                $testablForm->submit($request->query->get('choices_filter'));
            }
            if ($testablForm->isSubmitted() && $testablForm->isValid()) {
                $testablData = $testablForm->getData();

                if (!is_null($testablData['testabl'])) {
                    $testRange = explode(',', $testablData['testabl']);
                    $filterFactory->setTestablLower($testRange[0]);
                    $filterFactory->setTestablUpper($testRange[1]);
                    $show = TRUE;
                }
            }

            if (!is_null($request->query->get('choices_filter'))) {
                $personablForm->submit($request->query->get('choices_filter'));
            }
            if ($personablForm->isSubmitted() && $personablForm->isValid()) {
                $personablData = $personablForm->getData();
                if (!is_null($personablData['personabl'])) {
                    $personRange = explode(',', $personablData['personabl']);
                    $filterFactory->setPersonablLower($personRange[0]);
                    $filterFactory->setPersonablUpper($personRange[1]);
                    $show = TRUE;
                }
            }

            if (!is_null($request->query->get('choices_filter'))) {
                $idCheckForm->submit($request->query->get('choices_filter'));
            }
            if ($idCheckForm->isSubmitted() && $idCheckForm->isValid()) {
                $idCheckData = $idCheckForm->getData();
                $show = TRUE;
                $filterFactory->setIdCheck($idCheckData['idCheck']);
            }

            if (!is_null($request->query->get('choices_filter'))) {
                $dbsForm->submit($request->query->get('choices_filter'));
            }
            if ($dbsForm->isSubmitted() && $dbsForm->isValid()) {
                $dbsData = $dbsForm->getData();
                $show = TRUE;
                $filterFactory->setIdCheck($dbsData['dbs']);
            }

            if (!is_null($request->query->get('choices_filter'))) {
                $qualificationsForm->submit($request->query->get('choices_filter'));
            }
            if ($qualificationsForm->isSubmitted() && $qualificationsForm->isValid()) {
                $qualificationsData = $qualificationsForm->getData();
                $show = TRUE;

                $filterFactory->setQualifications($qualificationsData['qualifications']);
            }

            if (!is_null($request->query->get('choices_filter'))) {
                $refForm->submit($request->query->get('choices_filter'));
            }
            if ($refForm->isSubmitted() && $refForm->isValid()) {
                $refData = $refForm->getData();
                $show = TRUE;
                $filterFactory->setRef($refData['ref']);
            }

            if (!is_null($request->query->get('choices_filter'))) {
                $interviewForm->submit($request->query->get('choices_filter'));
            }
            if ($interviewForm->isSubmitted() && $interviewForm->isValid()) {
                $interviewData = $interviewForm->getData();
                $show = TRUE;
                $filterFactory->setInterview($interviewData['interview']);
            }
            if (!is_null($request->query->get('choices_filter'))) {
                $applicantStatusForm->submit($request->query->get('choices_filter'));
            }
            if ($applicantStatusForm->isSubmitted() && $applicantStatusForm->isValid()) {
                $applicantStatus = $applicantStatusForm->getData();
                $show = TRUE;
                $filterFactory->setApplicantStatus($applicantStatus['applicantStatus']);
            }


            if (!is_null($request->query->get('choices_filter'))) {
                $watchStatusForm->submit($request->query->get('choices_filter'));
            }
            if ($watchStatusForm->isSubmitted() && $watchStatusForm->isValid()) {
                $watchtStatus = $watchStatusForm->getData();
                $show = TRUE;
                $filterFactory->setWatchStatus($watchtStatus ["watchStatus"]);
            }

            if (!is_null($request->query->get('choices_filter'))) {
                $avgRatingForm->submit($request->query->get('choices_filter'));
            }

            if ($avgRatingForm->isSubmitted() && $avgRatingForm->isValid()) {
                $ratingStatus = $avgRatingForm->getData();
                $show = TRUE;
                $filterFactory->setAvgRating($ratingStatus ["avgRating"]);
            }*/
        }


        $data = $filterFactory->getData($searchTerm);

		foreach($data as $idx=>$d)
		{
			$key = $d['job_unique_id'] . '--' . $d['applicant_id'];
			$data[$idx]['Npersonabl_progress'] = $pr[$key]['Npersonabl_progress'];
			$data[$idx]['Ntestabl_progress'] = $pr[$key]['Ntestabl_progress'];
		}
		
		foreach($data as $idx=>$d)
		{
			if($d['title']<>'fancy job') continue;
//			$data[$idx]['photo_checks']=1;
//			$data[$idx]['photo_percent']=83;
			break;
		}

        return $this->render('@App/applicant/view.html.twig', [
            'data'=>$data,
            'applicantViewDateForm' => $applicantViewDateForm->createView(),
            'jobList' => $jobListForm->createView(),
            'checkablForm'=>$checkablForm->createView(),
            'testablForm'=>$testablForm->createView(),
            'personablForm'=>$personablForm->createView(),
            'idCheckForm'=>$idCheckForm->createView(),
            'dbsForm'=>$dbsForm->createView(),
            'qualificationsForm'=>$qualificationsForm->createView(),
            'refForm'=>$refForm->createView(),
            'interviewForm'=>$interviewForm->createView(),
            'preScreenForm'=>$preScreenForm->createView(),
            'show'=>$show,
            'errorMessage'=>$errorMessage,
            'searchTerm'=>$searchTerm,
            'applicantStatusForm'=>$applicantStatusForm->createView(),
            'appMessage'=>$appMessage,
            'watchStatusForm'=>$watchStatusForm->createView(),
            'avgRatingForm'=>$avgRatingForm->createView(),
            'openpage' => 'ats_view',
			'pr' => $pr,
        ]);
    }

	
	/**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/delete", name="applicant_delete")
     */
    public function deleteAction(Request $request)
    {
		$form = $this->createForm(ApplicantDelete::class);
        $error = null;
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$data = $form->getData();
			$error = null;
			
			// Verify the email address is for a current applicant
			if($form->isSubmitted() && $form->isValid())
			{
				$error = 1;
				$user = $this->getDoctrine()->getEntityManager()->getRepository('AppBundle\Entity\Users')->findOneBy(array('emailaddress' => $data['email']));
				if($user)
				{
					$applicant_id = $user->getId();
					if($applicant_id)
					{
						return $this->redirect("/applicant/verifydelete/{$applicant_id}");
					}
				}
			}
		}

		$data = ''; // $request->getData();
		return $this->render('@App/applicant/delete.html.twig', [
			'form'	=> $form->createView(),
			'data'	=> $data,
			'error'	=> $error,
		]);
	}
	

	/**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/verifydelete/{id}", name="applicant_verifydelete")
     */
    public function verifydeleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
		//$id = $request->get('id');
		$form = $this->createForm(ApplicantVerifyDelete::class); 
		$form->handleRequest($request);

		$applicant = $em->getRepository('AppBundle:Users')->find($id);
        $openJobs = $em->getRepository('AppBundle:UsersJob')->findBy(['offered'=>NULL]);
        $applicantJobs = $em->getRepository('AppBundle:UsersJob')->findAll();
		// If the form was POSTed, validate and process it
		if ($form->isSubmitted() && $form->isValid())
		{
			$data = $form->getData();

			// Verify the email address is for a current applicant
			if(strtoupper($data['confirm'])=='YES')
			{
               // dump($data, $id);exit;


				// delete the user
				return $this->redirect("/applicant/deleteverified");
			}
			else
			{
				return $this->redirect("/applicant/deletefailed");
			}
		}
		
		$data = ''; //$request->getData();
		return $this->render('@App/applicant/verifydelete.html.twig', [
			'form'	=> $form->createView(),
			'id' => $id,
			'data'	=> $data,
            'applicant' => $applicant,
            'openJobs'=>$openJobs,
            'applicantJojbs'=>$applicantJobs,
		]);

	}


	/**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/deleteverified", name="applicant_deleteverified")
     */
    public function deleteverifiedAction()
    {
		return $this->render('@App/applicant/deleteverified.html.twig');
	}

	/**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/deletefailed", name="applicant_deletefailed")
     */
    public function deletefailedAction()
    {
		return $this->render('@App/applicant/deletefailed.html.twig');
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


    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/sharemodalview", name="share_modal_view")
     */

    public function sharemodalviewAction (Request $request)
    {
        $jobid = $request->query->get('jobid');
        $userId = $request->query->get('userId');
        $employeeId = $request->query->get('employeeId');

        $title='Share Applicant';
        $body='
            
            <form action="" method="post" id="shareApplianctForm">
                <input type="hidden" value="'.$userId.'" name="userId" id="sharedUserId"/>
                <input type="hidden" value="'.$jobid.'" name="jobId" id="sharedJobId"/>
                <input type="hidden" value="'.$employeeId.'" name="employeeId" id="employeeId"/>
                <p>Please enter the email address(es) of those you wish to share this applicant with – if you wish to send to multiple recipients, please separate them with a comma ("e.g jon.smith@abc.com, jane.jones@abc.com"),</p>
                <br />
                <div class="form-group">
                    <input title="shared email addresses" type="text" value="" id="" class="form-control" name="sharedEmailAddresses" placeholder="jon.smith@abc.com, jane.jones@abc.com"/>
                </div>
                <div class=" text-center">
                    <input title="email address submit" type="submit" name="emailSubmit" value="Send" class="shareButton btn btn-default"/>
                </div>
                <div class="shareModalSpinner text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>
                
            </form>
           
        ';

        return $this->json(array('title'=>$title, 'body'=>$body));

    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/reject", name="reject_applicant_with_email")
     */

    public function rejectAction (Request $request)
    {
        /**
         * @var $user Users
         */

        $mailer = $this->get('mailer');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $ujRepo = $em->getRepository('AppBundle:UsersJob');
        $data = json_decode($request->getContent(),true);

        foreach($data as $d){

            $applicant = $em->getRepository('AppBundle:Users')->find($d['userId']);
            $job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $d['jobId']]);
            $employer = $em->getRepository('AppBundle:Employers')->find($job->getEmployerId());
			$css = $em->getRepository('AppBundle:CssSchemes')->getEmployerFromDomain();
			$companyname = $css->getCompanyName();
		
            $userJob = $ujRepo->findOneBy(['userId' => $d['userId'], 'jobId' => $d['jobId']]);
            $userJob->setRejected(1);
            $userJob->setRejectedOn(new \DateTime('now'));
            $userJob->setAccepted(0);
            $userJob->setAcceptedOn(null);
            $userJob->setLastModified(new \DateTime('now'));
            $em->persist($userJob);

            if($d['toEmail'] === true )
			{
				$se = new \AppBundle\Model\SendEmail($this->get('twig'), $this->get('mailer'), $this->getDoctrine()->getManager());
				$ret = $se->send('', $applicant->getEmailaddress(), $applicant->getId(), 'Your application for the role of '.$job->getTitle().' has been rejected', "applicant.reject", 
					array('candidate' => $applicant->getName(),
                        'message' => $d['message'],
                        'title' => $job->getTitle(),
						'companyname' => $companyname,
					)
				);
				if($ret<>1) {
					// TODO: display error about email not sent
					die("System error - Email could not be sent");
				}
			}
        }
        $em->flush();
        echo 'ok';
        $this->addFlash('notice', 'The applicants have been rejected');
        exit;
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/accept", name="accept_applicant_with_email")
     */

    public function acceptAction (Request $request)
    {
        /**
         * @var $user Users
         */
        $mailer = $this->get('mailer');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $ujRepo = $em->getRepository('AppBundle:UsersJob');
        $data = json_decode($request->getContent(),true);

        foreach($data as $d){

            $applicant = $em->getRepository('AppBundle:Users')->find($d['userId']);
            $job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $d['jobId']]);
            //$employer = $em->getRepository('AppBundle:Employers')->find($job->getEmployerId());
			$css = $em->getRepository('AppBundle:CssSchemes')->getEmployerFromDomain();
			$companyname = $css->getCompanyName();

            $userJob = $ujRepo->findOneBy(['userId' => $d['userId'], 'jobId' => $d['jobId']]);
            $userJob->setAccepted(1);
            $userJob->setAcceptedOn(new \DateTime('now'));
            $userJob->setRejected(0);
            $userJob->setRejectedOn(null);
            $userJob->setLastModified(new \DateTime('now'));
            $em->persist($userJob);

            if($d['toEmail'] === true )
			{
				$se = new \AppBundle\Model\SendEmail($this->get('twig'), $this->get('mailer'), $this->getDoctrine()->getManager());
				$ret = $se->send('', $applicant->getEmailaddress(), $applicant->getId(), 'Your application for the role of '.$job->getTitle().' has been accepted', "applicant.accept", 
					array('candidate' => $applicant->getName(),
                        'message' => $d['message'],
                        'title' => $job->getTitle(),
						'companyname' => $companyname,
					)
				);
				if($ret<>1) {
					// TODO: display error about email not sent
					die("System error - Email could not be sent");
				}
            }
        }
        $em->flush();
        echo 'ok';
        $this->addFlash('notice', 'The applicants have been accepted');
        exit;
    }





    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/extrachecks", name="extra_checks")
     */

    public function extrachecksAction (Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $jobid = $request->query->get('jobid');
        $userId = $request->query->get('userId');
        $path = $_SERVER['HTTP_HOST'];
        $job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$jobid]);
        $idCheck = $em->getRepository('AppBundle:IdChecks')->findOneBy(['userId'=>$userId, 'jobId'=>$jobid]);
        $dbsCheck = $em->getRepository('AppBundle:ApplicantDisclosures')->findOneBy(['applicant_id'=>$userId, 'job_id'=>$jobid]);
        $qualificationCheck = $em->getRepository('AppBundle:QualificationChecks')->findOneBy(['jobId'=>$job->getId(), 'userId'=>$userId]);
        $title='Extra Checks';
        $body='
            <form  method="post" action="" id="extraChecksForm">
                <div class="modal-body extraChecksWrapper">
                    <div  class="form-group">
                        <input type="hidden" class="extraCheckApplicantId" name="user_id" value="'.$userId.'" />
                        <input type="hidden" class="extraCheckJobId" name="job_id" value="'.$jobid.'" />';

        if (!is_null($idCheck)){
            $body .= '
                                <div class="row">
                                    Document and ID Check Link: '.$idCheck->getShortUrl().'
                                </div>';
        } else {
            $body .= ' 
                                <div class="checkbox">
                                    <label><input type="checkbox" class="idExtraCheck" name="idCheck" value="1"> Document and ID Check.</label><br />
                                </div>';
        };

        if (!is_null($qualificationCheck)){
            $body .= '
                                <div class="row">
                                    Qualification Check Link: '.$qualificationCheck->getShortUrl().'
                                </div>';

        } else {
            $body .= '
                                <div class="checkbox">
                                    <label><input type="checkbox" class="qualExtraCheck" name="qualCheck" value="1"> Qualifications Checks.</label><br />
                                </div>';
        };

        if (!is_null($dbsCheck)){
            $body .= '
                               <div class="row">
                                    DBS Check Link: '.$dbsCheck->getShortUrl().'
                               </div>';
        } else {
            $body .= '   
                                <div class="checkbox">
                                    <label><input type="checkbox" class="dbsExtraCheck" name="dbsCheck" value="1"> DBS Basic.</label><br />
                                </div>';
        };
        $body .='
                    </div>
                </div>
                <div class="modal-footer">
                        <input type="submit" class="extraChecksSubmit  btn btn-black btn-primary" value="Send Links"/>
                    <button type="button" class="btn " data-dismiss="modal">Close</button>
                </div>
            </form>';
        return $this->json(array('title'=>$title, 'body'=>$body));
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/extracheckssubmit", name="extra_checks_submit")
     */

    public function extracheckssubmitAction (Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $userId = $request->query->get('user_id');
        $jobId = $request->query->get('job_id');
        $id = $request->query->get('idCheck');
        $qual = $request->query->get('qualCheck');
        $dbs = $request->query->get('dbsCheck');
        $gbg_profile = $this->getParameter('gbg_profile');
        $user=$this->getUser();
        $whiteLabel=$this->get('app.whitelabel');
		$director_check = 'PENDING';

        if(isset($userId)){
            $applicant = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$userId]);
            $jobDetails = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$jobId]);

            $qualShortUrl = false;
            $idShortUrl = false;
            $dbsShortUrl = false;

            if(!is_null($id) ){
                $idUniqueCode = $this->createUniqueCode($applicant->getMobiletel());
                $shortUrl = $this->createShortUrl($idUniqueCode, 'idCheck');
                $idShortUrl = $em->getRepository('AppBundle:IdChecks')->saveIdCheck($idUniqueCode, $shortUrl, $userId, $jobId, $jobDetails->getEmployerId(), $gbg_profile);
            }
            if(!is_null($qual)){
                $qualUniqueCode = $this->createUniqueCode($applicant->getMobiletel());
                $shortUrl = $this->createShortUrl($qualUniqueCode, 'qualCheck' );
                $qualShortUrl = $em->getRepository('AppBundle:QualificationChecks')->saveQualificationCheck($qualUniqueCode, $shortUrl, $userId, $jobDetails->getId(), $jobDetails->getEmployerId(), $user->getId() );
            }
            if(!is_null($dbs)){

                $dbsCode = $this->createUniqueCode($userId.$jobId);
                $shortUrl = $this->createShortUrl($dbsCode, 'dbsCheck');
                $dbsShortUrl = $em->getRepository('AppBundle:ApplicantDisclosures')->saveDbsCheck($userId, $jobId, $jobDetails->getEmployerId(), $user->getId(), $shortUrl, $dbsCode);
                $dbsShortUrl = $em->getRepository('AppBundle:ApplicantDisclosures')->saveDbsCheck($userId, $jobId, $jobDetails->getEmployerId(), $user->getId(), $shortUrl, $dbsCode);
            }

            $emailFrom = $whiteLabel->getWhiteLabel()->getEmailFrom();
            if (is_null($emailFrom)) {

                $emailFrom = 'sales@koine.com';
            }
            $sendIdEmail = $this->sendIdEmail($applicant, $jobDetails, $whiteLabel->getWhiteLabel()->getCompanyName(),$idShortUrl, $qualShortUrl, $dbsShortUrl, $emailFrom);
            if ($sendIdEmail != 'Success') {
                $emailMessage[] = 'Email';
            }
            if (!empty($emailMessage)) {
                $errorCount = count($emailMessage);
                if ($errorCount >= 1) {
                    $errorMessages = $emailMessage[0];
                    unset($emailMessage[0]);
                    foreach ($emailMessage as $errors) {
                        $errorMessages .= ' and ' . $errors;
                        $message = 'An error occurred while trying to send the ' . $errorMessages . ' message to the applicant.';
                        return $this->json(array('error'=>$message));
                    }
                } else {
                    $errorMessages = $emailMessage[0];
                    $message = 'An error occurred while trying to send the ' . $errorMessages . ' message to the applicant.';
                    return $this->json(array('error'=>$message));
                }
            }
            return $this->json(array('status'=>'ok'));
        }else{
            return $this->json(array('status'=>'ok'));
        }
    }


    public function sendIdEmail (Users $applicant,Jobs $job,$company, $idUrl, $qualUrl, $dbsUrl, $from)
    {
        $body = 'Thank you for applying for the position of '.$job->getTitle().'<br />';

        if($idUrl){
            $body .=' <br />  You have been requested to complete an online identity check. You will need your passport. Once ready please follow this link '.$idUrl.' to complete the identity checks.<br />';
        }

        if($qualUrl){
            $body .=' <br />  You have been requested to complete a qualifications check. Once ready please follow this link '.$qualUrl.' to complete the identity checks.<br />';
        }

        if($dbsUrl){
            $body .=' <br />  You have been requested to complete a DBS check.  Please login to the site '.$dbsUrl.' and complete the check';
        }
        $body .= '<br />  Thanks '.$company;

        $subject = 'Application for the role of '.$job->getTitle().'.  ';
        $to = $applicant->getEmailaddress();

        $mailer = $this->get('swiftmailer.mailer');
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body);
        $result = $mailer->send($message);
        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->get('swiftmailer.transport.real');
        $spool->flushQueue($transport);
        return $result;
    }

    public function createUniqueCode ($data)
    {
        $code = md5($data.'a random string to make this a salt that just might work.  Who knows I certainly dont'.time());
        return $code;
    }

    public function createShortUrl  ($uniqueCode, $checkType)
    {

        if($checkType == 'idCheck'){
            $path = $_SERVER['HTTP_HOST'];
            $long_url = 'https://'.$path.'/user/idchecks/'.$uniqueCode;
            $short_url = file_get_contents('https://api-ssl.bitly.com/v3/shorten?access_token=f2fbe310594e4e296fd89de2de630143e5db2c48&format=txt&longUrl='.urlencode($long_url));
            return $short_url;

        }
        if($checkType == 'qualCheck'){
            $whiteLabel=$this->get('app.whitelabel');
            $path = $_SERVER['HTTP_HOST'];
            $long_url = 'https://'.$path.'/qualification/institute/'.$uniqueCode;
            $short_url = file_get_contents('https://api-ssl.bitly.com/v3/shorten?access_token=f2fbe310594e4e296fd89de2de630143e5db2c48&format=txt&longUrl='.urlencode($long_url));
            return $short_url;
        }

        if($checkType == 'dbsCheck'){
			$path = $_SERVER['HTTP_HOST'];
			$long_url = 'https://'.$path.'/dbs/apply/'.$uniqueCode;
            $short_url = file_get_contents('https://api-ssl.bitly.com/v3/shorten?access_token=f2fbe310594e4e296fd89de2de630143e5db2c48&format=txt&longUrl='.urlencode($long_url));
            return $short_url;
        }

    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/acceptapplicant", name="accept_applicant")
     */
    public function acceptapplicant (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $jobid = $request->query->get('jobid');
        $userId = $request->query->get('userId');
        $path = 'https://'.$_SERVER['HTTP_HOST'];
        $title='Accept Applicant';
        $body= '
        <form method="post" action="" id="acceptApplicantForm">
            <div class="modal-body">
                <div>
                    <P>This will Accept the applicant.</P> 
                    <p>If you do not want to accept the applicant, please <a href="#" data-dismiss="modal">CANCEL</a>.</P> 
                    <div class="form-group">
                        <textarea title="message" name="message" id="location" data-validation="required" placeholder="Message for applicant" class="acceptMessage form-control form-control-small"></textarea>
                    </div>
                    <input class="acceptApplicantUserId" type="hidden" name="user_id" value="'.$userId.'" />
                    <input class="acceptApplicantJobId" type="hidden" name="job_id" value="'.$jobid.'" />
                    <div class="checkbox">
                        <label><input id="bulkAcceptsendEmail" type="checkbox" checked="checked" name="email" value="1"> Send applicant acceptance email.</label>
                    </div>
                </div>
                <div class=" text-center"><input type="submit" class="acceptApplicantSubmit btn btn-black btn-primary" value="Continue"/> </div>
                <div class="acceptModalSpinner text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>
              
               
            </div>
        </form>
        ';

        return $this->json(array('title'=>$title, 'body'=>$body));
    }

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicant/rejectapplicant", name="reject_applicant")
     */

    public function rejectapplicantAction (Request $request)
    {

        $jobid = $request->query->get('jobid');
        $userId = $request->query->get('userId');

        $title='Reject Applicant';
        $body='
           <form method="post" action="" id="RejectApplicantForm">
               
                    <div>
                        <P>This will reject the applicant.</P> 
                        <p>If you do not want to reject the applicant, please <a href="#" data-dismiss="modal" >CANCEL</a>.</P> 
                        <div class="form-group">
                            <textarea title="message" name="message" id="location" data-validation="required" placeholder="Message for applicant" class="rejectMessage form-control form-control-small"></textarea>
                        </div>
                        <input class="rejectApplicantUserId" type="hidden" name="user_id" value="'.$userId.'" />
                        <input class="rejectApplicantJobId" type="hidden" name="job_id" value="'.$jobid.'" />
                        <div class="checkbox"> 
                            <label><input type="checkbox" id="bulkRejectsendEmail" checked="checked" name="email" value="1"> Send applicant rejection email.</label>
                        </div>
                    </div>
           
              
                     <div class=" text-center"><input type="submit" class=" rejectApplicantSubmit btn btn-black btn-primary" name="rejectApplicant"value="Continue"  /> </div>
                     <div class="rejectModalSpinner text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>
              
            </form>
           
        ';
        return $this->json(array('title'=>$title, 'body'=>$body));
    }


    /**
     * @Route("/applicant/details/{applicantId}/{jobUniqueId}", name="applicant_view_details")
     * @Security("has_role('ROLE_CLIENT')")
     */
    public function detailsAction(Request $request,$applicantId, $jobUniqueId)
    {
        $appMessage='';
		$em = $this->getDoctrine()->getManager();
		$progress = new \AppBundle\Model\Progress($em,null);
        $formFactory = $this->get('app.form_factory');
        $em = $this->getDoctrine()->getManager();
        $applicantDetails = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$applicantId]);

        if (is_null($applicantDetails)){
			return $this->render('@App/error/error.html.twig', array(
				'title' => 'Invalid URL',
				'msg' => 'The URL which you are trying to access is invalid (002)'
			));
        }

        if (!is_null($request->query->get('appmessage'))) {
            if ($request->query->get('appmessage')=='appaccepted'){
                $appMessage = 'The applicant has been accepted and a message has been sent';
            }
            if ($request->query->get('appmessage')=='apprejected'){
                $appMessage = 'The applicant has been rejected and a message has been sent';
            }
        }
        $checkablProgress = NULL;
        $testablProgress = NULL;
        $personablProgress = NULL;
        $sectionJobs = $em->getRepository('AppBundle:SectionJobs')->findOneBy(['jobId'=>$jobUniqueId]);
        $user = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$applicantId]);
        $employmentHistory = $em->getRepository('AppBundle:HistoryEmployment')->findBy(array('userId'=>$applicantId, 'jobId'=>$jobUniqueId));
        $educationHistory = $em->getRepository('AppBundle:HistoryEducation')->findBy(array('userId'=>$applicantId, 'jobId'=>$jobUniqueId));

		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$jobUniqueId]);
		if(empty($job)) {
			return $this->render('@App/error/error.html.twig', array(
				'title' => 'Invalid URL',
				'msg' => 'The URL which you are trying to access is invalid (003)'
			));
		}
		
		//$testsCompleted = $em->getRepository('AppBundle:FormCompleted')->findBy(array('userId'=>$applicantId, 'jobId'=>$jobUniqueId));
		$testsCompleted = $em->createQuery(
			"SELECT fc.score, fc.maxScore, fc.passScore, f.formName
			FROM AppBundle:FormCompleted fc
			LEFT JOIN AppBundle:Forms f WITH fc.formId = f.id
			WHERE fc.userId=:uid AND f.formType='TEST' ")
			->setParameters(array('uid'=>$applicantId))
			->getResult();
		
		$employer = $em->getRepository('AppBundle:Employers')->find($job->getEmployerId());
        $applicantShare = new ApplicantShare;
        $applicantShare->setJobId($jobUniqueId);
        $applicantShare->setEmployerId($employer->getId());
        $applicantShare->setApplicantId($applicantId);

		$res = $progress->getCheckablProgressNew($jobUniqueId, $applicantId);
		$checkablProgress = $res['percentdone'];

		$res = $progress->getTestablProgressNew($jobUniqueId, $applicantId);
		$testablProgress = $res['percentdone'];

		$res = $progress->getPersonablProgressNew($jobUniqueId, $applicantId);
		$personablProgress = $res['percentdone'];

		$idCheckStatus = $em->getRepository('AppBundle:IdChecks')->getIdCheckStatusByUser($applicantId, $jobUniqueId);
        $disclosures = $em->getRepository('AppBundle:ApplicantDisclosures')->getDisclosuresByUser($applicantId, $jobUniqueId);
        $qualificationChecks = $em->getRepository('AppBundle:QualificationChecks')->getQualStatusByUser($applicantId, $jobUniqueId);
        $references = $em->getRepository('AppBundle:Reference')->getReferenceStatusByUser($applicantId, $jobUniqueId);
        $interview = $em->getRepository('AppBundle:Interviews')->findOneBy(['userId' => $applicantId, 'jobId'=>$jobUniqueId],['id' => 'desc']);



        $preScreen = $em->getRepository('AppBundle:PreScreen')->getPreScreenStatus($applicantId, $jobUniqueId);
		$psScore = $em->getRepository('AppBundle:PreScreen')->getPreScreenScore($applicantId, $jobUniqueId);
        $preScreenScore = $psScore[0]['percentage'];
        $psFormId = $psScore[0]['formId'];

		$preScreenFormId = $em->getRepository('AppBundle:PreScreen')->getPreScreenFormId($jobUniqueId);
		$visualid_pass = $em->getRepository('AppBundle:Media')->getMediaFilename('PHOTO', $applicantId, $jobUniqueId, 'PASSPORT', 1);
		$visualid_driv = $em->getRepository('AppBundle:Media')->getMediaFilename('PHOTO', $applicantId, $jobUniqueId, 'DRIVING', 1);
		$visualid_webcam = $em->getRepository('AppBundle:Media')->getMediaFilename('PHOTO', $applicantId, $jobUniqueId, 'VISUALID', 1);
		$testabl1 = '';
		$testabl2 = '';
						
		if (is_null($interview)){
            $interviewStatus = 'Not Requested';
        }else{
            $interviewStatus = 'Requested';
        }


        $cv = $em->getRepository('AppBundle:Cv')->findOneBy(['userId'=>$applicantId]);

        $userJob = $em->getRepository('AppBundle:UsersJob')->findOneBy(['jobId'=>$jobUniqueId, 'userId'=>$applicantId]);
        //$activeQ = $em->getRepository('AppBundle:VideoQuestions')->getActiveQuestionsByUser($jobUniqueId,$applicantId);
        $activeQ = null;
        $rating = $em->getRepository('AppBundle:ApplicantShare')->getSharedApplicantsRatingsAndNotes ($applicantId, $jobUniqueId,$job->getEmployerId());

        if (!empty($rating)) {
            $ratingAvg = $rating['rating']["avgRating"];
        }else{
            $ratingAvg = NULL;
        }

        $watch = $em->getRepository('AppBundle:Watch')->findOneBy(['applicant' => $applicantDetails, 'job' => $job, 'employer' => $employer]);
        $emailCheck = 'Awaiting Candidate';
        $ec = $em->getRepository('AppBundle\Entity\EmailVerification')->findOneBy(['email' => $user->getEmailaddress(), 'confirmed'=>1]);
        if (!is_null($ec)){
            if ($ec->getConfirmed()===true)
            $emailCheck = 'Confirmed';
        }
        $smsCheck = 'Awaiting Candidate';
        $sc = $em->getRepository('AppBundle\Entity\SmsVerification')->findOneBy(['mobile' => $user->getMobiletel(), 'confirmed'=>1]);
        if (!is_null($sc)){
            if ($sc->getConfirmed()===true)
                $smsCheck = 'Confirmed';
        }

        $kycStatus = $em->getRepository('AppBundle:IdChecks')->getKycCheckStatusByUser( $applicantDetails, $job->getUniqueid());
        if ($kycStatus){
            $kycStatus = $kycStatus[0];
        }

        return $this->render('@App/applicant/details.html.twig', [
            'checkablProgress'=>$checkablProgress,
            'testablProgress'=>$testablProgress,
            'personablProgress'=>$personablProgress,
            'user'=>$user,
            'employmentHistory'=>$employmentHistory,
            'educationHistory'=>$educationHistory,
			'testsCompleted'=>$testsCompleted,
            'videos' => $activeQ,
            'job' => $job,
            'idCheck'=>$idCheckStatus,
            'disclosures'=>$disclosures,
            'qualificationChecks'=>$qualificationChecks,
            'references'=>$references,
            'interviewStatus'=>$interviewStatus,
            'preScreen'=>$preScreen,
			'preScreenScore'=>$preScreenScore,
			'preScreenFormId'=>$preScreenFormId,
            'cv'=>$cv,
            'userJob'=>$userJob,
            'rating'=>$rating,
            'watched' => $watch,
            'appMessage'=>$appMessage,
            'interview'=>$interview,
            'avgRrating'=>$ratingAvg,
            'sectionJobs' => $sectionJobs,
			'visualid_pass' => $visualid_pass,
			'visualid_driv' => $visualid_driv,
			'visualid_webcam' => $visualid_webcam,
			'testabl1' => $testabl1,
			'testabl2' => $testabl2,
            'emailCheck'=>$emailCheck,
            'smsCheck'=>$smsCheck,
            'kycStatus'=>$kycStatus,
            'psFormId'=>$psFormId,
        ]);
 

    }
    public function getSearchDataAction ($searchTerm)
    {
        $user=$this->getUser();
        $applicantResults = '';
        $search =$this->get('app.search');
        $applicantSearch = $search->search($searchTerm, $user->getEmployerId());
        $searchResults = (json_decode($applicantSearch, true));
        dump($searchResults);exit;
        if(!isset($searchResults['value'])) {
            $applicantResults = '';
        }else{
            $idCount= 1;
            foreach ($searchResults['value'] as $sr){
                $applicantResults .= $sr['user_id'];
                if ($idCount < count($searchResults['value'])){
                    $applicantResults .=',';
                }
                $idCount++;
            }
            return $applicantResults;
        }
    }

    /**
     * @param $subject
     * @param $to
     * @param $htmlBody
     * @param $client Employers
     */
    public function sendEmail($subject, $to, $htmlBody, $client)
    {
        $bcc = $this->getParameter('bcc_to');
        $mailer = $this->get('swiftmailer.mailer');
        $message = (new \Swift_Message($subject))
            ->setFrom('scott@erigan.co.uk')
            ->setTo('scott@erigan.co.uk', 'Scott Baverstock')
            //->setBcc($bcc)
            ->setBody($htmlBody, 'text/html');

        $result = $mailer->send($message);

    }

    /**
     * @Route("/applicant/watch/add", name="applicant_watch_add")
     * @param Request $request
     * @return Response
     */
    public function addToWatchListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $applicant = $em->getRepository('AppBundle:Users')->findOneBy(['id' => $request->query->get('userid')]);
        $job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $request->query->get('jobid')]);
        $employer = $em->getRepository('AppBundle:Employers')->findOneBy(['id' => $request->query->get('employerid')]);

        $watch = $em->getRepository('AppBundle:Watch')->findOneBy(['applicant' => $applicant, 'job' => $job, 'employer' => $employer]);

        if(is_null($watch)){
            $watch = new Watch();
        }

        $watch->setJob($job);
        $watch->setApplicant($applicant);
        $watch->setEmployer($employer);
        $watch->setCreatedOn(new \DateTime('now'));

        $em->persist($watch);

        $em->flush();

        return new Response(json_encode($watch->toArray()));
    }


    /**
     * @Route("/applicant/watch/remove", name="applicant_watch_remove")
     * @param Request $request
     * @return Response
     */
    public function removeFromWatchListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $applicant = $em->getRepository('AppBundle:Users')->findOneBy(['id' => $request->query->get('userid')]);
        $job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $request->query->get('jobid')]);
        $employer = $em->getRepository('AppBundle:Employers')->findOneBy(['id' => $request->query->get('employerid')]);

        $watch = $em->getRepository('AppBundle:Watch')->findOneBy(['applicant' => $applicant, 'job' => $job, 'employer' => $employer]);
        if(is_null($watch)){
            return new Response('ok');
        }
        $em->remove($watch);
        $em->flush();
        return new Response('ok');
    }


}

