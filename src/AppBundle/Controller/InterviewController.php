<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WebHookTests;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class InterviewController extends Controller
{
    /**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/interview/index/jobid/{jobid}/id/{id}", name="interview_user")
     */
    public function interviewAction(Request $request)
    {
		$jobid = $request->get('jobid');
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();

		$user = $this->getUser();
		$employer_user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$jobuser = $em->getRepository('AppBundle:Users')->findOneBy(['id' => $id]);
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $jobid]);
		$jobtitle = $job->getTitle();
        $int = null;
		$company = $em->getRepository('AppBundle:CssSchemes')->getEmployerFromDomain();
		$noreply='noreply@'.$_SERVER['HTTP_HOST'];
		$companyName = $company->getCompanyName();
		
		if($_POST)
		{
			//------------------------------------------------------------
			//  Process client sending interview email
			//------------------------------------------------------------
			if($_POST['typ']=='arrange')
			{
				$l = filter_var($_POST['location'],FILTER_SANITIZE_SPECIAL_CHARS);
				$locn = strtr($l, array("\n"=>" ", "\r"=>""));
				$code = md5($id . time());
				$date = implode("-", array_reverse(explode("/", $_POST['dt_interview']))); // convert from datepicker dd/mm/yyyy to safe yyyy-mm-dd
				$int = $em->getRepository('AppBundle:Interviews')->findOneBy(['userId' => $id, 'jobId'=>$jobid]);
				if(!$int) $int = new \AppBundle\Entity\Interviews();
				$int->setUserId($id);
				$int->setJobId($jobid);
				$int->setEmployerId($employer_id);
				$int->setEmployerUserId($employer_user_id);
				$int->setInterviewDate(new \DateTime($date.' '.$_POST['tm_interview'].':00'));
				$int->setLocation($locn);
				$int->setSMS(1);
				$int->setEmail(1);
				$int->setCreatedOn(new \DateTime());
				$int->setUniqueRef($code);
				$int->setRejected(0);
				$int->setAccepted(0);
				$em->persist($int);
				$em->flush();
				
				// Create ICS file
				$dts = strtotime($date.' '.$_POST['tm_interview'].':00');
				$dtstart = date("Ymd",$dts) . 'T' . date("Hi",$dts);
				$dtend = date("Ymd",$dts+(60*90)) . 'T' . date("Hi",$dts+(60*90));

				$ics = "BEGIN:VCALENDAR
VERSION:1.0
BEGIN:VEVENT
CATEGORIES:MEETING
DTSTART:$dtstart
DTEND:$dtend
SUMMARY:Interview for $jobtitle
DESCRIPTION:Interview for $jobtitle
LOCATION:$locn
PRIORITY:3
END:VEVENT
END:VCALENDAR";
				
				// Send email
				$attachment = (new \Swift_Attachment())
					->setFilename('calendar.ics')
					->setContentType('text/calendar')
					->setBody($ics);
		
				$url = 'https://'.$_SERVER['HTTP_HOST']."/interview/candidate/$jobid?l=$code";
				$name = $jobuser->getFirstname() .' '. $jobuser->getSurname();
				$nicedate = date("jS F",strtotime($date));
				$time = $_POST['tm_interview'];

				$se = new \AppBundle\Model\SendEmail($this->get('twig'), $this->get('mailer'), $this->getDoctrine()->getManager());
				$ret = $se->send('', $jobuser->getUsername(), $id, "Interview Confirmation", "interview", 
					array('name'=>$name, 'jobtitle'=>$jobtitle, 'url'=>$url, 'nicedate'=>$nicedate, 'time'=>$time, 'location'=>$locn, 'companyname'=>$companyName), $attachment);
				if($ret<>1) {
					// TODO: display error about email not sent
					die("System error - Email could not be sent");
				}
			}

			//------------------------------------------------------------
			//  Process client sending cancel interview email
			//------------------------------------------------------------
			if($_POST['typ']=='cancel')
			{
				$int = $em->getRepository('AppBundle:Interviews')->findOneBy(['userId' => $id, 'jobId'=>$jobid]);
				$reason = $_POST['cancel'];
				$int->setRejected(1);
				$int->setRejectedOn(new \DateTime());
				$int->setRejectReason($reaon);
				$em->persist($int);
				$em->flush();
				
				// Send email
				$name = $jobuser->getFirstname() .' '. $jobuser->getSurname();
				$nicedate = date("jS F",strtotime($date));
				$time = $_POST['tm_interview'];

				$se = new \AppBundle\Model\SendEmail($this->get('twig'), $this->get('mailer'), $this->getDoctrine()->getManager());
				$ret = $se->send('', $jobuser->getUsername(), $id, "Interview Cancellation", "interviewcancelled", 
					array('name'=>$name, 'jobtitle'=>$jobtitle, 'url'=>$url, 'nicedate'=>$nicedate, 'time'=>$time, 'reason'=>$reason, 'companyname'=>$companyName), $attachment);
				if($ret<>1) {
					// TODO: display error about email not sent
					die("Email could not be sent");
				}

			}
		}


		$interview = $em->getRepository('AppBundle:Interviews')->findOneBy(['userId' => $id, 'jobId'=>$jobid]);
		$jobuser = $em->getRepository('AppBundle:Users')->findOneBy(['id' => $id]);
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $jobid]);

		$reason='';
		if($int) $reason = $int->getRejectReason();
		if($interview) $reason = $interview->getRejectReason();
		
		if(!$interview) $arranged=0; else $arranged=1;
		return $this->render('@App/interview/index.html.twig', array(
			'candidatename' => $jobuser->getFirstname() . ' ' . $jobuser->getSurname(),
			'jobtitle' => $job->getTitle(),
			'interview' => $interview,
			'arranged' => $arranged,
			'reason' => $reason,
		));
	}

	
    /**
     * @Route("/interview/candidate/{jobid}", name="interview_candidate")
     */
    public function interviewcandidateAction(Request $request)
    {
		$jobid = $request->get('jobid');
		$em = $this->getDoctrine()->getManager();

		$user = $this->getUser();
		$user_id = $user->getId();
		$id = $user_id;
		$employer_id = $user->getEmployerId();
		
		if($_POST)
		{
			if($_POST['typ']=='arrange')
			{
				$int = $em->getRepository('AppBundle:Interviews')->findOneBy(['userId' => $id, 'jobId'=>$jobid]);
				if(!$int) $int = new \AppBundle\Entity\Interviews();
				$int->setUserId($id);
				$int->setJobId($jobid);
				$int->setEmployerId($employer_id);
				$int->setEmployerUserId($user_id);
				$int->setInterviewDate(new \DateTime($_POST['dt_interview'].' '.$_POST['tm_interview'].':00'));
				$int->setSMS(1);
				$int->setEmail(1);
				$int->setCreatedOn(new \DateTime());
				$int->setRejected(0);
				$int->setAccepted(0);
				$em->persist($int);
				$em->flush();
			}
			
			if($_POST['typ']=='cancel')
			{
				$int = $em->getRepository('AppBundle:Interviews')->findOneBy(['userId' => $id, 'jobId'=>$jobid]);
				$int->setRejected(1);
				$int->setRejectedOn(new \DateTime());
				$int->setRejectReason($_POST['cancel']);
				$em->persist($int);
				$em->flush();
			}
		}


		$interview = $em->getRepository('AppBundle:Interviews')->findOneBy(['userId' => $id, 'jobId'=>$jobid]);
		$jobuser = $em->getRepository('AppBundle:Users')->findOneBy(['id' => $id]);
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $jobid]);

		$reason='';

		if($interview) $reason = $interview->getRejectReason();
		
		if(!$interview) $arranged=0; else $arranged=1;

		return $this->render('@App/interview/candidate.html.twig', array(
			'candidatename' => $jobuser->getFirstname() . ' ' . $jobuser->getSurname(),
			'jobtitle' => $job->getTitle(),
			'interview' => $interview,
			'arranged' => $arranged,
			'reason' => $reason,
		));
	}

}
