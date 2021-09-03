<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\FormAnswers;
use AppBundle\Entity\FormAnswersRepository;



class FormQuestionsRepository extends EntityRepository
{
	//----------------------------------------------------------------------------------
	//  Build answer table
	//----------------------------------------------------------------------------------

	public function buildAnswersTable($form_id, $user_id)
	{
		$em = $this->getEntityManager();

		//  Modify the form_user_jobs table status to 'STARTED'
		$fuj = $em->getRepository('AppBundle:FormUserJobs')->findOneBy(['formId'=>$form_id, 'userId'=>$user_id]);
		$fuj->setStatus('STARTED');
		$em->persist($fuj);
		$em->flush();
			
		//  First, remove any duplicate (old) rows from form_answers (shouldnt normally happen, but does during testing)
		$em->createQuery('DELETE FROM AppBundle:FormAnswers f WHERE f.formId=:formId AND f.userId=:userId ')
			->setParameters(array("formId"=>$form_id, "userId"=>$user_id))
			->execute();
		
		//  Second, fetch all the questions (from both normal and pool) and combine in to one list in the form_answers table
		$em= $this->getEntityManager();
		$recs = $em->getRepository('AppBundle:FormQuestions')->findBy(['formId'=>$form_id], array('seq'=>'ASC'));
		$n=1;
		mt_srand();
		$questions = array();
		foreach($recs as $idx=>$rec)
		{
			if($rec->getQuestionType()<>'POOL')
			{
				$fa = new FormAnswers();
				$fa->setFormId($form_id);
				$fa->setUserId($user_id);
				$fa->setSeq($n);
				$fa->setQuestion($rec->getQuestion());
				$fa->setQuestionType($rec->getQuestionType());
				$fa->setSecs($rec->getSecs());
				$fa->setDataValues($rec->getDataValues());
				$fa->setScore(0);
				$fa->setMaxScore(0);
				if($fa->getQuestionType()=='SELECT') $fa->setMaxScore($this->getMaxScore($rec->getDataValues()));
				$em->persist($fa);
				$em->flush();
				$n++;
			}
			else
			{
				$poolrecs = $em->getRepository('AppBundle:FormPoolQuestions')->findBy(['poolId'=>$rec->getPoolId()], array('seq'=>'ASC'));
				$max = count($poolrecs);
				$poolQuestions=$rec->getPoolQuestions();
				if($poolQuestions()>$max) $poolQuestions=$max;
				$got = array();
				for($j=0; $j<$poolQuestions; $j++)
				{
					for(;;)	// grab a random (previously unpicked) field from the list...
					{
						$k = rand(0,$max-1);
						if(in_array($k,$got)) continue;
						$got[] = $k; break;
					}

					$fa = new FormAnswers();
					$fa->setFormId($form_id);
					$fa->setUserId($user_id);
					$fa->setSeq($n); 
					$fa->setQuestion($poolrecs[$k]->getQuestion());
					$fa->setQuestionType($poolrecs[$k]->getQuestionType());
					$fa->setPoolId($recs->getPoolId());
					$fa->setPoolQuestionId($poolrecs[$k]->getId());
					$fa->setSecs($poolrecs[$k]->getSecs());
					$fa->setScore(0);
					$fa->setDataValues($poolrecs[$k]->getDataValues());
					$fa->setMaxScore(0);
					if($fa->getQuestionType()=='SELECT') setMaxScore($this->getMaxScore($poolrecs[$k]->getDataValues()));
					$em->persist($fa);
					$em->flush();
					$n++;
				}
			}
		}
	}

	
	//----------------------------------------------------------------------------------
	//  Find the maximum score in a multiple choice answer array
	//----------------------------------------------------------------------------------
	
	private function getMaxScore($choices)
	{
		$max_score = 0;
		$dv = strtr($choices, array('&#10;'=>"\n"));
		$dv = explode("\n",$dv);
		foreach($dv as $row)
		{
			$ans_v = explode("--",$row);
			if($ans_v[0] > $max_score) $max_score = $ans_v[0];
		}
		return $max_score;
	}


	//----------------------------------------------------------------------------------
	//  Build form HTML
	//----------------------------------------------------------------------------------

	public function buildFormHtml($form_id, $user_id)
	{
		//  First, remove any duplicate (old) rows from form_answers (shouldnt normally happen, but does during testing)
		$this->getEntityManager()
			->createQuery('DELETE FROM AppBundle:FormAnswers f WHERE f.formId=:formId AND f.userId=:userId ')
			->setParameters(array("formId"=>$form_id, "userId"=>$user_id))
			->execute();

		
		//  Second, fetch all the questions (from both normal and pool) and combine in to one list in the form_answers table
		$em= $this->getEntityManager();
		$recs = $em->getRepository('AppBundle:FormQuestions')->findBy(['formId'=>$form_id], array('seq'=>'ASC'));
		$n=1;
		mt_srand();
		$questions = array();
		foreach($recs as $idx=>$rec)
		{
			if($rec->getQuestionType()<>'POOL')
			{
				$fa = new FormAnswers();
				$fa->setFormId($form_id);
				$fa->setUserId($user_id);
				$fa->setSeq($n);
				$fa->setQuestion($rec->getQuestion());
				$fa->setQuestionType($rec->getQuestionType());
				$fa->setSecs($rec->getSecs());
				$fa->setDataValues($rec->getDataValues());
				$em->persist($fa);
				$em->flush();
				$n++;
			}
			else
			{
				$poolrecs = $em->getRepository('AppBundle:FormPoolQuestions')->findBy(['poolId'=>$rec->getPoolId()], array('seq'=>'ASC'));
				$max = count($poolrecs);
				$poolQuestions=$rec->getPoolQuestions();
				if($poolQuestions()>$max) $poolQuestions=$max;
				$got = array();
				for($j=0; $j<$poolQuestions; $j++)
				{
					for(;;)	// grab a random (previously unpicked) field from the list...
					{
						$k = rand(0,$max-1);
						if(in_array($k,$got)) continue;
						$got[] = $k; break;
					}

					$fa = new FormAnswers();
					$fa->setFormId($form_id);
					$fa->setUserId($user_id);
					$fa->setSeq($n); 
					$fa->setQuestion($poolrecs[$k]->getQuestion());
					$fa->setQuestionType($poolrecs[$k]->getQuestionType());
					$fa->setPoolId($recs->getPoolId());
					$fa->setPoolQuestionId($poolrecs[$k]->getId());
					$fa->setSecs($poolrecs[$k]->getSecs());
					$fa->setDataValues($poolrecs[$k]->getDataValues());
					$em->persist($fa);
					$em->flush();
					$n++;
				}
			}
		}

		
		//  Third, loop through the normalized question set (in form_answers) and build the html form
		
		$html = '<div class="fbtable">';

		$recs = $em->getRepository('AppBundle:FormAnswers')->findBy(['formId'=>$form_id, 'userId'=>$user_id], ['seq'=>'ASC']);
		foreach($recs as $rec)
		{
			$html .= '<div class="tr">';
			$html .= "<div class='td'>{$rec->getQuestion()}</div>";
			$html .= "<div class='td'>";
			$fieldname = 'seq'.$rec->getSeq();

			switch ($rec->getQuestionType())
			{
				case 'TEXT':
					$html .= "<input type='text' name='$fieldname'/>";
					break;
				case 'DATE':
					$html .= "<input type='text' name='$fieldname' class='datepicker'/>";
					break;
				case 'TEXTAREA':
					$html .= "<textarea name='$fieldname'></textarea>";
					break;
				case 'SELECT':
					$html .= "<select name='$fieldname'/>";
					$vals = strtr($rec->getDataValues(), array('&#10;'=>"\n"));
					$valuesets = explode("\n",$vals);
					$n=1;

					foreach($valuesets as $idx=>$valueset)
					{
					    if (!empty($valueset)) {
                            $v = explode('--', $valueset, 2);

                            $html .= "<option value='$n'>{$v[1]}</option>";
                            $n++;
                        }
					}
					$html .= "</select>";
					break;
				default:
					die('Unknown formbuilder field type:'.$rec->getQuestionType());
			}
			
			$html .= "</div>";
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
    }
	
	
	//----------------------------------------------------------------------------------
	//  Update question count (called after add/delete of form questions)
	//----------------------------------------------------------------------------------

	public function updateQuestionCount($form_id)
	{
		$em= $this->getEntityManager();

		$rec = $em->createQuery('SELECT COUNT(1) AS c FROM AppBundle:FormQuestions f WHERE f.formId=:formId')
			->setParameters(array("formId"=>$form_id))
			->getResult();
		file_put_contents("/tmp/c", $form_id . '--' . var_export($rec,true));
		$count = $rec[0]['c'];
		
		$em->createQuery("UPDATE AppBundle:Forms f SET f.numQuestions = :c WHERE f.id = :id")
			->setParameters(array('c'=>$count, 'id'=>$form_id))
			->getResult();

	}

	
	//----------------------------------------------------------------------------------
	//  Sort questions in database (according to how were dragged)
	//----------------------------------------------------------------------------------
	
	public function sortQuestions($form_id, $positions)
	{
		$pos=1;
		$arr_pos = explode(",",$positions);
		foreach($arr_pos as $p)
		{
			$id = substr($p,1);
			if($id==0) continue;
			$this->getEntityManager()->createQuery("UPDATE AppBundle:FormQuestions fq SET fq.seq=$pos WHERE fq.formId=$form_id AND fq.id=$id")->execute();
			$pos++;
		}
	}
}

