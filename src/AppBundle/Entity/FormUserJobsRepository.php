<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class FormUserJobsRepository extends EntityRepository
{
	//----------------------------------------------------------------------------------
	//  Retrieve list of forms for employer (showing all jobs)
	//----------------------------------------------------------------------------------

	public function getTestCompeletedCount($employer_id, $jobid=null)
	{
		if(!$jobid)
		{
			$result = $this->getEntityManager()
				->createQuery(
					'SELECT COUNT(1) AS c
					FROM AppBundle:FormUserJobs fuj
					WHERE fuj.employerId = :eid'
				)
				->setParameters(["eid"=>$employer_id])
				->getSingleScalarResult();
			return $result;
		}
		else
		{
			$result = $this->getEntityManager()
				->createQuery(
					'SELECT COUNT(1) AS c
					FROM AppBundle:FormUserJobs fuj
					WHERE fuj.employerId = :eid AND fuj.jobId = :jid'
				)
				->setParameters(["eid"=>$employer_id, "jid"=>$jobid])
				->getSingleScalarResult();
			return $result;
			
		}
    }
	
}
