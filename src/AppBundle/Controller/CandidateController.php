<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;


class CandidateController extends Controller
{
    /**
     * @Route("/candidate/home", name="candidate_home")
     */
    public function homeAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		if($user==null) return $this->redirect('/login');
		if($user->getEmployerId()>0) return $this->redirect('/admin');
		$user_id = $user->getId();
		$uj = $em->getRepository('AppBundle:UsersJob');

		// TODO: For performance don't call this here, only call it where updates occur
		$recs = $uj->getJobList($user_id);
		foreach($recs as $idx=>$r)
		{
			$uj->updateStats($user_id, $r['jobId']);
		}

		$recs = $uj->getJobList($user_id);
		foreach($recs as $idx=>$r)
		{
			$iv_jobid = $recs[$idx]['jobId'];
			$int = $em->getRepository('AppBundle:Interviews')->findOneBy(['userId' => $user_id, 'jobId'=>$iv_jobid]);
			if($r['checkablCount']==null) {
				$recs[$idx]['cpcnt'] = null;
			} else {
				$recs[$idx]['cpcnt'] = round($r['checkablCompleted']/$r['checkablCount']*100);
				//$recs[$idx]['cpcnt'] = $r['checkablCompleted'] . '/' . $r['checkablCount'];
			}

			if($r['testablCount']==null) {
				$recs[$idx]['tpcnt'] = null;
			} else {
				$recs[$idx]['tpcnt'] = round($r['testablCompleted']/$r['testablCount']*100);
				//$recs[$idx]['tpcnt'] = $r['testablCompleted'] . '/' . $r['testablCount'];
			}

			if($r['personablCount']==null) {
				$recs[$idx]['ppcnt'] = null;
			} else {
				$recs[$idx]['ppcnt'] = round($r['personablCompleted']/$r['personablCount']*100);
				//$recs[$idx]['ppcnt'] = $r['personablCompleted'] . '/' . $r['personablCount'];
			}
			// continue button
			$recs[$idx]['section'] = false;
			$status = 'INACTIVE';
			for(;;)
			{
				if($recs[$idx]['active'] == 0)		{ $status='INACTIVE'; break; }
				if($recs[$idx]['accepted'] == 1)	{ $status='ACCEPTED'; break; }
				if($recs[$idx]['rejected'] == 1)	{ $status='REJECTED'; break; }
				if($recs[$idx]['offered'] == 1)		{ $status='OFFERED'; break; }
				$status = 'ACTIVE';
				if($int)
				{
					if($int->getRejected() == 1) { $status = 'INTERVIEW-R'; break; }
					if($int->getAccepted() == 1) { $status = 'INTERVIEW-A'; break; }
					if($int->getAccepted() == 0 and $int->getRejected() == 0) { $status = 'INTERVIEW-O'; break; }
				}
				if(floor($recs[$idx]['cpcnt']) !== null and $recs[$idx]['cpcnt']<100)
//				if($r['checkablCount']>0 and ($r['checkablCompleted'] < $r['checkablCount']))
				{
					$recs[$idx]['section'] = 'checkabl'; break;
				}
				if($r['testablCount']>0 and ($r['testablCompleted'] < $r['testablCount']))
				{
					$recs[$idx]['section'] = 'testabl'; break;
				}
				if($r['personablCount']>0 and ($r['personablCompleted'] < $r['personablCount']))
				{
					$recs[$idx]['section'] = 'personabl'; break;
				}
				break;
			}
			
			$recs[$idx]['status'] = ucwords(strtolower($status)); 
		}
		return $this->render('@App/candidate/home.html.twig', [
            'jobs' => $recs
        ]);
	}


	/**
     * @Route("/candidate/profile", name="candidate_profile")
     */
    public function profileAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$em = $this->getDoctrine()->getManager();		

		$addr = $em->getRepository('AppBundle:Address')->findOneBy(['userid'=>$user_id]);
		if(!$addr) die("address not found for user {$user_id}");
		$form = $this->createForm(\AppBundle\Form\UserEdit::class);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$data = $form->getData();
			$user->setEmailAddress($data['emailaddress']);
			$user->setHomeTel($data['hometel']);
			$user->setMobileTel($data['mobiletel']);
			$user->setRetention($data['retention']);
			$addr->setLine1($data['line1']);
			$addr->setLine2($data['line2']);
			$addr->setLine3($data['line3']);
			$addr->setTown($data['town']);
			$addr->setCounty($data['county']);
			$addr->setPostcode($data['postcode']);
			$em->persist($user);
			$em->persist($addr);
			$em->flush();
			$this->addFlash("success", "Changes saved");
			return $this->redirect("/candidate/profile");
		}

		$form->setData(array(
			'firstname'	=> $user->getFirstname(),
			'surname'	=> $user->getSurname(),
			'emailaddress'	=> $user->getEmailAddress(),
			'hometel'	=> $user->getHomeTel(),
			'mobiletel'	=> $user->getMobileTel(),
			'retention'	=> $user->getRetention(),
			'line1'		=> $addr->getLine1(),
			'line2'		=> $addr->getLine2(),
			'line3'		=> $addr->getLine3(),
			'town'		=> $addr->getTown(),
			'county'	=> $addr->getCounty(),
			'postcode'	=> $addr->getPostcode(),
		));

		
		return $this->render('@App/user/useredit.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Your Profile',
		));
	}

	
	/**
     * @Route("/candidate/short", name="candidate_short")
     */
    public function shortAction(Request $request)
    {
		return $this->render('@App/candidate/short.html.twig', array(
		));
	}
}
