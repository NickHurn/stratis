<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;


class AdminController extends Controller
{
    /**
     * @Route("/admin/{jobid}", defaults={"jobid"=0}, name="admin_dash")
     */
    public function dashboardHomeAction(Request $request)
    {
		$jobid = $request->get('jobid');
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		$uj = $em->getRepository('AppBundle:UsersJob');
		$j = $em->getRepository('AppBundle:Jobs');
		$fuj = $em->getRepository('AppBundle:FormUserJobs');
		$in = $em->getRepository('AppBundle:Interviews');
		
		$jobs = $j->getJoblistByEmployer($employer_id);
		$overview = ($jobid == 0) ? true : false;
		if(!$overview) $jobcode = $j->getJobCodeFromId($jobid);

		//---------------------------------------------------
		//  Get stats
		//---------------------------------------------------
		if($overview)
		{
			$totalusers = $j->getApplicantCountForEmployer($employer_id);
			$jobcount = $j->getJobCountForEmployer($employer_id);
			$totalrejected = $uj->getRejectedCountForEmployer($employer_id);
			$totalinterviews = $in->getInterviewCountByEmployer($employer_id);
			$testsTaken = $fuj->getTestCompeletedCount($employer_id);
			$testsAverageScore = 'NA';
			$testScoreExtreme = 'NA';
			$testAverageDuration = 'NA';
			$timetorecruit = 'NA';
		}
		else
		{
			$totalusers = $uj->getApplicantCountForJob($jobcode);
			$jobcount = 'NA';
			$totalrejected = $uj->getRejectedCountForJob($jobcode);
			$totalinterviews = $in->getInterviewCountByJob($jobcode);
			$testsTaken = $fuj->getTestCompeletedCount($employer_id, $jobid);
			$testsAverageScore = 'NA';
			$testScoreExtreme = 'NA';
			$testAverageDuration = 'NA';
			$timetorecruit = 'NA';
		}

		//---------------------------------------------------
		//  Assign stats to widgets
		//---------------------------------------------------
		
		$grid = $em->getRepository('AppBundle:DashboardConfig')->getDashboardLayout($user_id,$overview);
		$html = '';
		$html .= $this->getWidgetHtml(1, $grid[1],'MYCHART', []);
		$html .= $this->getWidgetHtml(2, $grid[2],'INTERVIEW', []);
		$html .= $this->getWidgetHtml(3, $grid[3],'SIMPLE', ['title'=>'Average time to recruit', 'value'=>$timetorecruit]);
		$html .= $this->getWidgetHtml(4, $grid[4],'SIMPLE', ['title'=>'Total Applicants', 'value'=>$totalusers]);
		$html .= $this->getWidgetHtml(5, $grid[5],'SIMPLE', ['title'=>'Total active Jobs', 'value'=>$jobcount]);
		$html .= $this->getWidgetHtml(6, $grid[6],'SIMPLE', ['title'=>'Total Rejected Users', 'value'=>$totalrejected]);
		$html .= $this->getWidgetHtml(7, $grid[7],'SIMPLE', ['title'=>'Users With Interviews', 'value'=>$totalinterviews]);
		$html .= $this->getWidgetHtml(8, $grid[8],'SIMPLE', ['title'=>'Total Tests Taken', 'value'=>$testsTaken]);
		$html .= $this->getWidgetHtml(9, $grid[9],'SIMPLE', ['title'=>'Average Pass Mark', 'value'=>$testsAverageScore]);
		$html .= $this->getWidgetHtml(10, $grid[10],'SIMPLE', ['title'=>'Lowest / Best Score', 'value'=>$testScoreExtreme]);
		$html .= $this->getWidgetHtml(11, $grid[11],'SIMPLE', ['title'=>'Average Time Taken', 'value'=>$testAverageDuration]);
		
		return $this->render('@App/admin/home.html.twig', [
            'jobs' => $jobs,
			'jobid' => $jobid,
			'gridHtml' => $html,
        ]);
	}

	
	//-----------------------------------------------------------------------------------
	//  Get HTML code for requested widget
	//-----------------------------------------------------------------------------------

	private function getWidgetHtml($id,$config,$type,$data)
	{
		list($enabled, $x, $y, $w, $h) = $config;
		$hide= ($enabled==1) ? '' : 'style="display:none"';
		$html = "<div id='dashgriditem{$id}' $hide class='grid-stack-item' data-gs-x='$x' data-gs-y='$y' data-gs-width='$w' data-gs-height='$h'>";
		$html .= "<div class='grid-stack-item-content'>";
		$html .= "<div id='dashgridbtn{$id}' class='dashgridbtn'><i class='fa fa-times-circle'></i></div>";
		$html .= "<div id='dashgridovr{$id}' class='dashgridovr'></div>";

		switch ($type)
		{
			case 'SIMPLE':
				$html .= "<div class='dashparent'><div class='dashchild'><strong>".$data['title']."</strong><h2>".$data['value']."</h2></div></div>";
				break;

			case 'AJAXSIMPLE':
				$html .= "<div class='dashparent'><div class='dashchild'><strong>".$data['title']."</strong><h2 id='".$data['id']."'></h2></div></div>";
				break;

			case 'MYCHART':
				$html .= "<canvas id='myChart'></canvas>";
				break;
			
			case 'INTERVIEW':
				$html .= "<canvas id='interviewChart' style='text-align:left' width='200' height='200'></canvas>";
				break;
			default:
				die("Unknown widget type $type");
		}
		$html .= "</div></div>";
		return $html;
	}

}

