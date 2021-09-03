<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;
use http\Client\Curl\User;


class ExtraChecksRepository extends EntityRepository
{
    public function get ($applicant_id, $job_code)
	{

    }

	
	//--------------------------------------------------------------------
	//  Loop through data and save records
	//--------------------------------------------------------------------
	
    public function save($applicant_id, $job_code, $data, $user)
    {


        $em = $this->getEntityManager();
        $previousEC = $em->getRepository('AppBundle:IdChecks')->getPreviousExtraChecks($applicant_id, $job_code);
		$applicant_id = $data['aid'];
		$job_code = $data['jid'];
		$checkType='';
        $error = [];


        //Check DBS
        if(!empty($data['dbs1'])) $checkType='DBS/None';
		if(!empty($data['dbs2'])) $checkType='DBS/Basic';
		if(!empty($data['dbs3'])) $checkType='DBS/Standard';
		if(!empty($data['dbs4'])) $checkType='DBS/Enhanced';
		if(!empty($data['dbs5'])) $checkType='DBS/EnhancedBarred';


        if (empty($previousEC['DBS'])){
            if ($checkType != 'DBS/None' ){
                $this->saveDBSCheck($applicant_id, $job_code, $checkType, $previousEC);
            }
        }else{
            if ($previousEC['DBS']->getCheckType() != $checkType) {
                $canChangeDBS = $this->checkDBS($checkType, $previousEC['DBS']);
                if ($canChangeDBS) {
                    $this->saveDBSCheck($applicant_id, $job_code, $checkType, $previousEC);
                } else {
                    $error['dbs'] = 'We are unable to change the DBS selections';
                }
            }
        }

		if(!empty($data['pid1'])) $this->saveCheck ($applicant_id, $job_code, 'Visual/Checkabl');
		if(!empty($data['pid2'])) $this->saveCheck ($applicant_id, $job_code, 'Visual/Testabl');

		//check identity
        $this->saveIdentityCheck ($applicant_id, $job_code, $data,$previousEC);

        //check kyc
		$checkType='';
        if(!empty($data['id1'])) $checkType='KYC/none';
		if(!empty($data['id2'])) $checkType='KYC/Pack1';
		if(!empty($data['id3'])) $checkType='KYC/Pack2';
		if(!empty($data['id4'])) $checkType='KYC/Pack3';
		if(!empty($data['id5'])) $checkType='KYC/Pack4';

        if (empty($previousEC['KYC'])){
            if ($checkType != 'KYC/none' ){
                $this->saveKYCCheck($applicant_id, $job_code, $checkType, $previousEC);
            }
        }else{
            if ($previousEC['KYC']->getCheckType() != $checkType) {
                $canChangeKYC = $this->checkKYC($checkType, $previousEC['KYC']);
                if ($canChangeKYC) {
                    $this->saveKYCCheck($applicant_id, $job_code, $checkType, $previousEC);
                } else {
                    $error['kyc'] = 'We are no longer able to change the KYC Pack.  This is usually because the applicant has completed the questions and submitted them.';
                }
            }
        }

        //check Financial
        $this->saveFinancialCheck ($applicant_id, $job_code, $data,$previousEC);

        //check Qualifications
        if (isset($data['qu1'])){
            if (!isset( $previousEC['Qualifications']['qualifications'] )){
                $ecExists = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>'Qualifications']);
                $qcExists = $em->getRepository('AppBundle:QualificationChecks')->findOneBy(['jobId'=>$job_code, 'userId'=>$applicant_id]);

                if (is_null($ecExists) && is_null($qcExists)){
                    $this->saveCheck ($applicant_id, $job_code, 'Qualifications');
                    $this->saveQual($applicant_id, $job_code, 'Qualifications', $user);
                }else{
                    $error['qu1'] = 'Qualifications checks for this applicant and job already exist.';
                }
            }
        }else{
            if ($previousEC['Qualifications']['qualifications']){
                $qual = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>'Qualifications']);
                $em ->remove($qual);
                $em->flush();
            }
        }
        if (isset($data['qu2'])){
            $this->saveCheck ($applicant_id, $job_code, 'Memberships');
        }else{
            if ($previousEC['Qualifications']['membership']){
                $qual = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>'Memberships']);
                $em ->remove($qual);
                $em->flush();
            }
        }

        //check director
        if (isset($data['dir1'])){
            $this->saveCheck ($applicant_id, $job_code, 'Director');
        }else{
            if ($previousEC['Director']){
                $dir = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>'Director']);
                $em ->remove($dir);
                $em->flush();
            }
        }

		return $error;
	}

    public function saveQual ($applicant_id, $job_code, $checkType, $user)
    {
        /**
         * @var $user Users
         */
        $em = $this->getEntityManager();
        $job = $em->getRepository('AppBundle\Entity\Jobs')->findOneBy(array('uniqueid' => $job_code));
        $applicant = $em->getRepository('AppBundle:Users')->find($applicant_id);
        $qualUniqueCode = md5($applicant->getMobiletel().'a random string to make this a salt that just might work.  Who knows I certainly dont'.time());
        $path = $_SERVER['HTTP_HOST'];
        $long_url = 'https://'.$path.'/qualification/institute/'.$qualUniqueCode;
        $short_url = file_get_contents('https://api-ssl.bitly.com/v3/shorten?access_token=f2fbe310594e4e296fd89de2de630143e5db2c48&format=txt&longUrl='.urlencode($long_url));
        $em->getRepository('AppBundle:QualificationChecks')->saveQualificationCheck($qualUniqueCode, $short_url, $applicant_id, $job->getId(), $job->getEmployerId(), $user->getId() );
    }


    public function checkDBS ($selection, $previous)
    {
        $result = false;
        if ($previous) {
            $current = $this->dbsSelected($previous->getCheckType());
            $new = $this->dbsSelected($selection);
            if ($previous->getStatus() == 'Waiting for Candidate'){
                $result = true;
            }else{
                if ($new > $current){
                    $result = true;
                }
            }
        }else{
            $result = true;
        }

        return $result;
    }

    public function updateKYC ($selection, $previous)
    {
        $result = false;

        if ($previous) {
            if ($previous->getStatus() == 'Waiting for Candidate'){
                $result = true;
            }
        }else{
            $result = true;
        }
        return $result;
    }


    public function checkKYC ($selection, $previous)
    {
        $result = false;

        if ($previous) {
            if ($previous->getStatus() == 'Waiting for Candidate'){
                $result = true;
            }
        }else{
            $result = true;
        }
        return $result;
    }

    public function dbsSelected ($dbs)
    {
        $dbsCode = null;
        switch ($dbs) {
            case 'DBS/Basic':
                    $dbsCode = 1;
                break;
            case 'DBS/Standard':
                $dbsCode = 2;
                break;
            case'DBS/Enhanced':
                $dbsCode = 3;
                break;
            case'DBS/EnhancedBarred':
                $dbsCode = 4;
                break;
        }
        return $dbsCode;
    }

    //--------------------------------------------------------------------
    //  Save individual check record
    //--------------------------------------------------------------------
	public function saveCheck($applicant_id, $job_code, $checkType)
    {
        $em = $this->getEntityManager();
		$job = $em->getRepository('AppBundle\Entity\Jobs')->findOneBy(array('uniqueid' => $job_code));
		$employer_id = $job->getEmployerId();

        $ec = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>$checkType]);
		// We only save a check if there was not one existing (eg you cannot change them)
		if(!$ec)
		{
			$ec = new \AppBundle\Entity\ExtraChecks();
			$ec->setUserId($applicant_id);
			$ec->setEmployerId($employer_id);
			$ec->setJobCode($job_code);
			$ec->setCheckType($checkType);
			$ec->setStatus('Waiting for Candidate');
			$ec->setDateRequested(new \DateTime());
			$em->persist($ec);
			$em->flush();
		}
	}

    //--------------------------------------------------------------------
    //  Save individual check record
    //--------------------------------------------------------------------

    public function saveFinancialCheck($applicant_id, $job_code, $data,$previousEC)
    {
        $em = $this->getEntityManager();
        $job = $em->getRepository('AppBundle\Entity\Jobs')->findOneBy(array('uniqueid' => $job_code));
        $employer_id = $job->getEmployerId();

        if (isset($data['fin1'])){
            $this->saveCheck($applicant_id, $job_code, 'Finance/Personal');
        }else{
            if ($previousEC['Finance']['personal']){
                $passport = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>'Finance/Personal']);
                $em ->remove($passport);
                $em->flush();
            }
        }
        if (isset($data['fin2'])){
            $this->saveCheck ($applicant_id, $job_code, 'Finance/Credit');
        }else{
            if ($previousEC['Finance']['credit']){
                $passport = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>'Finance/Credit']);
                $em ->remove($passport);
                $em->flush();
            }
        }
    }


    public function saveIdentityCheck($applicant_id, $job_code, $data,$previousEC)
    {
        $em = $this->getEntityManager();
        $job = $em->getRepository('AppBundle\Entity\Jobs')->findOneBy(array('uniqueid' => $job_code));
        $employer_id = $job->getEmployerId();

        if (isset($data['ph1'])){
            $this->saveCheck ($applicant_id, $job_code, 'IDENTITY/Passport');
        }else{
            if ($previousEC['IDENTITY']['passport']){
                $passport = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>'IDENTITY/Passport']);
                $em ->remove($passport);
                $em->flush();
            }
        }
        if (isset($data['ph2'])){
            $this->saveCheck ($applicant_id, $job_code, 'IDENTITY/Driving');
        }else{
            if ($previousEC['IDENTITY']['driving']){
                $passport = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>'IDENTITY/Driving']);
                $em ->remove($passport);
                $em->flush();
            }
        }
    }
    public function saveKYCCheck($applicant_id, $job_code, $checkType,$previousEC)
    {
        $em = $this->getEntityManager();
        $job = $em->getRepository('AppBundle\Entity\Jobs')->findOneBy(array('uniqueid' => $job_code));
        $employer_id = $job->getEmployerId();

        if ($checkType == 'KYC/none'){
            if ($previousEC['KYC']){
                $toBeRemoved = $em->getRepository('AppBundle:ExtraChecks')->find($previousEC['KYC']->getId());
                $em ->remove($toBeRemoved);
                $em->flush();
            }
            return;
        }


        $ec = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['userId'=>$applicant_id, 'jobCode'=>$job_code, 'checkType'=>$checkType]);


        if (!$ec) {

            $ec = new \AppBundle\Entity\ExtraChecks();
            $ec->setUserId($applicant_id);
            $ec->setEmployerId($employer_id);
            $ec->setJobCode($job_code);
            $ec->setCheckType($checkType);
            $ec->setStatus('Waiting for Candidate');
            $ec->setDateRequested(new \DateTime());
            $em->persist($ec);
            $em->flush();
            if ($previousEC['KYC']){
                $toBeRemoved = $em->getRepository('AppBundle:ExtraChecks')->find($previousEC['KYC']->getId());
                $em ->remove($toBeRemoved);
                $em->flush();
            }
        }
    }

    public function saveDBSCheck($applicant_id, $job_code, $checkType,$previousEC)
    {



        $em = $this->getEntityManager();
        $job = $em->getRepository('AppBundle\Entity\Jobs')->findOneBy(array('uniqueid' => $job_code));
        $employer_id = $job->getEmployerId();

        if ($checkType == 'DBS/None'){
            if ($previousEC['DBS']){
                $toBeRemoved = $em->getRepository('AppBundle:ExtraChecks')->find($previousEC['DBS']->getId());
                $em ->remove($toBeRemoved);
                $em->flush();
            }
            return;
        }



        $ec = new \AppBundle\Entity\ExtraChecks();
        $ec->setUserId($applicant_id);
        $ec->setEmployerId($employer_id);
        $ec->setJobCode($job_code);
        $ec->setCheckType($checkType);
        $ec->setStatus('Waiting for Candidate');
        $ec->setDateRequested(new \DateTime());
        $em->persist($ec);

        $uniqueid = md5($job_code . date('U'));
        $ad = new ApplicantDisclosures();
        $ad->setEmployeeId($applicant_id);
        $ad->setApplicantId($applicant_id);
        $ad->setEmployerId($employer_id);
        $ad->setCode($uniqueid);
        $ad->setJobId($job_code);
        $ad->setApplicantStatus('Waiting for Candidate');
        $ad->setHireablStatus('Waiting for Candidate');
        $ad->setGbgStatus('Awaiting processing');
        $ad->setGbgStatusCode(0);
        $ad->setStatusDate(new \DateTime());
        $em->persist($ad);
        $em->flush();

        if ($previousEC['DBS']){
            $toBeRemoved = $em->getRepository('AppBundle:ExtraChecks')->find($previousEC['DBS']->getId());
            $em ->remove($toBeRemoved);
            $em->flush();
        }

    }
	//--------------------------------------------------------------------
	//  Retrieve a list of users that have extrachecks for given employer
	//--------------------------------------------------------------------

	public function getUsersList($employer_id)
    {
        $em = $this->getEntityManager();

		$recs = $em->createQuery("SELECT DISTINCT ec.userId, CONCAT(u.firstname,' ',u.surname) AS username
			FROM AppBundle:ExtraChecks ec 
			LEFT JOIN AppBundle:Users u WITH ec.userId = u.id
			WHERE ec.employerId = :eid AND ec.checkType NOT LIKE 'DBS%'
			ORDER BY u.firstname,u.surname")
			->setParameters(array("eid"=>$employer_id))
			->getResult();
		$output = array('0'=>array('userId'=>0, 'username'=>'All'));
		$output = array_merge($output,$recs);
		//print "<pre>"; var_dump($output); die;
		return $output;
	}
	

	//--------------------------------------------------------------------
	//  Retrieve a list of jobs that have extrachecks for given employer
	//--------------------------------------------------------------------

	public function getJobsList($employer_id)
    {
        $em = $this->getEntityManager();
		
		$recs = $em->createQuery('SELECT DISTINCT j.id, j.title
			FROM AppBundle:ExtraChecks ec 
			LEFT JOIN AppBundle:Jobs j WITH ec.jobCode = j.uniqueid
			WHERE ec.employerId = :eid
			ORDER BY j.title')
		->setParameters(array("eid"=>$employer_id))
		->getResult();
		$output = array('0'=>'All');
		foreach($recs as $idx=>$r) $output[$r['id']] = $r['title'];
		return $output;
	}

	
	//--------------------------------------------------------------------
	//  Get ExtraChecks list detail records
	//--------------------------------------------------------------------

	public function  getDetailList($employer_id, $job_id, $user_id)
    {
        $em = $this->getEntityManager();
			
		if($job_id == 0) $jobfilter = ''; else $jobfilter = "AND j.id = $job_id ";
		if($user_id == 0)  $userfilter = ''; else $userfilter = "AND ec.userId = $user_id";

		$recs = $em->createQuery("SELECT j.title, u.firstname, u.surname, ec.id, ec.userId, ec.jobCode, ec.checkType, ec.dateRequested, ec.dateCompleted, ec.status, ec.result
			FROM AppBundle:ExtraChecks ec
			LEFT JOIN AppBundle:Users u WITH ec.userId = u.id
			LEFT JOIN AppBundle:Jobs j WITH ec.jobCode = j.uniqueid
			WHERE ec.employerId = :eid AND ec.checkType NOT LIKE 'DBS%'
			$jobfilter $userfilter
			ORDER BY ec.dateRequested DESC, ec.userId, ec.jobCode, ec.checkType")
			->setParameters(array("eid" => $employer_id))
			->getResult();
		return $recs;
	}

	
	//--------------------------------------------------------------------
	//  Get ExtraChecks list summary records
	//--------------------------------------------------------------------

	public function getSummaryList($employer_id, $job_id, $user_id)
    {
        $em = $this->getEntityManager();
		
		if($job_id == 0) $jobfilter = ''; else $jobfilter = "AND j.id = $job_id ";
		if($user_id == 0)  $userfilter = ''; else $userfilter = "AND ec.userId = $user_id";

		$recs = $em->createQuery("SELECT j.title, CONCAT(u.firstname,' ',u.surname) AS username, j.uniqueid AS jobnum, ec.userId, ec.checkType,
			SUM(CASE WHEN ec.status = 'Completed' THEN 1 ELSE 0 END) AS completed,
			count(ec.id) AS requested,
			SUM(CASE WHEN ec.checkType LIKE 'KYC%' THEN 1 ELSE 0 END) AS kyc
			FROM AppBundle:ExtraChecks ec
			LEFT JOIN AppBundle:Users u WITH ec.userId = u.id
			LEFT JOIN AppBundle:Jobs j WITH ec.jobCode = j.uniqueid
			WHERE ec.employerId = :eid AND ec.checkType NOT LIKE 'DBS%'
			and ec.checkType <> 'Qualifications'
			and ec.checkType <> 'Memberships'
			$jobfilter $userfilter
			GROUP BY ec.jobCode, ec.userId
			ORDER BY j.title DESC, ec.userId")
			->setParameters(array("eid" => $employer_id))
			->getResult();
		return $recs;
	}





}
