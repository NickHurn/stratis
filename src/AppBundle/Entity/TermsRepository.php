<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class TermsRepository extends EntityRepository
{
    public function getTermsList($employer_id)
    {
		$result = $this->getEntityManager()->createQuery(
			'SELECT t.id, t.title, COUNT(tj.termsId) AS cnt
			FROM AppBundle:Terms t 
			LEFT JOIN AppBundle:TermsJobs tj WITH t.id=tj.termsId
			WHERE t.employer=:eid
			GROUP BY t.id'
		)
		->setParameters(array("eid"=>$employer_id))
		->getResult();
		return $result;
    }


	public function getAssignedJobs($employer_id, $terms_id)
    {
		$recs = $this->getEntityManager()->createQuery(
			'SELECT j.id, j.title, tj.jobId 
			FROM AppBundle:Jobs j 
			LEFT JOIN AppBundle:TermsJobs tj WITH j.id=tj.jobId AND tj.termsId = :tid
			WHERE j.employerId = :eid 
			GROUP BY j.id 
			ORDER BY j.title'
		)->setParameters(array("eid"=>$employer_id, "tid"=>$terms_id))
		->getResult();
		return $recs;
    }


	public function saveAssignedJobs($terms_id, $data)
    {
		//  Delete existing entries
		$em = $this->getEntityManager();
		$em->createQuery("DELETE FROM AppBundle:TermsJobs tj WHERE tj.termsId = :tid")
			->setParameters(array("tid"=>$terms_id))
			->getResult();
		
		// Save new entries
		foreach($data as $fld=>$val)
		{
			if(substr($fld,0,2)=='op')
			{
				$jobid = substr($fld,2);
				$tj = new TermsJobs();
				$tj->setJobId($jobid);
				$tj->setTermsId($terms_id);
				$em->persist($tj);
				$em->flush();
			}
		}
    }
	
	
	public function deleteTerms($employer_id, $terms_id)
    {
		$em = $this->getEntityManager();	

		//  Verify this terms belongs to correct employer
		$t = $em->getRepository('AppBundle\Entity\Terms')->findOneBy(array('employer' => $employer_id, 'id'=>$terms_id));
		if(!$t) { die("not correct "); return; }

		//  Delete the record from Terms
		$em->createQuery("DELETE FROM AppBundle:Terms t WHERE t.id = :tid")
			->setParameters(array("tid"=>$terms_id))
			->getResult();
			
		//  Delete the record(s) from jobs_terms
		$em->createQuery("DELETE FROM AppBundle:TermsJobs tj WHERE tj.termsId = :tid")
			->setParameters(array("tid"=>$terms_id))
			->getResult();
		return;
	}
	
	
	public function getJobTerms($jobid)
	{
		$recs = $this->getEntityManager()->createQuery(
			'SELECT t.title, t.terms 
				FROM AppBundle:TermsJobs tj 
				LEFT JOIN AppBundle:Terms t WITH t.id = tj.termsId WHERE tj.jobId=:jid'
			)->setParameters(array("jid"=>$jobid))
		->getResult();
		return $recs;
	}		
			
}