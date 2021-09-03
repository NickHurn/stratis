<?php

namespace AppBundle\Controller;
use AppBundle\Entity\WebHookTests;
use AppBundle\Entity\UsersJob;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Jobs;
use AppBundle\Entity\Users;
use AppBundle\Entity\UsersRoles;
use AppBundle\Entity\Address;
use AppBundle\Entity\ApplicantDisclosures;
use AppBundle\Form\Job;
#use Symfony\Component\Security\Core\Authentication\Token;



class JobsController extends Controller
{
    /**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/jobs/view", name="jobs_view")
     */
    public function viewAction(Request $request)
    {

		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();		

		$dtto = date("d-m-Y");
		$dtfrom = date("d-m-Y", strtotime("-2 years"));
		$applicantSearch="date_range_filter%5BfromDate%5D={$dtfrom}&date_range_filter%5BtoDate%5D={$dtto}&choices_filter%5BjobList%5D=";
		//$jobs = $em->getRepository('AppBundle:Jobs')->findBy(['employerId'=>$employer_id], array('title'=>'ASC'));
		$jobs = $em->getRepository('AppBundle:Jobs')->getJobView($employer_id);

		return $this->render('@App/jobs/view.html.twig', array(
			'jobs' => $jobs,
			'domain' => $_SERVER['HTTP_HOST'],
			'applicantSearch' => $applicantSearch,
		));
	}
	
	
	/**
     * @Route("/jobs/apply/id/{id}", name="jobs_apply")
     */
    public function applyAction(Request $request)
    {
		//  If the candidate is already logged in, assign them straight away
		//  If the candidate uses the login part of the form, log them in and assign them
		//  If the candidate uses the sign up form, create a user account, log them in, then assign them.

		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();		
		$duplicate_email_error = false;
		

		//  Check is a valid job id
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$id]);
		if(!$job)
		{
			if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
				$renderfile = '@App/error/error.html.twig';
			} else {
				$renderfile = '@App/error/usererror.html.twig';
			}
			return $this->render($renderfile, array(
				'title' => 'Invalid Job Reference',
				'msg' => 'The link you have followed does not correspond to a job listing.'
			));
		}

		
		//  Check that this is not an employer logged in
		$user = $this->getUser();
		if($user)
		{
			$user_id = $user->getId();
			$chk = $user->getEmployerId();
			if($chk)
			{
				// If logged in as an admin, re-direct to 'no can do' page
				return $this->render('@App/jobs/noadmin.html.twig', array(
					'url' => $id,
				));
			}
		}

		
		$form = $this->createForm(\AppBundle\Form\Apply::class);
		$form->handleRequest($request);
		$formLogin = $this->createForm(\AppBundle\Form\Login::class);
		$formLogin->handleRequest($request);
		$employer_id = $job->getEmployerId();
		
		
		//-----------------------------------------------------------------
		//  If the user submitted the login form, process it.
		//  If valid, log them on
		//-----------------------------------------------------------------
		
		$login_error = '';
		
		if($formLogin->isSubmitted() && $formLogin->isValid()) 
		{
			$login_error = 'Email address or password incorrect';
			$user = $em->getRepository('AppBundle:Users')->findOneBy(['emailaddress' => $_POST['login']['emailaddress']]);
			if($user)
			{
				$encoder = $this->get('security.password_encoder');
				$correct = $encoder->isPasswordValid($user, $_POST['login']['password']);
				if($correct)
				{
					$token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, $user->getPassword(), "main", $user->getRoles());
					$this->get("security.token_storage")->setToken($token);

					// Fire the login event - as this login method doesn't do this automatically
					$event = new \Symfony\Component\Security\Http\Event\InteractiveLoginEvent($request, $token);
				}
			}
		}


		//-----------------------------------------------------------------
		//  If the user submitted the signup form, process it.
		//  If valid, create their account and log them on
		//-----------------------------------------------------------------

		if($form->isSubmitted() && $form->isValid()) 
		{
			$applicant = $form->getData();
		
			//  Check that the email address is not already in use
			$chk = $em->getRepository('AppBundle:Users')->findOneBy(['emailaddress' => $applicant['email']]);
			if($chk)
			{
				$duplicate_email_error = true;
			}
			else
			{
				//  Create User
				$u = new Users();
				$u->setFirstname($applicant['firstName']);
				$u->setSurname($applicant['surname']);
				$u->setEmailaddress($applicant['email']);
				$u->setMobiletel($applicant['mobiletel']);
				$u->setHometel($applicant['hometel']);
				$u->setFirstname($applicant['firstName']);
				$u->setTempPassword(1);
				$password = substr(base64_encode(random_bytes(8)),0, -1);
				$u->setPassword($password, $this->get('security.password_encoder'));
				$u->setPlainPassword($password);
				$em->persist($u);
				$em->flush();

				//  Create users_roles entry
				$applicantRole = $em->getRepository('AppBundle:Role')->findOneBy(['name' => 'ROLE_APPLICANT']);
				$ur = new UsersRoles();
				$ur->setUsersId($u->getId());
				$ur->setRoleId($applicantRole->getId());
				$em->persist($ur);
				$em->flush();

				//  Add address
				$add = new Address();
				$add->setUserId($u);
				$add->setLine1($applicant['line1']);
				$add->setLine2($applicant['line2']);
				$add->setTown($applicant['town']);
				$add->setCounty($applicant['county']);
				$add->setPostcode($applicant['postcode']);			
				$em->persist($add);
				$em->flush();
				
				//  Create Users Job record
				$uj = new UsersJob();
				$uj->setUserId($u->getId());
				$uj->setJobId($id);
				$uj->setCreatedOn(new \DateTime('now'));
				$uj->setLastModified(new \DateTime('now'));
				$uj->setCheckablCount(1);
				$uj->setTestablCount(1);
				$uj->setPersonablCount(1);
				$em->persist($uj);
				$em->flush();

				//  TODO: update this table with checkabl_count, testabl_count, etc
				
				//  TODO: Send welcome email


				//  Log user on
				$user = $em->getRepository('AppBundle:Users')->findOneBy(['emailaddress' => $applicant['email']]);
				if($user)
				{
					$token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, $user->getPassword(), "main", $user->getRoles());
					$this->get("security.token_storage")->setToken($token);
					$event = new \Symfony\Component\Security\Http\Event\InteractiveLoginEvent($request, $token);
				}
			}
		}

		
		//-----------------------------------------------------------------
		//  If the user is logged on, assign them to the job and 
		//  re-direct to the candidate home page.
		//-----------------------------------------------------------------
		
		$user = $this->getUser();
		if($user)
		{
			$user_id = $user->getId();
			$users_employer_id = $user->getEmployerId();
			if(!$users_employer_id)
			{
				$em->getRepository('AppBundle:Jobs')->assignToApplicant($job, $user_id);
				
				//  If ID3 checks requested, create an extrachecks record
				if($job->getDisclosures()==1)
				{
					$ec = new \AppBundle\Entity\ExtraChecks();
					$ec->setEmployerId($employer_id);
					$ec->setUserId($user_id);
					$ec->setJobCode($id);
					$ec->setCheckType('DBS/Basic');
					$ec->setDateRequested(new \DateTime("now"));
					$ec->setStatus('Waiting for Candidate');
					$em->persist($ec);
					$em->flush();
				}

				//  If identity (passport) requested, create an extrachecks record
				if($job->getIdentity()==1)
				{
					$ec = new \AppBundle\Entity\ExtraChecks();
					$ec->setEmployerId($employer_id);
					$ec->setUserId($user_id);
					$ec->setJobCode($id);
					$ec->setCheckType('IDENTITY/Passport');
					$ec->setDateRequested(new \DateTime("now"));
					$ec->setStatus('Waiting for Candidate');
					$em->persist($ec);
					$em->flush();
				}

					
					
				//  TODO: If there are any tests assigned to this job, assign them to the user
				
				
				//  TODO: If there are any personabl questions assigned to this job, assign them to the user

				//  Re-direct to user homepage
				return $this->redirect("/candidate/home");
			}
		}

		
		//  If the user is not logged on, then re-display the form
		
		return $this->render('@App/jobs/apply.html.twig', array(
			'form' => $form->createView(),
			'formLogin' => $formLogin->createView(),
			'title' => $job->getTitle(),
			'login_error' => $login_error,
			'duplicate_email_error' => $duplicate_email_error,
		));
	}
	
	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/jobs/edit/{id}", name="jobs_edit")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$id = $request->get('id');

		$em = $this->getDoctrine()->getManager();		
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$id]);
		$form = $this->createForm(Job::class, $job, array('entity_manager'=>$em));
		$form->handleRequest($request);
		if($form->isSubmitted())
		{
			$j = $form->getData();

			$em->persist($j);
			$em->flush();
			return $this->redirect("/jobs/view");
		}

		return $this->render('@App/jobs/edit.html.twig', array(
			'form' => $form->createView(),
			'title' => $job->getTitle(),
            'job'=>$job,
		));
	}

	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/jobs/add", name="jobs_add")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$id = $request->get('id');

		$em = $this->getDoctrine()->getManager();		
		$job = new \AppBundle\Entity\Jobs();
		$job->setEducationMax(1);
		$job->setEmploymentMax(1);

		$form = $this->createForm(Job::class, $job, array('entity_manager'=>$em));
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$j = $form->getData();
			$token = $request->request->get('job')['_token'];
            $uniqueid = md5($j->getTitle().microtime(true));
            $exists = $em->getRepository('AppBundle:Jobs')->findBy(['title'=>$j->getTitle(), 'startDate'=>$j->getStartDate(), 'county'=>$j->getCounty(), 'active'=>$j->getActive()]);
            if (empty($exists)) {
                $j->setCreatedOn(new \DateTime('now'));
                $j->setCreatedBy($user_id);
                $j->setEmployerId($employer_id);
                $long_url = 'https://' . $_SERVER['HTTP_HOST'] . '/jobs/apply/id/' . $uniqueid;
                $short_url = file_get_contents('https://api-ssl.bitly.com/v3/shorten?access_token=f2fbe310594e4e296fd89de2de630143e5db2c48&format=txt&longUrl=' . urldecode($long_url));
                $j->setUniqueId($uniqueid);
                $j->setShortUrl($short_url);
                $j->setFormToken($token);
                $em->persist($j);
                $em->flush();
            }
			return $this->redirect("/jobs/view");
		}

		return $this->render('@App/jobs/edit.html.twig', array(
			'form' => $form->createView(),
			'title' => 'Add New',
		));
	}

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/jobs/cvdownload/id/{cvid}", name="cv_download")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cvdownloadAction(Request $request, $cvid)
    {
        $em = $this->getDoctrine()->getManager();
        $cv = $em->getRepository('AppBundle:Cv')->find($cvid);
        $media_path = $this->getParameter('media_full_path');
                header('Content-Description: File Transfer');
                header('Content-Type: '.$cv->getMimeType());
                header('Content-Disposition: attachment; filename="'.$cv->getStoredName().'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($media_path.'/cv/'.$cv->getStoredName()));
                readfile($media_path.'/cv/'.$cv->getStoredName());
                exit;
    }


    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/jobs/remove", name="jobs_remove")
     */
    public function removeJobAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $jobUId = $request->query->get('uid');

        $job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$jobUId]);

        $job->setActive(0);
        $em->persist($job);
        $em->flush();
        return $this->json(array('status'=>'ok'));
    }
}
