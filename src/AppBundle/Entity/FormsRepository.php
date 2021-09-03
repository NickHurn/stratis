<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class FormsRepository extends EntityRepository
{
	//----------------------------------------------------------------------------------
	//  Retrieve list of forms for employer (showing all jobs)
	//----------------------------------------------------------------------------------

	public function getList($employer_id, $form_type=null)
	{
		//  Get the list of jobs and counts of pre-screen questions for each
        $result = $this->getEntityManager()
			->createQuery(
				'SELECT f.id, f.formName, f.jobId, j.uniqueid, j.title, f.numQuestions, f.passScore
				FROM AppBundle:Jobs j
				LEFT JOIN AppBundle:Forms f WITH f.jobId = j.uniqueid and f.formType = :ft
				WHERE j.employerId = :eid
				ORDER BY j.title'
			)
			->setParameters(array("eid"=>$employer_id, "ft" => $form_type))
            ->getResult();
        return $result;
    }


	//----------------------------------------------------------------------------------
	//  Retrieve list of test forms for employer
	//----------------------------------------------------------------------------------

	public function getTestList($employer_id)
	{
        $result = $this->getEntityManager()
			->createQuery(
				'SELECT f.id, f.formName, f.numQuestions, f.passScore, f.timeLimit
				FROM AppBundle:Forms f 
				WHERE f.employerId = :eid AND f.formType = :typ
				ORDER BY f.formName'
			)
			->setParameters(array("eid"=>$employer_id, "typ"=>"TEST"))
            ->getResult();
        return $result;
    }

	
	//----------------------------------------------------------------------------------
	//  For given employer, get count of completed prescreen tests by job
	//----------------------------------------------------------------------------------
	
	public function getCompletedPreScreenCount($employer_id)
	{
		//  Get the list of forms that are prescreen and for this employer
		$form_id_recs = $this->getEntityManager()
			->createQuery("select f.id from AppBundle:Forms f where f.formType='PRESCREEN' AND f.employerId=:eid")
			->setParameters(array("eid"=>$employer_id))
            ->getResult();

		$recs = array();
		foreach($form_id_recs as $fr) $recs[] = $fr['id'];

		//  Get the count of number of completed forms against each job type
		$result = $this->getEntityManager()
			->createQuery('SELECT fc.formId, count(1) as c FROM AppBundle:FormCompleted fc WHERE fc.formId IN(:recs) GROUP BY fc.formId')
			->setParameters(array("recs"=>$recs))
			->getResult();
		
		return $result;
	}
		
		
	//----------------------------------------------------------------------------------
	//  Retrieve form id from the given job id (assuming a PRESCREEN form)
	//----------------------------------------------------------------------------------

	public function getIdFromJob($job_id)
	{
        $result = $this->getEntityManager()
			->createQuery('SELECT f.id FROM AppBundle:Forms f WHERE f.jobId = :jobid')
			->setParameters(array("jobid"=>$job_id))
            ->getResult();
		if(!empty($result[0]['id'])) return $result[0]['id'];
		return false;
    }

	
	//----------------------------------------------------------------------------------
	//  Returns the candidate name and score details of the person that completed the
	//  form, or false if the candidate is not associated with the employer or 
	//  did not complete it.
	//----------------------------------------------------------------------------------

	public function getFormCandidateInfo($form_id, $employer_id,$applicant_id)
	{
        $form_id = (int)$form_id;

        $result = $this->getEntityManager()
			->createQuery('SELECT f.employerId, fc.userId, u.firstname, u.surname, j.title, fc.score, fc.maxScore, fc.passScore, fc.percentage 
			FROM AppBundle:Forms f'
				. ' INNER JOIN AppBundle:FormCompleted fc WITH f.id = fc.formId'
				. ' LEFT JOIN AppBundle:Users u WITH fc.userId = u.id'
				. ' LEFT JOIN AppBundle:Jobs j WITH f.jobId = j.uniqueid'
				. ' WHERE f.id = :formid'
                .' and u.id = :userId')
			->setParameters(array("formid"=>$form_id,"userId"=>$applicant_id))
            ->getResult();

		return $result;
	}


	//----------------------------------------------------------------------------------
	//  Create form (if it does not exist already)
	//  Returns an instance of the (new or existing) form
	//----------------------------------------------------------------------------------
	
	public function createOrFetchForm($name, $type, $employer_id, $job_id)
	{
		$form = $this->findOneBy(['formName'=>$name,'formType'=>$type,'employerId'=>$employer_id,'jobId'=>$job_id]);
		if(!$form)
		{
			$em = $this->getEntityManager();
			$form = new Forms();
			$form->setFormName($name);
			$form->setFormType($type);
			$form->setEmployerId($employer_id);
			$form->setJobId($job_id);
			$form->setNumQuestions(0);
			$form->setTimeLimit(0);
			$form->setPassScore(0);
			$em->persist($form);
			$em->flush();
		}
		return $form;
	}
	
		

	//----------------------------------------------------------------------------------
	//  List all test forms and #count of jobs assigned to each one
	//----------------------------------------------------------------------------------
	
	public function getFormsByJobList($employer_id)
	{
		$em= $this->getEntityManager();

		$sql = "SELECT f.formName, f.id , COUNT(fj.jobId) AS c
			FROM AppBundle:Forms f
			LEFT JOIN AppBundle:FormJobs fj WITH f.id = fj.formId
			WHERE f.formType <> 'PRESCREEN' AND f.employerId = :empid
			GROUP BY f.id
			ORDER BY f.formName";
		
		$result = $em->createQuery($sql)->setParameters(array("empid"=>$employer_id))->getResult();
		return $result;
	}

	
	//----------------------------------------------------------------------------------
	//  List all jobs and show which are assigned to the form specified
	//----------------------------------------------------------------------------------
	
	public function getJobListForForm($employer_id, $form_id)
	{
		$em= $this->getEntityManager();

		$sql = "SELECT j.title, j.id, fj.jobId
			FROM AppBundle:Jobs j
			LEFT JOIN AppBundle:FormJobs fj WITH j.id=fj.jobId AND fj.formId = :fid
			WHERE j.employerId=:empid
			ORDER BY j.title";

		$result = $em->createQuery($sql)->setParameters(array("empid"=>$employer_id, "fid"=>$form_id))->getResult();
		return $result;
	}
	
	
	//----------------------------------------------------------------------------------
	//  Save which jobs this test/form has been assigned to
	//----------------------------------------------------------------------------------

	public function saveAssignedJobs($employer_id, $form_id, $data)
    {
		//  Delete existing entries
		$em = $this->getEntityManager();
		
        // Note down the job id's that we are about to delete (our 'delete list')
        $delrecs = $em->createQuery("SELECT fj.jobId FROM AppBundle:FormJobs fj WHERE fj.employerId=:eid AND fj.formId = :fid")
			->setParameters(array("eid"=>$employer_id, "fid"=>$form_id))
			->getResult();
		$del_list = [];
		foreach($delrecs as $null=>$d) { $del_list[] = $d['jobId']; }
		
        $em->createQuery("DELETE FROM AppBundle:FormJobs fj WHERE fj.employerId=:eid AND fj.formId = :fid")
			->setParameters(array("eid"=>$employer_id, "fid"=>$form_id))
			->getResult();
		
		// Save new entries
		$add_list = [];
		foreach($data as $fld=>$val)
		{
			if(substr($fld,0,2)=='op')
			{
				$jobid = substr($fld,2);
				$add_list[] = $jobid;
				$fj = new FormJobs();
				$fj->setJobId($jobid);
				$fj->setEmployerId($employer_id);
				$fj->setFormId($form_id);
				$em->persist($fj);
				$em->flush();
			}
		}

		//  Job Id's in add_list and not in del_list are being added
		foreach($add_list as $jobId)
		{
			if(!in_array($jobId,$del_list)) $this->assignFormToUsersJobs($form_id, $jobId);
		}

		//  Job Id's in del_list and not in add_list are being deleted
		foreach($del_list as $jobId)
		{
			if(!in_array($jobId,$add_list)) $this->removeFormFromUsersJobs($form_id, $jobId);
		}
    }
	
	 
	//----------------------------------------------------------------------------------
	//  Delete requested form and associated questions
	//----------------------------------------------------------------------------------

	public function remove($form_id, $employer_id)
    {
		//  Delete existing entries
		$em = $this->getEntityManager();
		$test = $em->getRepository('AppBundle:Forms')->findOneBy(['id'=>$form_id, 'employerId'=>$employer_id]);
		if($test->getId()==$form_id)
		{
			$em->createQuery("DELETE FROM AppBundle:Forms f WHERE f.id = :id")
				->setParameters(array("id"=>$form_id))
				->getResult();
			$em->createQuery("DELETE FROM AppBundle:FormQuestions fq WHERE fq.formId = :id")
				->setParameters(array("id"=>$form_id))
				->getResult();
		}
	}
	
	
	//----------------------------------------------------------------------------------
	//  Get list of testabl tests for this job/user (numeric job id)
	//  NOTE: Will auto-finish any tests abandoned (eg status STARTED)
	//----------------------------------------------------------------------------------

	public function getTestablList($user_id, $job_id)
    {
		$sql = "SELECT fu.id,fu.employerId, f.formName, f.formType, f.numQuestions, fc.score, fc.maxScore, fu.status
			FROM AppBundle:FormUserJobs fu 
			LEFT JOIN AppBundle:FormCompleted fc WITH fu.formId = fc.formId AND fc.userId=:uid
			LEFT JOIN AppBundle:Forms f WITH fu.formId = f.id
			WHERE fu.jobId = :jobid AND fu.userId = :uid
			ORDER BY f.formName";

		$em = $this->getEntityManager();
		$res = $em->createQuery($sql)
			->setParameters(array("uid"=>$user_id, "jobid"=>$job_id))
			->getResult();
	
		foreach($res as $idx=>$r)
		{
			if($r['status']=='STARTED')
			{
				$res[$idx]['status'] = 'COMPLETED';
				$fuj = $em->getRepository('AppBundle:FormUserJobs')->findOneBy(['id'=>$r['id']]);
				$fuj->setStatus('COMPLETED');
				$em->persist($fuj);
				$em->flush();
			}
		}
		return $res;
	}
	

	//----------------------------------------------------------------------------------
	//  Get user/job pre-screen status
	//----------------------------------------------------------------------------------
	
	public function getUserJobPrescreenStatus($userid, $employerid, $jobcode)
	{
		//  Query the form an form_completed tables. A record in the form table
		//  means a pre-screen form is requried for this job. A record in the second
		//  table means the user has completed.
		//  Returns: 
		//    No record = no pre-screen form
		//	  Record, null score = pre-screen form required, user not completed
		//	  Record, with score = pre-screen form required and user completed
		
		$sql = "SELECT f.id, fc.score, fc.userId AS c_user_id FROM AppBundle:Forms f LEFT JOIN AppBundle:FormCompleted fc WITH f.id = fc.formId AND fc.userId = :uid
			WHERE f.formType = 'PRESCREEN' AND f.employerId = :eid AND f.jobId = :jid AND f.numQuestions <> 0";

		$em = $this->getEntityManager();
		$res = $em->createQuery($sql)
			->setParameters(array("uid"=>$userid, "eid"=>$employerid, "jid"=>$jobcode))
			->getResult();
		return (empty($res[0])) ? null : $res[0];
	}


	
	//----------------------------------------------------------------------------------
	//  Assign this job/form to all candidates who have applied for this job
	//----------------------------------------------------------------------------------
	
	public function assignFormToUsersJobs($form_id, $jobid)
	{
		//  From the job code, get a list of users that have applied for this job (from users_job)
		//  From that, ignore users that already have this form assigned for this job (a record in form_user_jobs)
		//  Any candidates that do NOT have a record in fuj, create one.

		$em = $this->getEntityManager();
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['id'=>$jobid]);
		$jobcode = $job->getUniqueid();
		$employer_id = $job->getEmployerId();
		
		$sql = "SELECT uj.userId, j.id AS jobid, fuj.id AS fuj_id
			FROM AppBundle:UsersJob uj 
			LEFT JOIN AppBundle:Jobs j WITH uj.jobId = j.uniqueid
			LEFT JOIN AppBundle:FormUserJobs fuj WITH j.id = fuj.jobId AND uj.userId = fuj.userId AND fuj.formId = :fid
			WHERE uj.jobId = :jid";
		
		$em = $this->getEntityManager();
		$res = $em->createQuery($sql)
			->setParameters(array("jid"=>$jobcode, "fid"=>$form_id))
			->getResult();
		
		//  Read through each record, and where fuj_id is null (= no fuj record), then create the fuj record
		//print "<pre>"; var_dump($res); die("dbg - $jobcode");
		foreach($res as $idx=>$r)
		{
			if(!empty($r['fuj_id'])) continue;
			$fuj = new \AppBundle\Entity\FormUserJobs();
			$fuj->setEmployerId($employer_id);
			$fuj->setUserId($r['userId']);
			$fuj->setFormId($form_id);
			$fuj->setJobId($jobid);
			$em->persist($fuj);
			$em->flush();
		}
	}

	
	//----------------------------------------------------------------------------------
	//  Remove this job/form from all candidates who have applied for this job
	//----------------------------------------------------------------------------------
	
	public function removeFormFromUsersJobs($form_id, $jobid)
	{
		//  Only remove if the form status is NOT STARTED
		$em = $this->getEntityManager();
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['id'=>$jobid]);
		$jobcode = $job->getUniqueid();
		
		$sql = "DELETE FROM AppBundle:FormUserJobs fuj WHERE fuj.formId=:fid AND fuj.jobId = :jid AND (fuj.status IS NULL OR fuj.status='NOT STARTED') ";
		$em = $this->getEntityManager();
		$res = $em->createQuery($sql)
			->setParameters(array("fid"=>$form_id, "jid"=>$jobid))
			->getResult();
	}
}
