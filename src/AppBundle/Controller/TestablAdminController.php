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
use AppBundle\Entity\ClassmarkerLinks;
use AppBundle\Entity\ClassmarkerLinksRepository;
use AppBundle\Entity\Forms;
use AppBundle\Form\InfoEdit;


class TestablAdminController extends Controller
{
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/tests", name="testabladmin_testlist")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testlistAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();

		//  If we POSTed here, create new form and re-direct here
		if($_POST)
		{
			$form_name = filter_input(INPUT_POST, 'formname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$em = $this->getDoctrine()->getManager();
			$f = new Forms();
			$f->setFormName($form_name);
			$f->setFormType('TEST');
			$f->setEmployerId($employer_id);
			$f->setNumQuestions(0);
			$f->setTimeLimit(0);
			$f->setPassScore(0);
			$em->persist($f);
			$em->flush();
			return $this->redirect("/testabladmin/tests");
		}

		$forms = $em->getRepository('AppBundle:Forms')->getTestList($employer_id);
		return $this->render('@App/testabladmin/testlist.html.twig', array(
			'forms' => $forms
		));
    }

	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/pools", name="testabladmin_poollist")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function poollistAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		
		
		//  If we POSTed here, create new form and re-direct here
		if($_POST)
		{
			$form_name = filter_input(INPUT_POST, 'formname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$em->getRepository('AppBundle:Pools')->createOrFetchPool($form_name, $employer_id);
			return $this->redirect("/testabladmin/pools");
		}

		$pools = $em->getRepository('AppBundle:Pools')->getList($employer_id);
		
		return $this->render('@App/testabladmin/poollist.html.twig', array(
			'pools' => $pools,
		));
    }


	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/results", name="testabladmin_results")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultshowAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		$id = $request->get('id');
		
		$jobs = $em->getRepository('AppBundle:Jobs')->getJoblistByEmployer($employer_id);
		
		return $this->render('@App/testabladmin/resultshow.html.twig', array(
			'id' => $id,
			'jobs' => $jobs,
			'results' => null,
			'show' => 0
		));
    }


		/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/results/{id}", name="testabladmin_results_id")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultshow2Action(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		$id = $request->get('id');
		
		$results = $em->getRepository('AppBundle:FormAnswers')->getTestablResultSummary($id);

		$jobs = $em->getRepository('AppBundle:Jobs')->getJoblistByEmployer($employer_id);

		return $this->render('@App/testabladmin/resultshow.html.twig', array(
			'id' => $id,
			'jobs' => $jobs,
			'results' => $results,
			'show' => 1
		));
    }

	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/assign", defaults={"id"=0}, name="testabladmin_assignlist")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function assignlistAction(Request $request)
    {
		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();

		$jobs = $em->getRepository('AppBundle:Forms')->getFormsByJobList($employer_id);
		return $this->render('@App/testabladmin/assignlist.html.twig', array(
			'jobs'	=> $jobs,
		));
    }


	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/assigned/{jobcode}", name="testabladmin_assigned")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function assignedlistAction(Request $request)
    {
		$job_code = $request->get('jobcode');
		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		$job_id = $em->getRepository('AppBundle:Jobs')->getIdFromJobCode($job_code);

		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$job_code]);
		$tests = $em->getRepository('AppBundle:Jobs')->getTestList($employer_id, $job_id);

		return $this->render('@App/testabladmin/assigned.html.twig', array(
			'title'	=> $job->getTitle(),
			'tests' => $tests,
		));
    }

	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/assign/{id}", name="testabladmin_assign")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function assignAction(Request $request)
    {
		$form_id = $request->get('id');
		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();

		if($_POST)
		{ 
			$em->getRepository('AppBundle:Forms')->saveAssignedJobs($employer_id, $form_id, $_POST);
			return $this->redirect('/testabladmin/assign');
		}
		
		$form = $em->getRepository('AppBundle:Forms')->findOneBy(["id"=>$form_id]);
		$form_name = $form->getFormName();
		$jobs = $em->getRepository('AppBundle:Forms')->getJobListForForm($employer_id, $form_id);
	
		return $this->render('@App/testabladmin/assign.html.twig', array(
			'jobs'		=> $jobs,
			'form_name'	=> $form_name,
		));
    }

	
	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/edittest/{form_id}", name="testabladmin_edittest")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edittestAction(Request $request)
    {
		$form_id = $request->get('form_id');
		$user = $this->getUser();
		$user_id = $user->getid();
		$employer_id = $user->getEmployerId();
		if(NULL == $employer_id) return $this->redirect('/logout');
		// TODO: verify this form is owned by this employer
		
		$em = $this->getDoctrine()->getManager();
		$form = $em->getRepository('AppBundle:Forms')->findOneBy(['id'=>$form_id]);
		
		return $this->render('@App/testabladmin/edittest.html.twig', array(
			'title' => $form->getFormName(),
			'formid' => $form->getId(),
		));
    }

	

	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/editpool/{pool_id}", name="testabladmin_editpool")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editpoolAction(Request $request)
    {
		$pool_id = $request->get('pool_id');
		$user = $this->getUser();
		$user_id = $user->getid();
		$employer_id = $user->getEmployerId();
		if(NULL == $employer_id) return $this->redirect('/logout');
		// TODO: verify this form is owned by this employer
		
		$em = $this->getDoctrine()->getManager();
		$pool = $em->getRepository('AppBundle:Pools')->findOneBy(['id'=>$pool_id]);
		return $this->render('@App/testabladmin/editpool.html.twig', array(
			'title' => $pool->getPoolName(),
			'poolid' => $pool_id,
		));
    }


	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/viewanswers/{jobid}/{testid}", name="testabladmin_viewanswers")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewanswersAction(Request $request)
    {
		$jobid = $request->get('jobid');
		$testid = $request->get('testid');
		$user = $this->getUser();
		$user_id = $user->getid();
		$employer_id = $user->getEmployerId();
		if(NULL == $employer_id) return $this->redirect('/logout');
		
		$em = $this->getDoctrine()->getManager();
		$fuj = $em->getRepository('AppBundle:FormUserJobs')->findOneBy(['jobId'=>$jobid, 'employerId'=>$employer_id, 'formId'=>$testid]);
		
		//  Verify its a valida test for this client
		if(!$fuj) {
			return $this->render('@App/error/error.html.twig', array(
				'title' => 'Invalid URL',
				'msg' => 'The link you have followed does not correspond to a valid test.'
			));
		}
		
		//  Verify the test is completed
		if($fuj->getStatus()<>'COMPLETED') {
			return $this->render('@App/error/error.html.twig', array(
				'title' => 'Cannot View Test',
				'msg' => 'The test you have selected has not been completed. Results cannot be viewed at this time.'
			));
		}
		
		//  Fetch form answers, Candidate Name, Job Name and Test Details
		$fa = $em->getRepository('AppBundle:FormAnswers')->findBy(['formId'=>$testid, 'userId'=>$fuj->getUserId()], ['seq'=>'ASC']);
		$cand = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$fuj->getUserId()]);
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['id'=>$jobid]);
		$test = $em->getRepository('AppBundle:Forms')->findOneBy(['id'=>$testid]);

		$pass_score = $test->getPassScore();
		$score = 0;
		$max_score = 0;
		foreach($fa as $f)
		{
			$score += $f->getScore();
			$max_score += $f->getMaxScore();
		}
		$pass_pcnt = round(($pass_score/$max_score)*100);
		$score_pcnt = round(($score/$max_score)*100);
		
		//  Display
		return $this->render('@App/testabladmin/viewanswers.html.twig', array(
			'testname' => $test->getFormName(),
			'jobid' => $jobid,
			'candidatename' => $cand->getName(),
			'jobname'=> $job->getTitle(),
			'answers' => $fa,
			'pass_score' => $pass_score,
			'score' => $score,
			'max_score' => $max_score,
			'pass_pcnt' => $pass_pcnt,
			'score_pcnt' => $score_pcnt,
		));
    }


	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/editinfo/{testid}", name="testabladmin_editinfo")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editinfoAction(Request $request)
    {
		$testid = $request->get('testid');
		$user = $this->getUser();
		$user_id = $user->getid();
		$employer_id = $user->getEmployerId();
		if(NULL == $employer_id) return $this->redirect('/logout');
		
		$em = $this->getDoctrine()->getManager();
		$test = $em->getRepository('AppBundle:Forms')->findOneBy(['id'=>$testid, 'employerId'=>$employer_id, 'formType'=>'TEST']);
		
		$form = $this->createForm(InfoEdit::class, $test);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			if($_POST['info_edit']['save']==1) {
				$data = $form->getData();
				$em->persist($data);
				$em->flush();
			}
			if (isset($_POST['info_edit']['delete'])) {
                if ($_POST['info_edit']['delete'] == 1) {
                    $em->getRepository('AppBundle:Forms')->remove($testid, $employer_id);
                }
            }
			return $this->redirect("/testabladmin/tests");
		}

		return $this->render('@App/testabladmin/editinfo.html.twig', array(
			'test' => $test,
			'form' => $form->createView(),
		));
    }	

	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/testabladmin/clearanswers/{jobid}/{testid}", name="testabladmin_clearanswers")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function clearanswersAction(Request $request)
    {
		$jobid = $request->get('jobid');
		$testid = $request->get('testid');
		$user = $this->getUser();
		$user_id = $user->getid();
		$employer_id = $user->getEmployerId();
		if(NULL == $employer_id) return $this->redirect('/logout');
		
		$em = $this->getDoctrine()->getManager();
		$test = $em->getRepository('AppBundle:Forms')->findOneBy(['id'=>$testid, 'employerId'=>$employer_id, 'formType'=>'TEST']);
		
		//  Make sure the requested answer set belongs to the same employer_id as the user

		//  Clear records
		$em->getRepository('AppBundle:FormAnswers')->clearanswers($testid);
		
		//  Return to testabl view results
		return $this->redirect("/testabladmin/results/{$jobid}");
    }
	
}
