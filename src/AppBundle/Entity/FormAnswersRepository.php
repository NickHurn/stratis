<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;



class FormAnswersRepository extends EntityRepository
{
	//----------------------------------------------------------------------------------
	//  Save form answers
	//----------------------------------------------------------------------------------

	public function saveFormAnswers($form_id, $user_id, $answers)
	{

		//  This will update form_answers with those given by the user, update the score column, 
		//  and calculate the max_score and total score.
		$em= $this->getEntityManager();
		$total_score = 0;
		$max_score = 0;
        $select = null;
        $pass = false;
		foreach($answers as $idx=>$answer)
		{
			if(substr($idx,0,3)<>'seq') continue;
			$id = substr($idx,3);

			$ans = $em->getRepository('AppBundle:FormAnswers')->findOneBy(['formId'=>$form_id, 'userId'=>$user_id, 'seq'=>$id]);
			$q = $ans->getQuestionType();
			if($q=='SELECT')
			{
                $select = $select +1;
				//  For SELECT fields, the answer is an index in to the data_values (from 0 up). Update answer_idx with this
				//  index, but also the answer field with the text pulled from data_values. Also update the score column.

				$answer--; // Our list starts from offset 0, but the form returns the index from offset 1...

				$ans->setAnswerIdx($answer);


                //$dv = strtr($answer, array('&#10;'=>"\n"));
                //$dv = explode("\n",$ans->getDataValues());
                $options = explode(";",$ans->getDataValues());
                $dv= $options[$answer];
                $dv = explode("--",$dv);
                $score = $dv[0];
                $ans->setScore((int) $score);
                $ans->setAnswer($dv[1]);
                $max_question_score = 0;
                foreach($options as $dvline)
                {
                    $d = explode('--',$dvline,2);
                    if($d[0]>$max_question_score) $max_question_score = $d[0];
                }
                $total_score += $dv[0];
                $max_score += $max_question_score;
                $ans->setMaxScore($max_question_score);


				//$dv = strtr($answer, array('&#10;'=>"\n"));
				//$dv = explode("\n",$ans->getDataValues());

				//$line = explode('--',$dv[$answer],2);
				//$ans->setScore((int) $line[0]);
				//$ans->setAnswer($line[1]);

				//  Perform calcs for max_score and total_score
				//$max_question_score = 0;
                /*
				foreach($dv as $dvline)
				{
					$d = explode('--',$dvline,2);
					if($d[0]>$max_question_score) $max_question_score = $d[0];
				}

				$total_score += $line[0];
				$max_score += $max_question_score;
				$ans->setMaxScore($max_question_score);
                */
                $em->persist($ans);
                $em->flush();
			}
			else
			{
				// For non-select fields, the answer is simply the text answer to store.
				$ans->setAnswer($answer);
			}

		}

		//  Now create a form_completed record



        $formDetails = $em->getRepository('AppBundle:Forms')->find($form_id);
		if (is_null($select)){
            $percent = 100;
        }else {
            $percent = ($max_score == 0) ? 0 : round($total_score / $max_score * 100);
        }

		$fc = new FormCompleted();
		$fc->setFormId($form_id);
		$fc->setUserId($user_id);
		$fc->setDtCompleted(new \DateTime(date("Y-m-d H:i:s")));
		$fc->setScore($total_score);
		$fc->setMaxScore($max_score);
		$fc->setPercentage($percent);
		$fc->setPassScore($formDetails->getPassScore());
		$em->persist($fc);


		$userJob = $em->getRepository('AppBundle:UsersJob')->findOneBy(['jobId'=>$formDetails->getJobId(), 'userId'=>$user_id]);
		if ($percent >= $formDetails->getPassScore()){
		    $pass = true;
        }

		$userJob->setPreScreenPass($pass);
        $em->persist($userJob);

		$em->flush();
	}

	
	function getTestablResultSummary($job_id)
	{
		$sql = "SELECT fuj.id, fuj.userId, fuj.formId, f.formName, u.firstname, u.surname, fc.score, fc.maxScore, fc.percentage, fuj.status
			FROM AppBundle:FormUserJobs fuj
			LEFT JOIN AppBundle:Users u WITH fuj.userId = u.id
			LEFT JOIN AppBundle:FormCompleted fc WITH fuj.userId=fc.userId AND fuj.formId = fc.formId
			LEFT JOIN AppBundle:Forms f WITH fuj.formId = f.id
			WHERE fuj.jobId = :jobid AND fuj.status<>'NOT STARTED'
			ORDER BY u.firstname, u.surname, f.formName";

		$em = $this->getEntityManager();
		$res = $em->createQuery($sql)
			->setParameters(array("jobid"=>$job_id))
			->getResult();
		
		return $res;
	}
	

	function clearAnswers($fuj_id)
	{
		$em = $this->getEntityManager();
		$fuj = $em->getRepository('AppBundle:FormUserJobs')->findOneBy(['id'=>$fuj_id]);
		if(!$fuj) return;

		$user_id = $fuj->getUserId();
		$form_id = $fuj->getFormId();
		$fuj->setStatus('NOT STARTED');
		$em->persist($fuj);
		$em->flush();
		
		$sql = "DELETE FROM AppBundle:FormAnswers fa WHERE fa.formId='{$form_id}' AND fa.userId='{$user_id}'";
		//die("Q: $sql");
		$q = $em->createQuery($sql);
		$q->execute();
	}
	
	
	function getQuestionCount($form_id, $user_id)
	{
		$sql = "SELECT COUNT(1) AS c FROM AppBundle:FormAnswers fa WHERE fa.formId=:fid AND fa.userId=:uid";
		$em = $this->getEntityManager();
		$res = $em->createQuery($sql)
			->setParameters(array("fid"=>$form_id, "uid"=>$user_id))
			->getResult();
		return $res[0]['c'];
	}
}

