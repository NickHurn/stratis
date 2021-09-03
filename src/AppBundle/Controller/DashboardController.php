<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;


class DashboardController extends Controller
{
    /**
     * @Route("/dashboard/percentagefilledvacancies", name="dashboard_percentagefilledvacancies")
     */
    public function percentagefilledvacanciesAction(Request $request)
    {
		print "[[1,2,3,4,5,6],[0,0,0,0,0,0]]";
		die;
	}
	
	
	/**
     * @Route("/dashboard/percentageinterviews", name="dashboard_percentageinterviews")
     */
    public function percentageinterviewsAction(Request $request)
    {
		print "[0,100]";
		die;
	}
	
	
	/**
     * @Route("/dashboard/timetorecruit", name="dashboard_timetorecruit")
     */
    public function timetorecruitAction(Request $request)
    {
		print "99";
		die;
	}

	/**
     * @Route("/dashboard/saveconfig", name="dashboard_saveconfig")
     */
	public function saveconfigAction(Request $request)
	{
		$user = $this->getUser();
		$user_id = $user->getId();
		if(empty($user_id))
		{
			print "NOAUTH";
			exit;
		}
		$em = $this->getDoctrine()->getManager();		
		$data = $request->get('data');
		$job_id = $request->get('job_id');
		$overview_config = (empty($job_id)) ? true:false;
		$em->getRepository('AppBundle:DashboardConfig')->saveDashboardLayout($user_id, $overview_config, $data);
		print "OK";
		exit;
	}
	
}


