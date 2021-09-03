<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\UsersJob;


class JobsRepository extends EntityRepository
{
	//--------------------------------------------------------------------
	//  Find all jobs for this employer (return array of id=>title)
	//--------------------------------------------------------------------
	
	public function getJoblistByEmployer($employerId)
    {
		$em= $this->getEntityManager();
		$recs = $em->getRepository('AppBundle:Jobs')->findBy(['employerId'=>$employerId], array('title'=>'ASC'));
		if(empty($recs)) return null;
		$result = array();
		foreach($recs as $rec)
		{
			$id = $rec->getId();
			$title = $rec->getTitle();
			$result[$id]=$title;
		}
		return $result;
	}                                                                                                                                                                          
	
	public function getJobCodeFromId($id)
	{
		$em= $this->getEntityManager();
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['id'=>$id]);
		if(!$job) return null;
		return $job->getUniqueId();
	}

	
	public function getIdFromJobCode($jobcode)
	{
		$em= $this->getEntityManager();
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$jobcode]);
		if(!$job) return null;
		return $job->getId();
	}
	
	
	//---------------------------------------------------------------------------------
	//  Create a UsersJob record linking this job to the specified applicant
	//  If one already exists, ignore request
	//---------------------------------------------------------------------------------
	
	public function assignToApplicant($job,$user_id)
	{
		$em = $this->getEntityManager();

		//  Check if already assigned
		$chk = $em->getRepository('AppBundle:UsersJob')->findOneBy(['jobId'=>$job->getUniqueId(), 'userId'=>$user_id]);
		if($chk) return;
		
		//  Assign
		$usersjob = new UsersJob();
		$usersjob->setJobId($job->getUniqueId());
		$usersjob->setUserId($user_id);
		$usersjob->setCheckablCount(0);
		$usersjob->setCheckablCompleted(0);
		$usersjob->setTestablCount(0);
		$usersjob->settestablCompleted(0);
		$usersjob->setPersonablCount(0);
		$usersjob->setPersonablCompleted(0);
		$usersjob->setCreatedOn(new \DateTime('now'));
		$usersjob->setLastModified(new \DateTime('now'));
		$em->persist($usersjob);
		$em->flush();
		// TODO: calculate count/completed figures

	}

	
	//---------------------------------------------------------------------------------
	//  Get job view employer
	//  (returns list of jobs and applicant counts, for job view)
	//---------------------------------------------------------------------------------

	public function getJobView($employer_id)
	{
		// SELECT title,uniqueid,count(uj.job_id) as c FROM `jobs` j left join users_job uj on j.uniqueid=uj.job_id group by j.uniqueid
			
		$em= $this->getEntityManager();
        $result = $em->createQuery(
			'SELECT j.id, j.uniqueid, j.title, j.startDate, j.salary, j.shortUrl, j.active, COUNT(uj.jobId) AS c
			FROM AppBundle:Jobs j
			LEFT JOIN AppBundle:UsersJob uj WITH j.uniqueid = uj.jobId
			WHERE j.employerId = :eid
		
			GROUP BY j.active, j.title, j.uniqueid
			ORDER BY j.active DESC, j.title, j.uniqueid')
		->setParameters(array("eid" => $employer_id))
		->getResult();

        return $result;

		
	}
	

	
	//---------------------------------------------------------------------------------
	//  Get job count for employer
	//---------------------------------------------------------------------------------
	
	public function getJobCountForEmployer($employer_id)
	{
        $em = $this->getEntityManager();
        $rec = $em->createQuery('SELECT j.uniqueid FROM AppBundle:Jobs j
			WHERE j.employerId = :id
			AND j.active = :active
            group by j.uniqueid')
            ->setParameters(array("id" => $employer_id, "active" => 1))
            ->getResult();

        return count($rec);
	}

	
	//---------------------------------------------------------------------------------
	//  Get applicant count for employer
	//---------------------------------------------------------------------------------
	
	public function getApplicantCountForEmployer($employer_id)
	{
		$em = $this->getEntityManager();
		$rec = $em->createQuery('SELECT uj.userId FROM AppBundle:UsersJob uj
			LEFT JOIN AppBundle:Jobs j WITH j.uniqueid = uj.jobId
			WHERE j.employerId = :id
            group by uj.userId')
			->setParameters(array("id" => $employer_id))
            ->getResult();
        return count($rec);
	}


	//---------------------------------------------------------------------------------
	//  Get testabl test assigned to this job
	//---------------------------------------------------------------------------------
	
	public function getTestList($employer_id, $job_id)
	{
		$em = $this->getEntityManager();
		$recs = $em->createQuery("SELECT fj.formId, f.formName
			FROM AppBundle:FormJobs fj
			LEFT JOIN AppBundle:Forms f WITH fj.formId = f.id 
			WHERE fj.employerId = :eid AND fj.jobId = :jid AND f.formType='TEST'
			ORDER BY f.formName")
			->setParameters(array("eid" => $employer_id, "jid"=>$job_id))
			->getResult();
		return $recs;
	}
	
	
	//---------------------------------------------------------------------------------
	//  Update percentages for candidate
	//  Updates the checkabl, testabl, personabl percentages for given job & user
	//---------------------------------------------------------------------------------
	
	public function updatePercentages($job_id, $user_id)
	{
		$em = $this->getEntityManager();

	}
	
}
