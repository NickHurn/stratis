<?php

namespace AppBundle\Model;

use AppBundle\Entity\ApplicantShare;
use AppBundle\Entity\IdChecks;
use AppBundle\Entity\ReferenceRequest;
use AppBundle\Entity\Media;
use Doctrine\ORM\EntityManager;
use FormBundle\Factory\FormFactory;


class Progress {

    /**
     * @var EntityManager
     */

    private $em;
    /**
     * @var FormFactory
     */
    private $formFactory;

    public function __construct($em, $formFactory)
    {
            $this->em = $em;
            $this->formFactory = $formFactory;
    }

	public function setem($em)
	{
		$this->em = $em;
	}
	
	
	//------------------------------------------------------------------------------
	//  Calculate the number of checkabl entries required and completed
	//------------------------------------------------------------------------------
	
    public function getCheckablProgressNew($job_code, $user_id)
    {
		$user = $this->em->getRepository('AppBundle\Entity\Users')->findOneBy(['id' => $user_id]);
		$job = $this->em->getRepository('AppBundle\Entity\Jobs')->findOneBy(['uniqueid' => $job_code]);
		$job_id = $job->getId();
		$employer_id = $job->getEmployerId();
		$media = $this->em->getRepository('AppBundle\Entity\Media');
		
        $res['checks'] = 2;
        $res['done'] = 0;


		//  EMAIL

		$ev = $this->em->getRepository('AppBundle\Entity\EmailVerification')->findOneBy(['email' => $user->getEmailaddress(), 'confirmed'=>1]);
		$done_email = (empty($ev)) ? 0:1;
		if($done_email) $res['done']++;


		//  SMS
		
		$sv = $this->em->getRepository('AppBundle\Entity\SmsVerification')->findOneBy(['mobile' => $user->getMobileTel(), 'confirmed'=>1]);
		$done_sms = (empty($sv)) ? 0:1;
		if($done_sms) $res['done']++;

		
		//  DBS (ANY)

		$reqd_dbs = 0;
		$done_dbs = 0;
		$dbs_id = 0;
		
		$ec = $this->em->createQuery(
			"SELECT ec.id, ec.status FROM AppBundle:ExtraChecks ec WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'DBS/%' "
			)->setParameters(array('uid'=>$user_id, 'jcode'=>$job_code))
		->getResult();
		if ($ec) {
            if ($ec[0]['id'] > 0) {
                $reqd_dbs = 1;
                $res['checks']++;
                if ($ec[0]['status'] <> 'Waiting for Candidate') {
                    $done_dbs = 1;
                    $res['done']++;
                }
            }
        }
		
		//  IDENTITY (PASSPORT)

		$reqd_passport = 0;
		$done_passport = 0;
		$sv = $this->em->getRepository('AppBundle\Entity\ExtraChecks')->findOneBy(['jobCode' => $job_code, 'userId'=>$user_id, 'checkType'=>'IDENTITY/Passport']);
		$reqd_passport = (empty($sv)) ? 0:1;
		if($reqd_passport)
		{
			$res['checks']++;
			if($sv->getStatus() <> 'Waiting for Candidate') { $done_passport=1; $res['done']++; }
			//$photo = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'PASSPORT', 1);
			//if($photo) { $done_passport=1; $res['done']++; }
		}


		//  IDENTITY (DRIVING LICENCE)

		$reqd_driving = 0;
		$done_driving = 0;
		$sv = $this->em->getRepository('AppBundle\Entity\ExtraChecks')->findOneBy(['jobCode' => $job_code, 'userId'=>$user_id, 'checkType'=>'IDENTITY/Driving']);
		$reqd_driving = (empty($sv)) ? 0:1;
		if($reqd_driving)
		{
			$res['checks']++;
			if($sv->getStatus() <> 'Waiting for Candidate') { $done_driving=1; $res['done']++; }
			//$photo = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'DRIVING', 1);
			//if($photo) { $done_driving=1; $res['done']++; }
		}
		

		//  IDENTITY (AML)

		$reqd_aml = 0;
		$done_aml = 0;
		$ec = $this->em->createQuery(
			"SELECT ec.id, ec.status FROM AppBundle:ExtraChecks ec WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'KYC/%' "
			)->setParameters(array('uid'=>$user_id, 'jcode'=>$job_code))
		->getResult();
		if(isset($ec[0]) && $ec[0]['id']>0)
		{
			$reqd_aml = 1;
			$res['checks']++;
			if($ec[0]['status'] <> 'Waiting for Candidate') { $done_aml=1; $res['done']++; }
		}

		// Qualifications
        $reqd_qual = 0;
        $done_qual = 0;
        $qual = $this->em->getRepository('AppBundle:ExtraChecks')->findOneBy(['checkType'=>'Qualifications', 'userId'=>$user_id, 'jobCode'=>$job_code]);
        if(isset($qual) && $qual->getId()>0)
        {
            $reqd_qual = 1;
            $res['checks']++;
            if($qual->getStatus() <> 'Waiting for Candidate') { $done_qual=1; $res['done']++; }
        }


		//  DIRECTOR

		$reqd_director = 0;
		$done_director = 0;
		$ec = $this->em->createQuery(
			"SELECT ec.id, ec.status FROM AppBundle:ExtraChecks ec WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType = 'Director' "
			)->setParameters(array('uid'=>$user_id, 'jcode'=>$job_code))
		->getResult();
		if(isset($ec[0]) && $ec[0]['id']>0)
		{
			$reqd_director = 1;
			$res['checks']++;
			if($ec[0]['status'] <> 'Waiting for Candidate') { $done_director=1; $res['done']++; }
		}

		
		//  PRE-SCREEN
		
		$reqd_prescreen = 0;
		$done_prescreen = 0;
		$ps = $this->em->getRepository('AppBundle\Entity\Forms')->getUserJobPrescreenStatus($user_id, $employer_id, $job_code);
		if($ps)
		{ 
			$reqd_prescreen = 1; 
			$res['checks']++;
			if(!empty($ps['c_user_id']))
			{
				$done_prescreen = 1;
				$res['done']++;
			}
		}


		//  TERMS
		
		$reqd_terms = 0;
		$done_terms = 0;
		$terms_id = false;
		$terms_jobs = $this->em->getRepository('AppBundle\Entity\TermsJobs')->findOneBy(['jobId' => $job_id]);
		if(!empty($terms_jobs))
		{
			$reqd_terms = 1;
			$res['checks']++;
			$terms_agreed = $this->em->getRepository('AppBundle:TermsAgreed')->findOneBy(['userId' => $user_id, 'jobId'=>$job_id]);
			if($terms_agreed) { $done_terms = 1; $res['done']++; }
		}
		

		//  HISTORY
		
		$reqd_emphistory = 0;
		$reqd_eduhistory = 0;
		$done_emphistory = 0;
		$done_eduhistory = 0;

		$job = $this->em->getRepository('AppBundle\Entity\Jobs')->findOneBy(['uniqueid' => $job_code]);
		if($job->getHistory()==1)
		{
			$reqd_emphistory = 1;
			$reqd_eduhistory = 1;
			$res['checks']+=2;
			
			$hc = $this->em->getRepository('AppBundle:HistoriesComplete')->findOneBy(array('userId'=>$user_id, 'jobId'=>$job_code));
			if($hc) {
				if($hc->getEducation()==1) { $done_eduhistory = 1; $res['done']++; }
				if($hc->getEmployment()==1) { $done_emphistory = 1; $res['done']++; }
			}
		}

		
		//  CV UPLOAD
		
		$reqd_cv = 0;
		$done_cv = 0;		

		$cv = $this->em->getRepository('AppBundle\Entity\CvCheck')->findOneBy(['employerId' => $employer_id]);
		if($cv)
		{
			$reqd_cv = 1;
			$res['checks']++;
			$cv = $this->em->getRepository('AppBundle\Entity\Cv')->findOneBy(['userId' => $user_id, 'jobId'=>$job_code]);
			if(!empty($cv)) { $done_cv = 1; $res['done']++; }
		}
		
		
		//  VISUAL ID (FACE COMPARE)

		$reqd_facerec = 0;
		$done_facerec = 0;
		$sv = $this->em->getRepository('AppBundle\Entity\ExtraChecks')->findOneBy(['jobCode' => $job_code, 'userId'=>$user_id, 'checkType'=>'Visual/Checkabl']);
		$reqd_facerec = (empty($sv)) ? 0:1;
		if($reqd_facerec)
		{
			$res['checks']++;
			if($sv->getStatus() <> 'Waiting for Candidate') { $done_facerec=1; $res['done']++; }
		}
		// for ref: $filename = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'VISUALID', 1);	

		
		//  BUILD ARRAY OF REQUIRED AND COMPLETED OPTIONS

		$res['completed'] = array(
			'email'			=> $done_email,
			'mobile'		=> $done_sms,
			'terms'			=> $done_terms,
			'cv'			=> $done_cv,
			'emphistory'	=> $done_emphistory,
			'eduhistory'	=> $done_eduhistory,
			'passport'		=> $done_passport,
			'driving'		=> $done_driving,
			'visualid'		=> $done_facerec,
			'aml'			=> $done_aml,
			'dbs'			=> $done_dbs,
			'director'		=> $done_director,
			'prescreen'		=> $done_prescreen,
            'qual'          => $done_qual
		);

		$res['required'] = array(
			'email'			=> $done_email,
			'mobile'		=> $done_sms,
			'terms'			=> $reqd_terms,
			'cv'			=> $reqd_cv,
			'emphistory'	=> $reqd_emphistory,
			'eduhistory'	=> $reqd_eduhistory,
			'passport'		=> $reqd_passport,
			'driving'		=> $reqd_driving,
			'visualid'		=> $reqd_facerec,
			'aml'			=> $reqd_aml,
			'dbs'			=> $reqd_dbs,
			'director'		=> $reqd_director,
			'prescreen'		=> $reqd_prescreen,
            'qual'          => $reqd_qual,
		);
        $res['percentdone'] = round($res['done'] / $res['checks'] * 100, 0);
		return $res;
	}
	
	
	//------------------------------------------------------------------------------
	//  Calculate the number of testabl entries required and completed
	//------------------------------------------------------------------------------
	
    public function getTestablProgressNew($job_code, $user_id)
    {
        return null;
		$user = $this->em->getRepository('AppBundle\Entity\Users')->findOneBy(['id' => $user_id]);
		$job = $this->em->getRepository('AppBundle\Entity\Jobs')->findOneBy(['uniqueid' => $job_code]);
		$job_id = $job->getId();
		$employer_id = $job->getEmployerId();
		
		$resultA = $this->em->createQuery(
			'SELECT COUNT(1) AS c FROM AppBundle:FormUserJobs fuj WHERE fuj.employerId = :eid AND fuj.userId = :uid AND fuj.jobId = :jid'
		)->setParameters(array('eid'=>$employer_id, 'uid'=>$user_id, 'jid'=>$job_id))
		->getResult();

		$resultB = $this->em->createQuery(
			"SELECT COUNT(1) AS c FROM AppBundle:FormUserJobs fuj WHERE fuj.employerId = :eid AND fuj.userId = :uid AND fuj.jobId = :jid AND fuj.status='COMPLETED' "
		)->setParameters(array('eid'=>$employer_id, 'uid'=>$user_id, 'jid'=>$job_id))
		->getResult();

        $res['reqd'] = $resultA[0]['c'];
        $res['done'] = $resultB[0]['c'];
		$res['percentdone'] = 0;
		if($res['reqd'] > 0) { $res['percentdone'] = round($res['done'] / $res['reqd'] * 100, 0); }
		return $res;
	}

	
	//------------------------------------------------------------------------------
	//  Calculate the number of personabl entries required and completed
	//------------------------------------------------------------------------------
	
    public function getPersonablProgressNew($job_code, $user_id)
    {
        return null;
		$user = $this->em->getRepository('AppBundle\Entity\Users')->findOneBy(['id' => $user_id]);
		$job = $this->em->getRepository('AppBundle\Entity\Jobs')->findOneBy(['uniqueid' => $job_code]);
		$job_id = $job->getId();
		$employer_id = $job->getEmployerId();
		
		$resultA = $this->em->createQuery(
			'SELECT COUNT(1) AS c FROM AppBundle:VideoQuestions vq WHERE vq.jobId = :jid'
		)->setParameters(array('jid'=>$job_code))
		->getResult();

		$resultB = $this->em->createQuery(
			'SELECT COUNT(1) AS c FROM AppBundle:VideoAnswers va WHERE va.jobId = :jid AND va.userId=:uid'
		)->setParameters(array('jid'=>$job_code, 'uid'=>$user_id))
		->getResult();

        $res['reqd'] = $resultA[0]['c'];
		$res['done'] = $resultB[0]['c'];
		$res['percentdone'] = 0;
		if($res['reqd'] > 0) { $res['percentdone'] = round($res['done'] / $res['reqd'] * 100, 0); }
		return $res;
	}

	
	
	
	public function getCheckablProgress($applicantShare)
    {
        /**
         * @var ApplicantShare $applicantShare
         */

        $checks = 2;
        $total = 0;

        $cvCheck = $this->em->getRepository('AppBundle:CvCheck')->findOneBy(['employerId'=>$applicantShare->getEmployerId()]);
        $user = $this->em->getRepository('AppBundle:Users')->findOneBy(['id'=>$applicantShare->getApplicantId()]);
        $checkablFilter = $this->em->getRepository('AppBundle:CheckablFilters')->findOneBy(['jobId'=>$applicantShare->getJobId()]);
        $idchecks = $this->em->getRepository('AppBundle:IdChecks')->findOneBy(['userId'=>$applicantShare->getApplicantId(), 'jobId'=>$applicantShare->getJobId()]);
        $job =$this->em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$applicantShare->getJobId()]);
        $qualificationCheck = $this->em->getRepository('AppBundle:QualificationChecks')->findOneBy(['jobId'=>$job, 'userId'=>$user]);
        $isDisclosureRequired = $this->em->getRepository('AppBundle:ApplicantDisclosures')->findOneBy(['applicant_id'=>$applicantShare->getApplicantId(), 'job_id'=>$applicantShare->getJobId()]);
        $skillsEmployer = $this->em->getRepository('AppBundle:SkillsEmployer')->findOneBy(['employerId'=>$applicantShare->getEmployerId()]);
        $checkemailsql = $this->em->getRepository('AppBundle:EmailVerification')->findOneBy(['email'=>$user->getEmailaddress(), 'confirmed'=>1]);
        $smsVerification = $this->em->getRepository('AppBundle:SmsVerification')->findOneBy(['mobile'=>$user->getMobiletel(), 'confirmed'=>1]);
        $employer = $this->em->getRepository('AppBundle:Employers')->find($applicantShare->getEmployerId());

        if (!is_null($cvCheck)){
            $checks++;
            $cv = $this->em->getRepository('AppBundle:Cv')->findOneBy(['userId'=>$applicantShare->getApplicantId(), 'jobId'=>$applicantShare->getJobId()]);
            if (!is_null($cv)){
                $total++;
            }
        }


		if ($checkablFilter) {
			if ($checkablFilter->getHistory() === 1){
				$historyJobs = $this->em->getRepository('AppBundle:HistoriesJobs')->findOneBy(['jobId'=>$applicantShare->getJobId()]);
				$checks = $checks + 2;
				$historyComplete = $this->em->getRepository('AppBundle:HistoriesComplete')->findOneBy(['userId'=>$applicantShare->getApplicantId(), 'jobId'=>$applicantShare->getJobId()]);
				if (!is_null($historyComplete) && $historyComplete->getEducation() === 1 ){
					$total++;
				}
				if (!is_null($historyComplete) && $historyComplete->getEmployment() === 1 ){
					$total++;
				}
			}
		}
		
		if(0) { // hack
			$fields = $this->formFactory->getAllFormFields(1, $employer, $job);
			if (count($fields) >0){
				$total++;
				$userJobs = $this->em->getRepository('AppBundle:UsersJob')->findOneBy(['userId'=>$user->getId(), 'jobId'=>$job->getUniqueid()]);
				if (!is_null( $userJobs->getPreScreenPass() )){
					$checks++;
				}
			}
		}
			
        if (!is_null($idchecks)){
            $checks++;
            $imgResponses = $this->em->getRepository('AppBundle:GbgImageResponse')->findOneBy(['checkId'=>$idchecks->getUniqueId()]);
            if(is_null($idchecks->getPass()) && (is_null($imgResponses) || ($imgResponses->getAuthenticated() != 'Failed' && $imgResponses->getAuthenticated() != 'Wrong Document'))){
            }else{
                $total++;
            }
        }

        if (!is_null($qualificationCheck)){
            $checks++;
            if ($qualificationCheck->getVerificationId() > 0){
                $total++;
            }
        }

        if (!is_null($isDisclosureRequired)){
            $checks++;
            if ($isDisclosureRequired->getApplicantStatus() == 'Completed'){
                $total++;
            }
        }

        if (!is_null($skillsEmployer)){
            $checks++;
            $skillsJobsUsers = $this->em->getRepository('AppBundle:SkillsJobsUsers')->findOneBy(['userId'=>$applicantShare->getApplicantId(), 'jobId'=>$applicantShare->getJobId()]);
            if (!is_null($skillsJobsUsers)){
                $total++;
            }
        }
        if(!is_null($checkemailsql)){
           $total++;
        }

		if(!is_null($smsVerification)){
            $total++;
        }
        if($total > $checks){
            $total = $checks;
        }

        return round($total / $checks * 100, 0);

    }
	
	
    public function getTestablProgress($applicantShare)
    {return 0;
        /**
         * @var ApplicantShare $applicantShare
         */
        $availableTest = $this->em->getRepository('AppBundle:EmployersTests')->findBy(['employerId'=>$applicantShare->getEmployerId(), 'jobId'=>$applicantShare->getJobId()]);
        $availableExcel = $this->em->getRepository('AppBundle:ExcelTests')->getExcelTestsByJob($applicantShare->getJobId());
        $classamrkercompleted = $this->em->getRepository('AppBundle:ClassmarkerLinks')->completedTests($applicantShare->getJobId(),$applicantShare->getApplicantId() );
        $excelcompleted = $this->em->getRepository('AppBundle:ExcelTestResults')->completedExcelResults($applicantShare->getJobId(),$applicantShare->getApplicantId() );
        $completed = count($classamrkercompleted) + count($excelcompleted);
        $available = count($availableTest) + count($availableExcel);
        if ($completed === '0' || $available == 0) {
            return 0;
        } else {
            return round($completed / $available * 100, 0);
        }
    }

    public function getPersonablProgress($applicantShare)
    {return 0;
        $activeQ = $this->em->getRepository('AppBundle:VideoQuestions')->getActiveQuestionsByUser($applicantShare->getJobId(),$applicantShare->getApplicantId());
        $completed = 0;
        $total = 0;
        if (count($activeQ['questions']) > 0) {
            foreach ($activeQ['questions'] as $a) {
                if ($a['completed'] == 1) {
                    $completed++;
                }
                $total++;
            }

            return round($completed / $total * 100);
        } else {
            return 0;
        }
    }

    public function getIdCheckStatus ($applicantShare){
        /**
         * @var ApplicantShare $applicantShare
         */
        $ec = $this->em->createQuery(
            "SELECT ec FROM AppBundle:ExtraChecks ec WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'IDENTITY/%' "
        )->setParameters(array('uid'=>$applicantShare->getApplicantId(), 'jcode'=>$applicantShare->getJobId()))
            ->getResult();
        $result = 'Not Requested';
        $r = 0;
        $c = 0;
        if (!is_null($ec)){
            foreach ($ec as $e){
                if ($e->getCheckType() == 'IDENTITY/Passport'){
                    if ($e->getStatus() == 'Waiting for Candidate'){
                        $r = $r + 1;
                    }
                    if ($e->getStatus() == 'Completed'){
                        $c = $c +1;
                    }
                }
                if ($e->getCheckType() == 'IDENTITY/Driving'){
                    if ($e->getStatus() == 'Waiting for Candidate'){
                        $r = $r + 1;
                    }
                    if ($e->getStatus() == 'Completed'){
                        $c = $c +1;
                    }
                }
            }
            if ($r > 0){
                $result = 'Requested';
            }elseif($c > 0){
                $result = 'Completed';
            }
        }
        return $result;
    }

    public function getQualStatus ($applicantShare)
    {
        /**
         * @var ApplicantShare $applicantShare
         */
        $user = $this->em->getRepository('AppBundle:Users')->findOneBy(['id'=>$applicantShare->getApplicantId()]);
        $job =$this->em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$applicantShare->getJobId()]);
        $qualificationCheck = $this->em->getRepository('AppBundle:QualificationChecks')->findOneBy(['jobId'=>$job, 'userId'=>$user]);

        if (!is_null($qualificationCheck)){

            if ($qualificationCheck->getVerificationId() > 0){
                return 'Received';
            }else{
                return 'Requested';
            }
        }else{
            return 'Not Requested';
        }
    }

    public function getDisclosureStatus ($applicantShare)
    {
        /**
         * @var ApplicantShare $applicantShare
         */

        $isDisclosureRequired = $this->em->getRepository('AppBundle:ApplicantDisclosures')->getDisclosuresByUser($applicantShare->getApplicantId(), $applicantShare->getJobId());
        if (!is_null($isDisclosureRequired)){

            if ($isDisclosureRequired->getStatus() == 'Completed'){
                return 'Completed';
            }
            else{
                return 'Requested';
            }
        }else{
            return 'Not Requested';
        }
    }

    public function getKycStatus ($applicantShare)
    {
        /**
         * @var ApplicantShare $applicantShare

         */
        $kycStatus = $this->em->getRepository('AppBundle:IdChecks')->getKycCheckStatusByUser( $applicantShare->getApplicantId(), $applicantShare->getJobId());
        if (empty($kycStatus)){
            $kyc = null;
        }else {
            $kyc = $kycStatus[0];
        }
        if (!is_null($kyc)){

            if ($kyc->getStatus() == 'Completed'){
                return 'Completed';
            }
            else{
                return 'Requested';
            }
        }else{
            return 'Not Requested';
        }
    }

    public function getReferenceStatus ($applicantShare)
    {
        /**
         * @var ApplicantShare $applicantShare
         */

        $ref = $this->em->getRepository('AppBundle:ReferenceRequest')->findOneBy(['applicantId'=>$applicantShare->getApplicantId(), 'jobId'=>$applicantShare->getJobId()]);
        if (is_null($ref)){
            return  'Not Requested';
        }else{
            $refRcvd = $this->em->getRepository('AppBundle:Reference')->findBy(['referenceRequestId' => $ref->getId()]);
            if (empty($refRcvd)){
                return   'Requested';
            }else{
                if(count($refRcvd) == $ref->getNoOfReferences()){
                    return   'Received';
                }elseif (count($refRcvd) < $ref->getNoOfReferences()){
                    return   'Part Received';
                }
            }
        }
    }

    public function getPreScreenStatus ($applicantShare)
    {
        /**
         * @var ApplicantShare $applicantShare
         */
        $job = $this->em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$applicantShare->getJobId()]);
        if ($job->getPreScreen()) {
            $isPreScreeneRequired = $this->em->getRepository('AppBundle:UsersJob')->findOneBy(['userId' => $applicantShare->getApplicantId(), 'jobId' => $applicantShare->getJobId()]);

            if ($isPreScreeneRequired->getPreScreenPass() == 1) {
                return 'Completed';
            } else {
                return 'Not Completed';
            }
        }
        return 'Not required';
    }

    public function getSharedStatus ($applicantId, $jobUniqueId, $employerId)
    {
        $applicantShareStatus=$this->em->getRepository('AppBundle:ApplicantShare')->findBy(['applicantId'=>$applicantId, 'jobId'=>$jobUniqueId, 'employerId'=>$employerId]);
        if (count($applicantShareStatus)>0){
            return 'Shared';

        }else{
            return 'Not Shared';
        }
    }

    public function getWatchedStatus ($applicantId, $jobId, $employerId)
    {

        $watchStatus=$this->em->getRepository('AppBundle:Watch')->findBy(['applicant'=>$applicantId, 'job'=>$jobId, 'employer'=>$employerId]);

        if (count($watchStatus)>0){
            return 'Watched';

        }else{
            return 'Not Watching';
        }
    }

    public function getRatingStatus ($applicantId, $jobId, $employerId)
    {
        $userAvg = $this->em->getRepository('AppBundle:ApplicantShare')->getSharedApplicantsRatingsAndNotes($applicantId, $jobId, $employerId);
        if (isset($userAvg["rating"])){
            return $userAvg["rating"]["avgRating"];
        }
    }

}
