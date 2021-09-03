<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class VideoAnswersRepository extends EntityRepository
{
	
	public function getListByJobId($job_id)
	{
		$em= $this->getEntityManager();
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['id'=>$job_id]);
		$jobcode = $job->getUniqueid();

		//return $this->getListByJobCode($jobcode);
		$questions = $em->createQuery(
			"SELECT va.id,va.mediaId, va.question, va.active, va.video, m.filename, m.extn
			FROM AppBundle:VideoAnswers va
			LEFT JOIN AppBundle:Media m WITH va.mediaId = m.id AND m.mediaType='VIDEO' AND m.format='VIDEO-QUESTION'
			WHERE va.jobId = :jobcode
			ORDER BY vq.question"
		)
		->setParameters(array("jobcode"=>$jobcode))
		->getResult();
	}
			
	
	
	public function getList($jobcode, $user_id)
	{
		$em= $this->getEntityManager();
    
		//  Retrieve questions for this job ref
		$questions = $em->createQuery(
			"SELECT vq.id, vq.question, vq.active, vq.video, vq.mediaId AS qmediaId, mq.filename AS qfilename, mq.extn AS qextn, ma.filename AS afilename, ma.extn AS aextn, va.mediaId AS amediaId
			FROM AppBundle:VideoQuestions vq
			LEFT JOIN AppBundle:Media mq WITH vq.mediaId = mq.id AND mq.mediaType='VIDEO' AND mq.format='VIDEO-QUESTION'
			LEFT JOIN AppBundle:VideoAnswers va WITH vq.id = va.questionId AND va.userId=:userid AND vq.jobId=va.jobId
			LEFT JOIN AppBundle:Media ma WITH va.mediaId = ma.id AND ma.mediaType='VIDEO' AND ma.format='VIDEO-ANSWER'
			WHERE vq.jobId = :jobcode AND vq.active=1
			ORDER BY vq.question"
		)
		->setParameters(array("jobcode"=>$jobcode, "userid"=>$user_id))
		->getResult();

		$resp = array();
		foreach($questions as $q)
		{
			$q['qfilename'] = '/media/'.floor($q['qmediaId']/1000). '/' . $q['qmediaId']. '-video-'.$q['qfilename']. '.' .$q['qextn'];
			$q['afilename'] = '/media/'.floor($q['amediaId']/1000). '/' . $q['amediaId']. '-video-'.$q['afilename']. '.' .$q['aextn'];
			$resp[] = $q;
		}
		return $resp;
	}


	public function getListByJobId2($jobid)
	{
		$em= $this->getEntityManager();
    
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['id'=>$jobid]);
		$jobcode = $job->getUniqueid();

		//  Retrieve questions for this job ref
		$questions = $em->createQuery(
			"SELECT va.userId, va.questionId, m.id AS mid, u.firstname, u.surname, vq.question, m.filename, m.extn
			FROM AppBundle:VideoAnswers va
			LEFT JOIN AppBundle:VideoQuestions vq WITH va.questionId = vq.id
			LEFT JOIN AppBundle:Media m WITH va.mediaId = m.id AND m.mediaType='VIDEO' AND m.format='VIDEO-ANSWER'
			LEFT JOIN AppBundle:Users u WITH va.userId = u.id
			WHERE va.jobId = :jobcode
			ORDER BY u.firstname, u.surname, vq.question"
		)
		->setParameters(array("jobcode"=>$jobcode))
		->getResult();

		$resp = array();
		foreach($questions as $q)
		{
			$q['filename'] = '/media/'.floor($q['mid']/1000). '/' . $q['mid']. '-video-'.$q['filename']. '.' .$q['extn'];
			$resp[] = $q;
		}
		return $resp;
	}
}
