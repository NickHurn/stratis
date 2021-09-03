<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class UsersJobsRepository extends EntityRepository
{

    /**
     * @var $client Users
     */
    private $client;

    /**
     * @return Users
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Users $client
     * @return UsersJobsRepository
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }


	
    public function getUsersByJob ($fromDate, $toDate, $jobId)
    {
        $em= $this->getEntityManager();
        $job  = $em->getRepository('AppBundle:Jobs')->findBy(array('id'=>$jobId));
        $result = $em
            ->createQuery(
                'SELECT uj.userId as applicantId, j.id as jobId,j.title, uj.preScreenPass, uj.accepted, uj.offered, uj.rejected, u.firstname, u.surname, j.uniqueid as jobUniqueId, j.employerId, uj.createdOn
                FROM AppBundle:UsersJob uj
                  Join AppBundle:Jobs j with uj.jobId = j.uniqueid
                  join AppBundle:Users u with uj.userId = u.id
                WHERE uj.createdOn BETWEEN :fromDate and :toDate AND uj.jobId = :jobId and j.employerId = :employerId'
            )->setParameters(array("fromDate" => $fromDate, 'toDate'=>$toDate, 'jobId'=>$job[0]->getUniqueId(), 'employerId'=>$this->getClient()->getEmployerId()))
            ->getResult();
        return $result;
    }

    public function getUsers ($fromDate, $toDate)
    {
        $em= $this->getEntityManager();
        $result = $em
            ->createQuery(
                'SELECT uj.userId as applicantId, j.id as jobId,j.title, uj.preScreenPass, uj.accepted, uj.offered, uj.rejected, u.firstname, u.surname, j.uniqueid as jobUniqueId, j.employerId, uj.createdOn
                FROM AppBundle:UsersJob uj
                Join AppBundle:Jobs j with uj.jobId = j.uniqueid
                join AppBundle:Users u with uj.userId = u.id
                WHERE uj.createdOn BETWEEN :fromDate and :toDate  and j.employerId = :employerId'
            )->setParameters(array("fromDate" => $fromDate, 'toDate'=>$toDate, 'employerId'=>$this->getClient()->getEmployerId()))
            ->getResult();
        return $result;
    }

	
	//----------------------------------------------------------------------------
	//  Returns TRUE if the userid is currently applying for jobid, and the
	//  job application is not archived, not offered and not rejected
	//----------------------------------------------------------------------------
	
	public function verifyCandidateJobApplication ($user_id, $job_id)
    {
        $em= $this->getEntityManager();
/*
		$result = $em
            ->createQuery(
                'SELECT COUNT(1) AS c
                FROM AppBundle:UsersJob uj
                WHERE uj.jobId = :job AND uj.userId = :user AND uj.archived=0 AND uj.offered IS NULL AND uj.rejected IS NULL'
            )->setParameters(array("job" => $job_id, 'user'=>$user_id))
            ->getResult();
*/
		$result = $em
            ->createQuery(
                'SELECT COUNT(1) AS c
                FROM AppBundle:UsersJob uj
                WHERE uj.jobId = :job AND uj.userId = :user'
            )->setParameters(array("job" => $job_id, 'user'=>$user_id))
            ->getResult();

		return ($result[0]['c']==1) ? true:false;
    }


	//----------------------------------------------------------------------------
	//  Retrieve list of jobs for specified user. Ordered most recent first.
	//----------------------------------------------------------------------------
	
	public function getJobList($user_id)
    {
        $result = $this->getEntityManager()->createQuery(
                'SELECT j.title, j.description, uj.jobId, uj.checkablCount, uj.checkablCompleted, uj.testablCount, uj.testablCompleted, uj.personablCount, uj.personablCompleted, 
					uj.accepted, uj.offered, uj.rejected, j.description, j.county, j.salary, j.startDate, 
					j.active, uj.accepted, uj.offered, uj.rejected, uj.acceptedOn, uj.offeredOn, uj.rejectedOn, uj.userId
                FROM AppBundle:UsersJob uj
				LEFT JOIN AppBundle:Jobs j WITH uj.jobId = j.uniqueid
                WHERE uj.userId = :user
				ORDER BY uj.id DESC'
            )->setParameters(array('user'=>$user_id))
            ->getResult();
		return $result;
    }

	
	//----------------------------------------------------------------------------
	//  Updates the status info for the selected user/job (using job int id or job code)
	//----------------------------------------------------------------------------

	public function updateStats($user_id, $job_id)
	{
		$em= $this->getEntityManager();
		if(is_numeric($job_id))
		{
			$job = $em->getRepository('AppBundle:Jobs')->findOneBy(array('id' => $job_id));
			$job_code = $job->getUniqueId();
			$this->updateStatsByJobCode($user_id, $job_code);
		}
		else
		{
			$this->updateStatsByJobCode($user_id, $job_id);
		}
	}
	
	
	//----------------------------------------------------------------------------
	//  Updates the status info for the selected user/job (using job code)
	//----------------------------------------------------------------------------

	public function updateStatsByJobCode($user_id, $job_code)
	{
		$em = $this->getEntityManager();
		$progress = new \AppBundle\Model\Progress($em, null);
		$progress->setem($em);

		$uj = $em->getRepository('AppBundle:UsersJob')->findOneBy(array('jobId' => $job_code, 'userId'=>$user_id));
		if(!$uj) die("System error: usersjob record for user $$user_id job $job_code not found in UsersJob->updateStatsByJobCode()");
			
		$res = $progress->getCheckablProgressNew($job_code, $user_id);
		$uj->setCheckablCount($res['checks']);
		$uj->setCheckablCompleted($res['done']);
		
		$res = $progress->getTestablProgressNew($job_code, $user_id);
		$uj->setTestablCount($res['reqd']);
		$uj->setTestablCompleted($res['done']);
		
		$res = $progress->getPersonablProgressNew($job_code, $user_id);
		$uj->setPersonablCount($res['reqd']);
		$uj->setPersonablCompleted($res['done']);

		$em->persist($uj);
		$em->flush();
	}
	
	
	//---------------------------------------------------------------------------------
	//  Get applicant count for job
	//---------------------------------------------------------------------------------
	
	public function getApplicantCountForJob($job_code)
	{
		$res = $this->createQueryBuilder('UsersJob')
			->andWhere('UsersJob.jobId = :id')
			->setParameter('id', $job_code)
			->select('SUM(1) AS numApplicants')
			->getQuery()
			->getSingleScalarResult();
		return floor($res);
	}

	
	//---------------------------------------------------------------------------------
	//  Get count of rejected applicants for given employer
	//---------------------------------------------------------------------------------
	
	public function getRejectedCountForEmployer($employer_id)
	{
		$result = $this->getEntityManager()->createQuery(
			'SELECT uj.userId
			FROM AppBundle:UsersJob uj
			LEFT JOIN AppBundle:Jobs j WITH uj.jobId = j.uniqueid AND j.employerId=:eid
			WHERE uj.rejected = 1
			GROUP BY uj.userId'

		)->setParameters(array('eid'=>$employer_id))
		->getResult();


		return count($result);
	}

	
	//---------------------------------------------------------------------------------
	//  Get count of rejected applicants for given job
	//---------------------------------------------------------------------------------
	
	public function getRejectedCountForJob($job_code)
	{
		$result = $this->getEntityManager()->createQuery(
			'SELECT COUNT(1) AS c
			FROM AppBundle:UsersJob uj WHERE uj.jobId=:jobcode AND uj.rejected=1'
		)->setParameters(array('jobcode'=>$job_code))
		->getResult();
		return $result[0]['c'];
	}

    
   	//---------------------------------------------------------------------------------
	//  Get list of users applying for this job where they are not rejected or accepted
	//---------------------------------------------------------------------------------
	
	public function getActiveUserList($job_code)
	{
		$result = $this->getEntityManager()->createQuery(
			"SELECT uj.userId
			FROM AppBundle:UsersJob uj
            WHERE uj.jobId=:jobcode AND uj.offered IS NULL AND uj.rejected IS  NULL "
		)->setParameters(array('jobcode'=>$job_code))
		->getResult();
		return $result;
	}

}
