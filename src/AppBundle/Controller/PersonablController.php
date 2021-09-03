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


class PersonablController extends Controller
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
     * @Route("/personabl/{jobid}", name="personabl")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
		$this->_checkValidUser();
		$job_id = $request->get('jobid');
		$user = $this->getUser();
		$user_id = $user->getId();
		$em = $this->getDoctrine()->getManager();

		// Verify this user is currently applying for this job.
		$uj = $em->getRepository('AppBundle:UsersJob');
		$res = $uj->verifyCandidateJobApplication($user_id, $job_id);
		if($res==false) {
			return $this->redirect('/jobs/selection');
		}

		$job = $em->getRepository('AppBundle\Entity\Jobs')->findOneBy(array('uniqueid' => $job_id));
		$jobtitle = $job->getTitle();
		
		$num_answered=0;
		$recs = $em->getRepository('AppBundle:VideoAnswers')->getList($job_id, $user_id);
		for($i=0; $i<count($recs); $i++)
		{
			$file = "";
			// TODO; check media() for existing answers
			if(file_exists($file)) { $num_answered++; $recs[$i]['answered']=1; } else $recs[$i]['answered']=0;
		}
		$pct = (100 / count($recs)) * $num_answered;
		//  Display
		return $this->render('@App/personabl/index.html.twig', array(
			'questions' => $recs,
			'jobtitle' => $jobtitle,
			'jobid' => $job_id,
		));
	}
}
