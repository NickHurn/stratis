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



class JobboardController extends Controller
{
	/**
     * @Route("/jobboard", name="jobboard")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
		// Get employer_id from the subdomain
		$em = $this->getDoctrine()->getManager();
		$wl = $em->getRepository('AppBundle:CssSchemes')->getEmployerIdFromDomain();

		// Search for all active jobs
		$jobs = $em->getRepository('AppBundle:Jobs')
          ->findBy(
             array('employerId'=> $wl['employer_id'], 'active'=>'1'), 
             array('startDate' => 'ASC')
		);

		$fmt_jobs = array();
		foreach($jobs as $job)
		{

			$fmt_jobs[] = array(
				'id'	=> $job->getId(),
                'title'	=> $job->getTitle(),
				'standfirst' => $job->getStandfirst(),
				'desc2' => $job->getDescription(),
				'uniqueId' => $job->getUniqueId(),
				'salary' => $job->getSalary(),
				'county' => $job->getCounty(),
				'startDate' => date('jS M Y',strtotime($job->getStartDate()->format('Y-m-d H:i:s'))),
				'dateAdded' => $job->getCreatedOn()->format('jS M Y'),
			);
		}

		return $this->render('@App/jobboard/jobboard.html.twig', array(
			'jobs' => $fmt_jobs,
			'companyName' => $wl['company_name'],
			'urlprefix' => '/jobs/apply/id/',
		));
    }


	/**
     * @Route("/jobboard/{jobid}", name="jobboard-job")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function jobAction(Request $request)
    {
		$jobid = $request->get('jobid');
		// Get employer_id from the subdomain
		$em = $this->getDoctrine()->getManager();
		$wl = $em->getRepository('AppBundle:CssSchemes')->getEmployerIdFromDomain();

		//  Retrieve this job
		$job = $em->getRepository('AppBundle:Jobs')
          ->findBy(
             array('employerId'=> $wl['employer_id'], 'uniqueid' => $jobid, 'active' => 1), 
             array('id' => 'DESC')
		);
		$job=$job[0];
		
		$fmt_job = array(
			'title'	=> $job->getTitle(),
			'description' => strtr($job->getDescription(),array('&#10;'=>"\n")),
			'uniqueId' => $job->getUniqueId(),
			'salary' => $job->getSalary(),
			'county' => $job->getCounty(),
			'startDate' => date('jS M Y',strtotime($job->getStartDate()->format('Y-m-d H:i:s'))),
			'dateAdded' => $job->getCreatedOn()->format('jS M Y'),
		);

		return $this->render('@App/jobboard/job.html.twig', array(
			'job' => $fmt_job,
			'companyName' => $wl['company_name'],
			'urlprefix' => 'https://tony.desktop.local' . '/jobs/apply/id/',
		));
    }
	

	/**
     * @Route("/jobboard/feeds/indeed.xml", name="jobboard-indeed-xml", defaults={"_format"="xml"})
     */
    public function indeedXMLAction(Request $request)
    {
		// Get employer_id from the subdomain
		$em = $this->getDoctrine()->getManager();
		$wl = $em->getRepository('AppBundle:CssSchemes')->getEmployerIdFromDomain();

		// Search for all active jobs
		$jobs = $em->getRepository('AppBundle:Jobs')
          ->findBy(
             array('employerId'=> $wl['employer_id'], 'active'=>'1', 'jb_indeed' => '1'),	// , 'jb_indeed' => '1'
             array('id' => 'DESC')
		);

		$fmt_jobs = array();
		foreach($jobs as $job)
		{
			$fmt_jobs[] = array(
				'title'	=> $job->getTitle(),
				'description' => strtr($job->getDescription(),array('&#10;'=>"\n")),
				'uniqueId' => $job->getUniqueId(),
				'salary' => $job->getSalary(),
				'county' => $job->getCounty(),
				'startDate' => date('jS M Y',strtotime($job->getStartDate()->format('Y-m-d H:i:s'))),
				'createdOn' => $job->getCreatedOn()->format('Y-m-d H:i:s'),
			);
		}

		header("Content-Type: text/xml");
		return $this->render('@App/jobboard/jobboard.xml.twig', array(
			'jobs' => $fmt_jobs,
			'dateNow' => date("Y-m-d H:i:s"),
			'companyName' => $wl['company_name'],
			'jobboardUrl' => 'https://'.$_SERVER['HTTP_HOST'] . '/jobboard',
		));
	}
}
