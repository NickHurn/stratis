<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class VideoQuestionsRepository extends EntityRepository
{
    public function getActiveQuestionsByUser($job_id, $user_id)
    {
        $sql = "(SELECT  v1.*, case when vid > 0 then 1 else 0 end as completed
            FROM    videos_and_questions v1
            inner JOIN
            (
                SELECT  question, MAX(recorded_on) mxdate
                FROM    videos_and_questions
                GROUP   BY question
            ) v2 ON v1.question = v2.question
                    AND v1.recorded_on = v2.mxdate
            where v1.job_id = ? and v1.active = 1 ";
            if(!is_null($user_id)){
                $sql .= "and v1.user_id = ? )";
                $params = array($job_id,$user_id,$user_id, $job_id, );
            } else {
                $sql .= " )";
                $params = array($job_id,$job_id, $user_id);
            }
            $sql .= "
            UNION
            
            ( SELECT 
            vq.id,
            vq.job_id,
            vq.question,
            vq.video,
            vq.video_id as qvideo_id,
            vq.created_on,
            vq.active,
            v.recorded_on,
            v.video_id,
            v.id AS vid,
            v.user_id,
            case when v.id > 0 then 1 else 0 end as completed 
            FROM
            (video_questions vq
            LEFT JOIN video v ON ((v.question_id = vq.id)) and user_id = ?)
            where vq.job_id = ? and active = 1 and v.video_id is null
        ) 
            order by completed, id;";
        $em = $this->getEntityManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();

        $job =$em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$job_id]);


        $employer = $em->getRepository('AppBundle:Employers')->find($job->getEmployerId());

        return array('app_id' => $employer->getCameratagAppId(),
            'questions' => $result);

    }

	
	public function getListByJobId($job_id)
	{
		$em= $this->getEntityManager();
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['id'=>$job_id]);
		$jobcode = $job->getUniqueid();
		return $this->getListByJobCode($jobcode);
	}
			
	
	
	public function getListByJobCode($jobcode)
	{
		$em= $this->getEntityManager();
    
		//  Retrieve questions for this job ref
		$questions = $em->createQuery(
			"SELECT vq.id,vq.mediaId, vq.question, vq.active, vq.video, m.filename, m.extn
			FROM AppBundle:VideoQuestions vq
			LEFT JOIN AppBundle:Media m WITH vq.mediaId = m.id AND m.mediaType='VIDEO' AND m.format='VIDEO-QUESTION'
			WHERE vq.jobId = :jobcode
			ORDER BY vq.question"
		)
		->setParameters(array("jobcode"=>$jobcode))
		->getResult();

		$resp = array();
		foreach($questions as $q)
		{
			$q['fullfilename'] = '/media/'.floor($q['mediaId']/1000). '/' . $q['mediaId']. '-video-'.$q['filename']. '.' .$q['extn'];
			$resp[] = $q;
		}
		return $resp;
	}

}
