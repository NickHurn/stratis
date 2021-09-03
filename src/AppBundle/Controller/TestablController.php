<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\UsersJob;
use AppBundle\Entity\Jobs;


class TestablController extends Controller
{
	private function _checkValidUser()
	{
		// Checked we are logged on and as a user
		$user = $this->getUser();
		if(NULL == $user->getFirstname()) return $this->redirect('/logout');
		if(NULL <> $user->getEmployerId()) return $this->redirect('/admin');
	}

	
	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/testabl/{jobcode}", name="testabl")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
		$this->_checkValidUser();
		$job_code = $request->get('jobcode');
		$user = $this->getUser();
		$user_id = $user->getId();
		$em = $this->getDoctrine()->getManager();

		// Verify this user is currently applying for this job.
		$uj = $em->getRepository('AppBundle:UsersJob');
		$res = $uj->verifyCandidateJobApplication($user_id, $job_code);
		if($res==false) {
			return $this->redirect('/jobs/selection');
		}

		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$job_code]);
		$job_id = $job->getId();
		$jobtitle = $job->getTitle();
		
		
		$tests = $em->getRepository('AppBundle:Forms')->getTestablList($user_id, $job_id);
		
		$count=0; $completed=0; $percent=null;
		foreach($tests as $test)
		{
			$count++;
			if($test['maxScore']!==null) $completed++;
		}
		if($count) $percent = round($completed/$count*100);
		
		return $this->render('@App/testabl/index.html.twig', array(
			'tests' => $tests,
			'jobtitle' => $jobtitle,
			'show' => 1,
			'pct' => $percent,
			'dateNow' => date("Y-m-d H:i:s"),
			'companyName' => 'TonyCorp', // TODO $wl['company_name'],
		));
	}
	
	
	/**
	 * Loads and starts a test for a user
	 * 
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/testabl/test/{testid}", name="testabl_test")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testAction(Request $request)
    {
		$this->_checkValidUser();
		$testid = $request->get('testid');
		$user = $this->getUser();
		$user_id = $user->getId();
		$em = $this->getDoctrine()->getManager();

		// Verify this user is assigned to this job and test
		$jobcode=null;
		$fuj = $em->getRepository('AppBundle:FormUserJobs')->findOneBy(['id'=>$testid, 'userId'=>$user_id]);
		if(!$fuj)
		{
			return $this->render('@App/error/usererror.html.twig', array(
				'title' => 'Invalid Request',
				'msg' => 'You have tried to visit a link to complete a test, which is not valid.'
			));
		}
		
		// Check to see if the test has already been completed
		$fc = $em->getRepository('AppBundle:FormAnswers')->findOneBy(['formId'=>$fuj->getFormId(), 'userId'=>$user_id]);
		if($fc)
		{
			return $this->render('@App/error/usererror.html.twig', array(
				'title' => 'Test Already Completed',
				'msg' => 'You have already completed this test.'
			));
		}

		
		// Load the test frame page

		$form = $em->getRepository('AppBundle:Forms')->findOneBy(['id'=>$fuj->getFormId()]);
		return $this->render('@App/testabl/starttest.html.twig', array(
			'title' => $form->getFormName(),
			'questionCount' => $form->getNumQuestions(),
			'time' => ceil($form->getNumQuestions()*0.5),
			'testid' => $testid,
		));
	}


	/**
	 *  Reset test. This will clear/copy the answers for this test
	 * 
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/testabl/resettest/{testid}", name="testabl_resettest")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resetTestAction(Request $request)
    {
		$this->_checkValidUser();
		$testid = $request->get('testid');
		$user = $this->getUser();
		$user_id = $user->getId();
		$em = $this->getDoctrine()->getManager();

		// Verify this user is assigned to this job and test
		$jobcode=null;
		$fuj = $em->getRepository('AppBundle:FormUserJobs')->findOneBy(['id'=>$testid]);
		if(!$fuj)
		{
			print 'FAIL';
			die;
		}
		$form_id = $fuj->getFormId();
		
		$fq = $em->getRepository('AppBundle:FormQuestions')->buildAnswersTable($form_id, $user_id);
		print "OK";
		die;
	}

	
	/**
	 *  Retrieves next question for answering
	 * 
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/testabl/test/{testid}/nextquestion/{seq}/{lastanswer}", name="testabl_nextquestion")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nextQuestionAction(Request $request)
    {
		$this->_checkValidUser();
		$testid = $request->get('testid');
		$lastanswer = $request->get('lastanswer');
		$seq = $request->get('seq');
		$user = $this->getUser();
		$this_user_id = $user->getId();
		$em = $this->getDoctrine()->getManager();
		$lastseq = $seq-1;
		
		//  Verify this user is assigned to this job and test
		$jobcode=null;
		$fuj = $em->getRepository('AppBundle:FormUserJobs')->findOneBy(['id'=>$testid]);
		if(!$fuj)
		{
			print json_encode(array('status'=>'FAIL'));
			die;
		}
		$form_id = $fuj->getFormId();
		$user_id = $fuj->getUserId();
		$job_id = $fuj->getJobId();
		if($this_user_id <> $user_id) { print json_encode(array('status'=>'FAIL', 'reason'=>2)); die; }

		//  If this is first request, reset the answers table
		if($lastseq==0)
		{
			$fq = $em->getRepository('AppBundle:FormQuestions')->buildAnswersTable($form_id, $user_id);
		}
		
		
		//  If an answer for last question supplied, update it.
		if($lastseq>0)
		{
			$fa = $em->getRepository('AppBundle:FormAnswers')->findOneBy(['formId'=>$form_id, 'userId'=>$user_id, 'seq'=>$lastseq]);
			if(!$fa) { print json_encode(array('status'=>'FAIL', 'reason'=>3)); die; }
			if($fa->getQuestionType()=='SELECT')
			{
				$dv = strtr($fa->getDataValues(), array('&#10;'=>"\n"));
				$dv = explode("\n",$dv);
				$ans_row = $dv[$lastanswer];
				$ans_v = explode("--",$ans_row);
				$fa->setAnswer($ans_v[1]);
				$fa->setScore($ans_v[0]);
				$fa->setAnswerIdx($lastanswer);
			}
			else
			{
				$fa->setAnswer($lastanswer);
				$fa->setScore(0);
			}
			$em->persist($fa);
			$em->flush($fa);
		}

		// Fetch the next question
		$fa = $em->getRepository('AppBundle:FormAnswers')->findOneBy(['formId'=>$form_id, 'userId'=>$user_id, 'seq'=>$seq]);
		if(!$fa)
		{
			//  Calculate scores and create form_completed record
			$sql = "SELECT SUM(fa.score) AS score, SUM(fa.maxScore) AS maxscore FROM AppBundle:FormAnswers fa WHERE fa.formId=:fid AND fa.userId=:uid";
			$result = $em->createQuery($sql)
				->setParameters(array('uid'=>$user_id, 'fid'=>$form_id))
				->getResult();
			$f = $em->getRepository('AppBundle:Forms')->findOneBy(['id'=>$form_id]);
			
			$fc = new \AppBundle\Entity\FormCompleted();
			$fc->setFormId($form_id);
			$fc->setUserId($user_id);
			$fc->setDtCompleted(new \DateTime(now));
			$fc->setScore($result[0]['score']);
			$fc->setMaxScore($result[0]['maxscore']);
			$fc->setPassScore($f->getPassScore());
			$em->persist($fc);
			$em->flush($fc);

			//  Update FUJ to say finished
			$fuj->setStatus('COMPLETED');
			$em->persist($fuj);
			$em->flush();
			
			//  Finish up
			$html = "<h2>Test Completed</h2>";
			$html .= "Thank you. Please return to your <a href='/candidate/home'>home page</a> to continue with your application.";
			$res['HTML'] = $html;
			$res['STATUS']="END";
			print json_encode($res);
			die;
		}
		
		$res['STATUS']="OK";
		$res['QTOT'] = $em->getRepository('AppBundle:FormAnswers')->getQuestionCount($form_id, $user_id);
		$res['SEQ'] = $fa->getSeq();
		$res['Q'] = $fa->getQuestion();
		$res['QT'] = $fa->getQuestionType();
		$dv = $fa->getDataValues();
		if($dv) {
			$dv = strtr($dv, array('&#10;'=>"\n"));
			$dva = explode("\n",$dv);
			$n=1;
			foreach($dva as $line)
			{
				$tmp = explode("--",$line);
				if(empty($tmp[1])) break;
				$res["A{$n}"] = $tmp[1];
				$n++;
			}
		}

		$html = "<h2>Question {$res['SEQ']} of {$res['QTOT']}: {$res['Q']}</h2>";
		$html .= "<div style='margin:30px 0'>";

		switch ($res['QT'] )
		{
			case 'TEXT':
				$html .= "<input type='text' id='ans' name='ans'>";
				break;

			case 'TEXTAREA':
				$html .= "<textarea cols='50' rows='4' id='ans' name='ans'></textarea>";
				break;
				
			case 'SELECT':
				for($i=1; $i<100; $i++)
				{
					if(empty($res["A{$i}"])) break;
					$txt = $res["A{$i}"];
					$html .= "<input type='checkbox' id='ans' name='ans' value='$i'> $txt<br/>";
				}
				break;
		}
		
		$html .= "</div>";
		$html .= "<a href='javascript:nextquestion()' class='btn btn-black btn-lg'>Submit Answer</a>";
		$res['HTML'] = $html;
		print json_encode($res);
		die;
	}

	
}
