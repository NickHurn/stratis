<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class InterviewsRepository extends EntityRepository
{
	
	//---------------------------------------------------------------------------------
	//  Get count of interviews for employer
	//---------------------------------------------------------------------------------
	
    public function getInterviewCountByEmployer($employer_id)
	{
		// TODO: restrict to non accepted or rejected ones?
		$result = $this->getEntityManager()->createQuery(
			'SELECT COUNT(1) AS c
			FROM AppBundle:Interviews i WHERE i.employerId=:eid'
			// AND i.accepted IS NULL AND i.rejected IS NULL
		)->setParameters(array('eid'=>$employer_id))
		->getResult();
		return $result[0]['c'];
	}
	
	
	//---------------------------------------------------------------------------------
	//  Get count of interviews for job
	//---------------------------------------------------------------------------------
	
    public function getInterviewCountByJob($jobcode)
	{
		// TODO: restrict to non accepted or rejected ones?
		$result = $this->getEntityManager()->createQuery(
			'SELECT COUNT(1) AS c
			FROM AppBundle:Interviews i WHERE i.jobId=:jid'
			// AND i.accepted IS NULL AND i.rejected IS NULL
		)->setParameters(array('jid'=>$jobcode))
		->getResult();
		return $result[0]['c'];
	}

    public function getInterviewDetails($user_id, $employer_id)
    {
        $em = $this->getEntityManager();
        $params = [];
        $params[] = $employer_id;
        $dql = 'select uj.id, u.firstname, u.surname, j.title, i.location, i.interviewDate, i.accepted, i.acceptedOn, i.rejected, i.rejectedOn, i.rejectReason
        from AppBundle:Interviews i
        join AppBundle:UsersJob uj with uj.jobId = i.jobId and uj.userId = i.userId
        join AppBundle:Jobs j with j.uniqueid = uj.jobId
        join AppBundle:Users u with u.id = uj.userId
        where j.employerId =:employerId';
        if ($user_id > 0) {
            $dql .= ' and uj.userId =:userId';
        }
        $dql .= ' order by j.title, i.interviewDate';
        $result = $em
            ->createQuery($dql)
            ->setParameters(array("employerId" => $employer_id, "userId" => $user_id))
            ->getResult();
        return $result;



    }


}

