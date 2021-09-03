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


class PersonablAdminController extends Controller
{
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/personabladmin/manage/{id}", defaults={"id"=0}, name="personabladmin_manage")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function manageAction(Request $request)
    {
		$id = $request->get('id');
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		
		if(NULL == $user->getFirstname()) return $this->redirect('/logout');
		if(NULL == $user->getEmployerId()) return $this->redirect('/logout');

		$jobs = $em->getRepository('AppBundle:Jobs')->getJoblistByEmployer($employer_id);
		
		// Get employer_id from the subdomain
		$wl = $em->getRepository('AppBundle:CssSchemes')->getEmployerIdFromDomain();

		//  Load the questions from the database
		$recs = null;
		$show = false;
		if($id)
		{
			$recs = $em->getRepository('AppBundle:VideoQuestions')->getListByJobId($id);
			$show = true;
		}
		
		return $this->render('@App/personabladmin/manage.html.twig', array(
			'jobs'	=> $jobs,
			'questions' => $recs,
			'id' => $id,
			'jobid' => $id,
			'show' => $show,
			'dateNow' => date("Y-m-d H:i:s"),
			'companyName' => $wl['company_name'],
		));
	}
	
	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/personabladmin/edit/{jobid}/{qid}", name="personabladmin_edit")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
		$qid = $request->get('qid');
		$jobid = $request->get('jobid');
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		// TODO:make sure this admin user owns the job associated with this question

		if($qid>0)	$vq = $em->getRepository('AppBundle:VideoQuestions')->findOneBy(array('id' => $qid));
		else		$vq = new \AppBundle\Entity\VideoQuestions();
		
		//  If POSTed, update/delete the record and return to the question list
		if($_POST)
		{
			if($_POST['sbm']=='Delete')
			{
				$mediaId = $vq->getMediaId();
				$mediapath = $this->getParameter('media_full_path');
				$em->getRepository('AppBundle:Media')->deleteMediaFile($mediaId, $mediapath);
				$em->remove($vq);
				$em->flush();
			}
			else
			{
				$vq->setJobId($em->getRepository('AppBundle:Jobs')->getJobCodeFromId($jobid));
				$vq->setQuestion($_POST['question']);
				$vq->setActive($_POST['active']);
				$vq->setVideo($_POST['video']);
				if($qid==0) $vq->setCreatedOn(new \DateTime("now"));
				$em->persist($vq);
				$em->flush();
			}
			return $this->redirect("/personabladmin/manage/$jobid");
		}

		
		return $this->render('@App/personabladmin/edit.html.twig', array(
			'vq' => $vq,
		));
	}

	
		
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/personabladmin/results/{id}", defaults={"id"=0}, name="personabladmin_results")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultsAction(Request $request)
    {
		$id = $request->get('id');
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		if(NULL == $user->getFirstname()) return $this->redirect('/logout');
		if(NULL == $user->getEmployerId()) return $this->redirect('/logout');

		$jobs = $em->getRepository('AppBundle:Jobs')->getJoblistByEmployer($employer_id);
		
		// Get employer_id from the subdomain
		$em = $this->getDoctrine()->getManager();
		$wl = $em->getRepository('AppBundle:CssSchemes')->getEmployerIdFromDomain();

		//  Load the questions from the database
		$answers = null;
		if($id)
		{
			$answers = $em->getRepository('AppBundle:VideoAnswers')->getListByJobId2($id);
		}
//print "<pre>"; var_dump($recs); die;
		return $this->render('@App/personabladmin/results.html.twig', array(
			'jobs'		=> $jobs,
			'answers'	=> $answers,
		));
	}
}
