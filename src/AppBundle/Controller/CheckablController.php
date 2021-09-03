<?php

namespace AppBundle\Controller;
use AppBundle\Entity\HistoryEmployment;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfonyznt\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\UsersJob;
use AppBundle\Entity\Cv;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Model\Progress;


class CheckablController extends Controller
{
	private $user_id;
    /**
     * @var EntityManager
     */
	private $em;
	private $job;
	private $job_code;
	private $job_id;
	private $employer_id;
	
	
	private function _checkValidUser()
	{
		// Checked we are logged on and as a user
		$user = $this->getUser();
		if(empty($user)) throw new AccessDeniedException();
		$this->user_id = $user->getId();
		$this->em = $this->getDoctrine()->getManager();
		
		if(NULL == $user->getFirstname()) return $this->redirect('/logout');
		if(NULL <> $user->getEmployerId()) return $this->redirect('/admin');
	}

	
	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/{jobcode}", name="checkabl")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
		$job_code = $request->get('jobcode');

		$this->_checkValidUser();
		$user_id = $this->user_id;
        $dbs = null;
        $qual = null;
		$users_job = $this->em->getRepository('AppBundle:UsersJob')->findOneBy(['userId'=>$user_id, 'jobId'=>$job_code]);
		if(empty($users_job)) {
			return $this->render('@App/error/usererror.html.twig', array(
				'title' => 'Invalid Request',
				'msg' => 'The job details you are requesting are either invalid or are for a job that is not assigned to you.',
			));
		}
		
		$job = $this->em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$job_code]);
		if(!$job) {
			return $this->render('@App/error/usererror.html.twig', array(
				'title' => 'Invalid Request',
				'msg' => 'This is not a valid job code.',
			));
		}
		$job_id = $job->getId();
		$employer_id = $job->getEmployerId();
		
		$title = $job->getTitle();
		// Verify this user is currently applying for this job.
		$uj = $this->em->getRepository('AppBundle:UsersJob');
		$res = $uj->verifyCandidateJobApplication($user_id, $job_code);

		if($res==false) {
			return $this->render('@App/error/usererror.html.twig', array(
				'title' => 'Invalid Request',
				'msg' => 'You do not appear to have applied for this job.',
			));
		}

		
		$extracheck = $this->em->getRepository('AppBundle\Entity\ExtraChecks')->findBy(['userId' => $user_id, 'jobCode'=>$job_code]);
        foreach ($extracheck as $item) {
            $type = substr($item->getCheckType(), 0, 3);
            if ($type === 'DBS'){
                $dbs = $item;
            }
            if ($item->getCheckType() == 'Qualifications'){
                $job = $this->em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$item->getJobCode()]);
                $qual = $this->em->getRepository('AppBundle:QualificationChecks')->findOneBy(['jobId'=>$job->getId(), 'userId'=>$item->getUserId()]);

            }

        }

		$progress = new \AppBundle\Model\Progress($this->em,null);
		$res = $progress->getCheckablProgressNew($job_code, $this->getUser());
		
		//  DISPLAY
		return $this->render('@App/checkabl/index.html.twig', array(
			'title' => $job->getTitle(),
			'jobid' => $job_code,
			'dateNow' => date("Y-m-d H:i:s"),
			'done' => $res['completed'],
			'required' => $res['required'],
            'dbs'=>$dbs,
            'qual'=>$qual,
		));
	}



	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/email/{jobcode}", name="checkabl_email")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emailAction(Request $request)
    {
		$this->_checkValidUser($request);
		$job_code = $request->get('jobcode');
		$error = 0;

		if($_POST)
		{
			$code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS);
			$ev = $this->em->getRepository('AppBundle\Entity\EmailVerification')->findOneBy(['email' => $this->getUser()->getUsername(), 'code'=>$code]);
			if($ev) {
				$ev->setConfirmed(1);
				$ev->setConfirmDate(new \DateTime("now"));
				$this->em->persist($ev);
				$this->em->flush();
				return $this->redirect("/checkabl/email/{$job_code}");
			} else {
				$error = 1;
			}
		}
		
		$sent = 0;
		$can_resend = 0;
		$verified = 0;
		
		$ev = $this->em->getRepository('AppBundle\Entity\EmailVerification')->findOneBy(array('email' => $this->getUser()->getUsername()));

		if($ev)
		{
			$sent = 1;
			$date = $ev->getIssueDate()->format("Y-m-d H:i:s");
			$date15minsAgo = date("Y-m-d H:i:s",strtotime("-15 MINS"));
			if($ev->getConfirmDate()!=null) {
				$verified = 1;
			} else {
				if($date < $date15minsAgo) $can_resend = 1;
			}
		}
		//  Display
		return $this->render('@App/checkabl/email.html.twig', array(
			'jobid' => $job_code,
			'email' => $this->getUser()->getUsername(),
			'verified'	=> $verified,
			'sent' => $sent,
			'error' => $error,
			'can_resend' => $can_resend,
		));
	}
	

	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/sendemailcode/{jobid}", name="checkabl_sendemailcode")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendemailcodeAction(Request $request)
    {
		$this->_checkValidUser($request);
		$job_id = $request->get('jobid');
		$job_code = $this->em->getRepository('AppBundle:Jobs')->getJobCodeFromId($job_id);
		$code = substr(md5(rand()), 0, 6);
		
		// Send code via email
		$se = new \AppBundle\Model\SendEmail($this->get('twig'), $this->get('mailer'), $this->getDoctrine()->getManager());
		$se->send("no-reply@koine.com", $this->getUser()->getUsername(), $this->getUser()->getId(), "Verify Email", "verifyemail", array('code'=>$code));

		// Remove any old match from database
		$ev = $this->em->getRepository('AppBundle\Entity\EmailVerification')->findOneBy(array('email' => $this->getUser()->getUsername()));
		if($ev) {
			$this->em->remove($ev);
			$this->em->flush();
		}
			
		// Record code in the database
		$ev = new \AppBundle\Entity\EmailVerification();
		$ev->setCode($code);
		$ev->setConfirmed(0);
		$ev->setIssueDate(new \DateTime("now"));
		$ev->setEmail($this->getUser()->getUsername());
		$this->em->persist($ev);
		$this->em->flush();
		
		return $this->redirect("/checkabl/email/{$job_id}");
	}


	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/mobile/{jobcode}", name="checkabl_mobile")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mobileAction(Request $request)
    {
		$this->_checkValidUser($request);
		$job_code = $request->get('jobcode');
		$error = 0;
		if($_POST)
		{
			$code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS);
			$sv = $this->em->getRepository('AppBundle\Entity\SmsVerification')->findOneBy(['mobile' => $this->getUser()->getMobiletel(), 'code'=>$code]);
			if($sv) {
				$sv->setConfirmed(1);
				$sv->setConfirmDate(new \DateTime("now"));
				$this->em->persist($sv);
				$this->em->flush();
				return $this->redirect("/checkabl/mobile/{$job_code}");
			} else {
				$error = 1;
			}
		}
		
		$sent = 0;
		$can_resend = 0;
		$verified = 0;
		
		$sv = $this->em->getRepository('AppBundle\Entity\SmsVerification')->findOneBy(array('mobile' => $this->getUser()->getMobiletel()));
		if($sv)
		{
			$sent = 1;
			$date = $sv->getIssueDate()->format("Y-m-d H:i:s");
			$date15minsAgo = date("Y-m-d H:i:s",strtotime("-15 MINS"));
			if($sv->getConfirmDate()!=null) {
				$verified = 1;
			} else {
				if($date < $date15minsAgo) $can_resend = 1;
			}
		}

		//  Display
		return $this->render('@App/checkabl/mobile.html.twig', array(
			'jobid' => $job_code,
			'mobile' => $this->getUser()->getMobiletel(),
			'verified'	=> $verified,
			'sent' => $sent,
			'error' => $error,
			'can_resend' => $can_resend,
		));
	}
	
	
	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/sendmobilecode/{jobid}", name="checkabl_sendmobilecode")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendmobilecodeAction(Request $request)
    {
		$this->_checkValidUser($request);
		$job_code = $request->get('jobid');
		//$job_code = $this->em->getRepository('AppBundle:Jobs')->getJobCodeFromId($job_id);
		$job = $this->em->getRepository('AppBundle\Entity\Jobs')->findOneBy(array('uniqueid' => $job_code));
		if(!$job)
		{
			return $this->render('@App/error/error.html.twig', array(
				'title' => 'Job Not Found',
				'msg' => 'Sorry, but the job id you are trying to access has not been found. Either you typed in a URL incorrectly or there was an error in our system.',
			));
		}
		
		
		$code = substr(md5(rand()), 0, 6);
		$mobile = $this->getUser()->getMobiletel();

		// TODO: fix hard coding
		$employer = 1;
		$companyName = "Koine";
		$from = 'koine.com';
		
		// Send code via SMS
		$se = new \AppBundle\Model\SendSMS($this->getUser()->getId(), $this->getDoctrine()->getManager());

		$msg = "Please enter code $code where prompted. Thanks, $companyName";
		$se->send($from, $mobile, $msg);
		// Remove any old match from database
		$sv = $this->em->getRepository('AppBundle\Entity\SmsVerification')->findOneBy(array('mobile' => $mobile));
		if($sv) {
			$this->em->remove($sv);
			$this->em->flush();
		}
			
		// Record code in the database
		$sv = new \AppBundle\Entity\SMSVerification();
		$sv->setCode($code);
		$sv->setConfirmed(0);
		$sv->setIssueDate(new \DateTime("now"));
		$sv->setMobile($this->getUser()->getMobiletel());
		$this->em->persist($sv);
		$this->em->flush();

		return $this->redirect("/checkabl/mobile/{$job_code}");
	}


	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/terms/{jobcode}", name="checkabl_terms")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function termsAction(Request $request)
    {
		$this->_checkValidUser();
		$job_code = $request->get('jobcode');
		$job_id = $this->em->getRepository('AppBundle:Jobs')->getIdFromJobCode($job_code);	
		$terms_agreed = $this->em->getRepository('AppBundle:TermsAgreed')->findOneBy(['userId' => $this->user_id, 'jobId'=>$job_id]);
		$agreed = ($terms_agreed) ? true:false;
		//if(!empty($_POST))
		if(!empty($_POST) and !empty($_POST['agree']))
		{
			$terms_agreed = $this->em->getRepository('AppBundle:TermsAgreed')->findOneBy(['userId' => $this->user_id, 'jobId'=>$job_id]);
			if(!$terms_agreed)
			{
				$ta = new \AppBundle\Entity\TermsAgreed();
				$ta->setJobId($job_id);
				$ta->setUserId($this->user_id);
				$this->em->persist($ta);
				$this->em->flush();
			}
			return $this->redirect("/checkabl/{$job_code}");
		}
		
		
		
		$recs = $this->em->getRepository('AppBundle\Entity\Terms')->getJobTerms($job_id);
		return $this->render('@App/checkabl/terms.html.twig', array(
			'jobid' => $job_code,
			'terms' => $recs,
			'agreed' => $agreed,
		));
	}
	
	
	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/cvupload/{jobcode}", name="checkabl_cvupload")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cvuploadAction(Request $request)
    {
		$this->_checkValidUser();
		$job_code = $request->get('jobcode');
        $error = null;
		if($_POST)
		{
            if($_FILES['tmpfile']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $_FILES['tmpfile']['type'] == 'application/pdf') {


                $mediapath = $this->getParameter('media_full_path');
                $enctype = $_FILES['tmpfile']['type'];


                $key = substr(md5(random_bytes(8)), 0, -1);
                $pathinfo = pathinfo($_FILES['tmpfile']['name']);
                $ext = $pathinfo['extension'];
                $fullfilename = $mediapath . '/cv/' . $key . '.' . $ext;

                move_uploaded_file($_FILES['tmpfile']['tmp_name'], $fullfilename);


                $cv = $this->em->getRepository('AppBundle:Cv')->findOneBy(['userId' => $this->user_id, 'jobId' => $job_code]);
                if (!$cv) {
                    $cv = new \AppBundle\Entity\Cv();
                    $cv->setUserId($this->user_id);
                    $cv->setJobId($job_code);
                }
                $cv->setMimeType($enctype);    // eg application/pdf
                $cv->setCreatedOn(new \DateTime('now'));
                $cv->setStoredName($key . '.' . $ext);
                $this->em->persist($cv);
                $this->em->flush();
                return $this->redirect("/checkabl/{$job_code}");
            }else{
                $error = 'You are only able to upload a word document or PDF.';
            }
		};
		$job_code = $request->get('jobid');
		return $this->render('@App/checkabl/uploadcv.html.twig', array(
			'jobid' => $job_code,
            'error'=>$error,
		));
	}

	
	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/employerhistory/{jobcode}", name="checkabl_employerhistory")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function employerhistoryAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$job_code = $request->get('jobcode');
		$em = $this->getDoctrine()->getManager();
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(array('uniqueid'=>$job_code));
		$max_recs = $job->getEmploymentMax();
		$recs = $em->createQuery("
			SELECT he 
			FROM AppBundle:HistoryEmployment he
			WHERE he.userId=:uid AND he.jobId=:jc AND he.seq<=:max ORDER BY he.seq")
			->setParameters(array("uid" => $user_id, "jc"=>$job_code, "max"=>$max_recs))
			->getResult();
		$data = array();
		if($recs)
		{
            /**
             * @var $r HistoryEmployment
             */
			foreach($recs as $idx=>$r)
			{
				$s=$r->getSeq();
				$data["companyName$s"] = $r->getCompanyName();
				$data["titles"] = $r->getTitle();
				$data["startdate$s"] = $this->dateToString($r->getStartdate());
				$data["enddate$s"] = $this->dateToString($r->getEnddate());
				$data["employmentStatus"] = $r->getEmploymentStatus();
				$data["description$s"] = $r->getDescription();
			}
		}

		$form = $this->createFormBuilder($data, ['attr'=>['name'=>"form", 'id'=>"form"]]);
		for($i=1; $i<=$max_recs; $i++)
		{
			$form
			->add("companyName{$i}", TextType::class, ['required'=>false, 'label'=>"Company Name #{$i}",'attr' => ['class'=>'form-control', 'placeholder'=>'Name of employer']])
            ->add("title{$i}", TextType::class, ['required'=>false, 'label'=>'Job Title', 'attr'=>['placeholder'=>'Job title']])
			->add("startdate{$i}", TextType::class, ['required'=>false, 'label'=>'Start Date', 'attr'=>['widget'=>'single_text', 'format'=>'dd-MM-yyyy', 'class'=>'datepicker', 'placeholder'=>'Employment start date']])
            ->add("enddate{$i}", TextType::class, ['required'=>false, 'label'=>'End Date', 'attr'=>['widget'=>'single_text', 'class'=>'datepicker', 'label' => 'End Date', 'format'=>'dd-MM-yyyy','placeholder'=>'Date employment finished (leave blank if still employed)']])
            ->add('current', ChoiceType::class, array(
                'label' => 'Emploment Status',
                'choices' => [
                    'Handed in notice' => 'notice',
                    'Still Employed' => 'current',
                    'No longer at this employer' => 'unemployed',
                ],
                'multiple'=>false,
                'expanded'=>true,
                )
            )
            ->add("description{$i}", TextareaType::class, ['required'=>false, 'label'=>'Description', 'attr'=>['rows'=>10, 'placeholder'=>'Job description']]);
		}
		$form = $form->getForm()->createView();

		if($_POST)
		{
			$d = $_POST['form'];
			//  Write out to database

			for($i=1; $i<=$max_recs; $i++)
			{
				$he = $em->getRepository('AppBundle:HistoryEmployment')->findOneBy(array('userId'=>$user_id, 'jobId'=>$job_code, 'seq'=>$i));
				if(!$he)
				{
					$he = new \AppBundle\Entity\HistoryEmployment();
					$he->setUserId($user_id);
					$he->setJobId($job_code);
					$he->setSeq($i);
				}
				$he->setCompanyName($d["companyName$i"]);
				$he->setTitle($d["title$i"]);
				$x = $this->stringToDate($d["startdate$i"]);
				if($x) $he->setStartdate($x);
				$x = $this->stringToDate($d["enddate$i"]);
				if($x) $he->setEnddate($x);
				$he->setEmploymentStatus($d['current']);
				$he->setDescription($d["description$i"]);
				$he->setCreatedOn(new \DateTime('now'));
				$em->persist($he);
				$em->flush();
			}
				
			//  If the finalise button was pressed, create the 'finalised' entry
			if($_POST['submit']=='Finalise and Submit')
			{
				$hc = $em->getRepository('AppBundle:HistoriesComplete')->findOneBy(array('userId'=>$user_id, 'jobId'=>$job_code));
				if(!$hc)
				{
					$hc = new \AppBundle\Entity\HistoriesComplete();
					$hc->setUserId($user_id);
					$hc->setJobId($job_code);
				}
				$hc->setEmployment(1);
				$em->persist($hc);
				$em->flush();
			}
			
			//  Go back to /checkabl/{job_code}
			return $this->redirect("/checkabl/{$job_code}");

		}

		return $this->render('@App/checkabl/employmenthistory.html.twig', array(
			'jobid' => $job_code,
			'form' => $form,
		));
	}


	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/educationhistory/{jobcode}", name="checkabl_educationhistory")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function educationhistoryAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$job_code = $request->get('jobcode');
		$hist_edu = new \AppBundle\Entity\HistoryEducation();
		$em = $this->getDoctrine()->getManager();
		
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(array('uniqueid'=>$job_code));
		$max_recs = $job->getEducationMax();

		$recs = $em->createQuery("
			SELECT he.seq, he.courseTitle, he.establishment, he.startdate, he.enddate, he.qualification 
			FROM AppBundle:HistoryEducation he
			WHERE he.userId=:uid AND he.jobId=:jc AND he.seq<=:max ORDER BY he.seq")
			->setParameters(array("uid" => $user_id, "jc"=>$job_code, "max"=>$max_recs))
			->getResult();
		$data = array();
		
		if($recs)
		{
			foreach($recs as $idx=>$r)
			{ 
				$s=$r['seq'];
				$data["courseTitle$s"] = $r['courseTitle'];
				$data["establishment$s"] = $r['establishment'];
				$data["startdate$s"] = $this->dateToString($r['startdate']);
				$data["enddate$s"] = $this->dateToString($r['enddate']);
				$data["qualification$s"] = $r['qualification'];
			}
		}

		$form = $this->createFormBuilder($data, ['attr'=>['name'=>"form", 'id'=>"form"]]);
		for($i=1; $i<=$max_recs; $i++)
		{
			$form
			->add("courseTitle{$i}", TextType::class, ['required'=>false, 'label'=>"Course Title #{$i}"])
            ->add("establishment{$i}", TextType::class, ['required'=>false, 'label'=>'University / College / School'])
			->add("startdate{$i}", TextType::class, ['required'=>false, 'label'=>'Start Date', 'attr'=>['widget'=>'single_text', 'format'=>'dd-MM-yyyy', 'class'=>'datepicker']])
			->add("enddate{$i}", TextType::class, ['required'=>false, 'label'=>'End Date', 'attr'=>['widget'=>'single_text', 'class'=>'datepicker', 'label' => 'End Date', 'format'=>'dd-MM-yyyy']])
			->add("qualification{$i}", TextareaType::class, ['required'=>false, 'label'=>'Qualification / Grade', 'attr'=>['rows'=>10]]);
		}
		$form = $form->getForm()->createView();

		
		if($_POST)
		{
			$d = $_POST['form'];

			//  Write out to database
			for($i=1; $i<=$max_recs; $i++)
			{
				$he = $em->getRepository('AppBundle:HistoryEducation')->findOneBy(array('userId'=>$user_id, 'jobId'=>$job_code, 'seq'=>$i));
				if(!$he)
				{
					$he = new \AppBundle\Entity\HistoryEducation();
					$he->setUserId($user_id);
					$he->setJobId($job_code);
					$he->setSeq($i);
				}
				$he->setCourseTitle($d["courseTitle$i"]);
				$he->setEstablishment($d["establishment$i"]);
				$x = $this->stringToDate($d["startdate$i"]);
				if($x) $he->setStartdate($x);
				$x = $this->stringToDate($d["enddate$i"]);
				if($x) $he->setEnddate($x);
				$he->setQualification($d["qualification$i"]);
				$he->setCreatedOn(new \DateTime('now'));
				$em->persist($he);
				$em->flush();
			}
				
			//  If the finalise button was pressed, create the 'finalised' entry
			if($_POST['submit']=='Finalise and Submit')
			{
				$hc = $em->getRepository('AppBundle:HistoriesComplete')->findOneBy(array('userId'=>$user_id, 'jobId'=>$job_code));
				if(!$hc)
				{
					$hc = new \AppBundle\Entity\HistoriesComplete();
					$hc->setUserId($user_id);
					$hc->setJobId($job_code);
				}
				$hc->setEducation(1);
				$em->persist($hc);
				$em->flush();
			}
			
			//  Go back to /checkabl/{job_code}
			return $this->redirect("/checkabl/{$job_code}");

		}

		return $this->render('@App/checkabl/educationhistory.html.twig', array(
			'jobid' => $job_code,
			'form' => $form,
		));
	}


	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/passport/{jobcode}", name="checkabl_passport")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function passportAction(Request $request)
    {
		$this->_checkValidUser();
		$job_code = $request->get('jobcode');		
		$user = $this->getUser();
		$user_id = $user->getId();
		$photo = null;
		$media = $this->em->getRepository('AppBundle:Media');
		$message = null;
        $pd = null;
		if($_POST)
		{
            $srcfile = null;
            if (!empty($_FILES['img']['tmp_name'])) {

                $srcfile = $_FILES['img']['tmp_name'];
                $pathinfo = pathinfo($_FILES['img']['name']);
                $ext = $pathinfo['extension'];
                $key = substr(md5(random_bytes(8)), 0, -1);
                $fullfilename = '/mnt/c/Users/scott/www/hireabl-jobs-master/hireabl-jobs-master/web/ids/' . $key . '.' . $ext;
                move_uploaded_file($srcfile, $fullfilename);
                $srcfile = $fullfilename;
            }
            $a = getimagesize($srcfile);

            if($a[2]==2){
                //  Retrieve photo from POST


                if (!empty($_POST['raw'])) {

                    $data = substr($_POST['raw'], 22);
                    $data = base64_decode($data);
                    $tmpname = tempnam("/mnt/c/Users/scott/www/hireabl-jobs-master/hireabl-jobs-master/web/temp", "IMG") . ".png";
                    $srcfile = $tmpname . ".jpg";
                    file_put_contents($tmpname, $data);
                    exec("convert $tmpname $srcfile");
                    //unlink($tmpname);
                    chmod($srcfile, 0777);
                }


                //  Send the image to GBG for processing
                if (file_exists($srcfile)) {

                    $x = dirname(dirname(__FILE__)) . "/Model/GBG.php";
                    include $x;
                    $ret = GBG_process($srcfile);

                    $succeeded = GBG_checkOK($ret);

                    //  If the image is OK, extract the data, store the photo and redirect
                    if ($succeeded) {
                        //  Extract data and store
                        $data = GBG_extract($ret);
                        $middlename = '';
                        if (!empty($data['Forename'])) {
                            if (strpos($data['Forename'], ' ')) {
                                $n = explode(' ', $data['Forename'], 2);
                                $data['Forename'] = $n[0];
                                $middlename = $n[1];
                            }
                        }
                        if (empty($middlename) and !empty($data['Middlename'])) $middlename = $data['Middlename'];

                        // TODO: make sure data['Type'] == 'Passport', else dispay error
                        $pd = new \AppBundle\Entity\PassportData();
                        $pd->setUserId($user_id);
                        $pd->setJobCode($job_code);
                        $pd->setFirstname(@$data['Forename']);
                        $pd->setMiddlename($middlename);
                        $pd->setSurname(@$data['Surname']);
                        $pd->setGender(@$data['Gender']);
                        $pd->setDob(substr(@$data['DOB'], 0, 10));
                        $pd->setNationality(@$data['Nationality']);
                        $pd->setIssueDate(substr(@$data['IssueDate'], 0, 10));
                        $pd->setExpiryDate(substr(@$data['Expiry'], 0, 10));
                        $pd->setMrz(@$data['MRZ']);
                        $pd->setDocumentNumber(@$data['DocumentNumber']);
                        $pd->setCountry(@$data['Country']);
                        $pd->setAuthenticity(@$data['Result']);
                        $pd->setTestinfo(@$data['TestResults']);
                        $pd->setResponse($ret);
                        $pd->setDateScanned(new \DateTime("now"));
                        $this->em->persist($pd);
                        $this->em->flush();

                        //  Store photo
                        $media->createMediaRecord('PHOTO', 'PASSPORT', 'jpg', 1, $user_id, $job_code);
                        $dest_filename = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'PASSPORT', 1);
                        $destination_filename = substr($this->getParameter('media_full_path'), 0, -6) . $dest_filename;
                        move_uploaded_file($srcfile, $destination_filename);
                        exec("mv $srcfile $destination_filename");

                        //  Update the extrachecks record
                        $ec = $this->em->getRepository('AppBundle\Entity\ExtraChecks')->findOneBy(['userId' => $user_id, 'jobCode' => $job_code, 'checkType' => 'IDENTITY/Passport']);
                        if ($ec) {
                            $ec->setStatus('Completed');
                            $ec->setResult($data['Result']);
                            $this->em->persist($ec);
                            $this->em->flush();
                        }

                        //  Re-direct here to re-display it
                        return $this->redirect("/checkabl/passport/{$job_code}");
                    } else {
                        $message = "The image used was not of sufficient quality please try again.  We recommend using a scanned image for the best result.";
                    }
                }
            }else{

                $message = "The image need to be a jpeg image.";
            }
		}
		else
		{
			//  If a photo was already uploaded, show it
			$photo = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'PASSPORT', 1);
			$pd = $this->em->getRepository('AppBundle\Entity\PassportData')->findOneBy(['userId' => $user_id, 'jobCode'=>$job_code]);
		}

		return $this->render('@App/checkabl/passport.html.twig', array(
			'jobcode' => $job_code,
			'photo' => $photo,
			'pd' => $pd,
            'message' => $message
		));
	}


	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/driving/{jobcode}", name="checkabl_driving")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function drivingAction(Request $request)
    {
		$this->_checkValidUser();
		$job_code = $request->get('jobcode');		
		$user = $this->getUser();
		$user_id = $user->getId();
		$photo = null;
		$media = $this->em->getRepository('AppBundle:Media');
        $message = null;

		if($_POST)
		{
            $srcfile = null;
            if (!empty($_FILES['img']['tmp_name'])) {
                $srcfile = $_FILES['img']['tmp_name'];
                chmod($srcfile, 0777);
            }
            $a = getimagesize($srcfile);

            if($a[2]==2){
                //  Retrieve photo from POST

                if (!empty($_POST['raw'])) {
                    $data = substr($_POST['raw'], 22);
                    $data = base64_decode($data);
                    $tmpname = tempnam("/mnt/c/Users/scott/www/hireabl-jobs-master/hireabl-jobs-master/web/temp", "IMG") . ".png";
                    $srcfile = $tmpname . ".jpg";
                    file_put_contents($tmpname, $data);
                    exec("convert $tmpname $srcfile");
                    //unlink($tmpname);
                    chmod($srcfile, 0777);
                }
                //  Send the image to GBG for processing
                if (file_exists($srcfile)) {
                    $x = dirname(dirname(__FILE__)) . "/Model/GBG.php";
                    include $x;
                    $ret = GBG_process($srcfile);
                    $succeeded = GBG_checkOK($ret);
                    $middlename = null;
                    //  If the image is OK, extract the data, store the photo and redirect
                    if ($succeeded) {
                        //  Extract data and store
                        $data = GBG_extractDrivingData($ret);
                        // TODO: make sure data['Type'] == 'Driving Licence', else display error
                        $dd = new \AppBundle\Entity\DrivingData();
                        $dd->setUserId($user_id);
                        $dd->setJobCode($job_code);
                        $dd->setFirstname(@$data['Forename']);
                        $dd->setMiddlename($middlename);
                        $dd->setSurname(@$data['Surname']);
                        $dd->setGender(@$data['Gender']);
                        $dd->setDob(substr(@$data['DOB'], 0, 10));
                        $dd->setNationality(@$data['Nationality']);
                        $dd->setBuilding(@$data['Building']);
                        $dd->setStreet(@$data['Street']);
                        $dd->setCity(@$data['City']);
                        $dd->setPostcode(@$data['ZipPostcode']);
                        $dd->setDocumentNumber(@$data['DocumentNumber']);
                        $dd->setCountry(@$data['Country']);
                        $dd->setAuthenticity(@$data['Result']);
                        $dd->setTestinfo(@$data['TestResults']);
                        $dd->setResponse($ret);
                        $dd->setDateScanned(new \DateTime("now"));
                        $this->em->persist($dd);
                        $this->em->flush();

                        //  Update the extrachecks record
                        $ec = $this->em->getRepository('AppBundle\Entity\ExtraChecks')->findOneBy(['userId' => $user_id, 'jobCode' => $job_code, 'checkType' => 'IDENTITY/Driving']);
                        if ($ec) {
                            $ec->setStatus('Completed');
                            $ec->setResult($data['Result']);
                            $this->em->persist($ec);
                            $this->em->flush();
                        }

                        //  Store photo
                        $media->createMediaRecord('PHOTO', 'DRIVING', 'jpg', 1, $user_id, $job_code);
                        $dest_filename = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'DRIVING', 1);
                        $destination_filename = substr($this->getParameter('media_full_path'), 0, -6) . $dest_filename;
                        exec("mv $srcfile $destination_filename");

                        //  Re-direct here to re-display it
                        return $this->redirect("/checkabl/driving/{$job_code}");
                    } else {
                        $message = "The image used was not of sufficient quality please try again.  We recommend using a scanned image for the best result.";
                    }
                }
            }else{
                $message = "The image need to be a jpeg image.";
            }
		}
		else
		{
			//  If a photo was already uploaded, show it
			$photo = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'DRIVING', 1);
			$pd = $this->em->getRepository('AppBundle\Entity\DrivingData')->findOneBy(['userId' => $user_id, 'jobCode'=>$job_code]);
		}
		
		return $this->render('@App/checkabl/driving.html.twig', array(
			'jobcode' => $job_code,
			'photo' => $photo,
			'pd' => $pd,
            'message' => $message
		));
	}


	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/aml/{jobcode}", name="checkabl_aml")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function amlAction(Request $request)
    {
		$this->_checkValidUser();
		$job_code = $request->get('jobcode');		
		$user = $this->getUser();
		$user_id = $user->getId();
		$photo = null;
					
		//  Create default data for KYC, taken from driving licence and passport info
		$data = [];
		$data['Mobile'] = $user->getMobiletel();
		$pd = $this->em->getRepository('AppBundle\Entity\PassportData')->findOneBy(['userId' => $user_id, 'jobCode'=>$job_code]);
		$dd = $this->em->getRepository('AppBundle\Entity\DrivingData')->findOneBy(['userId' => $user_id, 'jobCode'=>$job_code]);
		if($pd)
		{
			$data['Forename'] = $pd->getFirstname();
			$data['Surname'] = $pd->getSurname();
			$data['Gender'] = $pd->getGender();
			$data['DOB'] = new \DateTime(substr($pd->getDob(),0,10));
			$data['LongPassportNumber'] = substr($pd->getMrz(),-44);
			$data['ShortPassportNumber'] = $pd->getDocumentNumber();
			$data['PassportIssue'] = new \DateTime(substr($pd->getIssueDate(),0,10));
			$data['PassportExpiry'] = new \DateTime(substr($pd->getExpiryDate(),0,10));
			$data['PassportIssueCountry'] = $pd->getCountry();
		}

		if($dd)
		{
			$data['Forename'] = $dd->getFirstname();
			$data['Surname'] = $dd->getSurname();
			$data['Gender'] = $dd->getGender();
			$data['DOB'] = new \DateTime(substr($dd->getDob(),0,10));
			$data['SurnameAtBirth'] = $dd->getSurname();
			$data['AddressLine1'] = $dd->getBuilding() . ' ' . $dd->getStreet();
			$data['AddressLine3'] = $dd->getCity();
			$data['AddressLine5'] = $dd->getPostcode();
			$data['DLNumber'] = $dd->getDocumentNumber();
			$data['DLForename'] = $dd->getFirstname();
			$data['DLSurname'] = $dd->getSurname();
		}

		$data['ResidentTo'] = new \DateTime("now");
		if (isset($data['AddressLine1'])) {
            $address = $data['AddressLine1'] . ', ';
            if ($data['AddressLine3']) $address .= $data['AddressLine3'] . ', ';

            if ($data['AddressLine5']) $address .= $data['AddressLine5'] . ', ';
            $address = substr($address, 0, -2);
        }
		$form = $this->createForm(\AppBundle\Form\AML::class, $data);
		$form->handleRequest($request);
		
		if ($form->isSubmitted())
		{
			$fdata = $form->getData();

			//  Determine which 'pack' (Agent Profile) we are submitting to 
			$ec = $this->em->createQuery(
				"SELECT ec.id, ec.status, ec.checkType FROM AppBundle:ExtraChecks ec WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'KYC/%' "
				)->setParameters(array('uid'=>$user_id, 'jcode'=>$job_code))
			->getResult();
			$checktype = substr($ec[0]['checkType'],-1);
			$fullchecktype = 'KYC/Pack'.$checktype;
			

			//  Send to GBG
			$x = dirname(dirname(__FILE__))."/Model/GBG.php";
			include $x;
			$ret = GBG_runAgentCheck($checktype, $_POST['aml']);
			if(!empty($ret->AuthenticateSPResult->BandText))
			{
				$result = $ret->AuthenticateSPResult->BandText;
				$info = serialize(GBG_extractSP($ret));
			}
			else
			{
				$result = 'Report Failed';				
				$info = '';
			}

			// record in aml_data
			$ad = new \AppBundle\Entity\AMLData();
			$ad->setUserId($user_id);
			$ad->setJobCode($job_code);
			$ad->setAddress('4 edy court');
			$ad->setDataSent($_SESSION['data_sent']);
			$ad->setAuthenticity($result);
			$ad->setTestinfo($info);
			$ad->setResponse(serialize($ret));
			$ad->setDateScanned(new \DateTime("now"));
			$this->em->persist($ad);
			$this->em->flush();

			//  Update the extrachecks record
			$ec = $this->em->getRepository('AppBundle\Entity\ExtraChecks')->findOneBy(['userId' => $user_id, 'jobCode'=>$job_code, 'checkType'=>$fullchecktype]);
			if($ec)
			{
				$ec->setStatus('Completed');
				$ec->setResult($result);
				$ec->setDateCompleted(new \DateTime("now"));
				$this->em->persist($ec);
				$this->em->flush();						
			}

			// redirect to /checkabl/{job}
			return $this->redirect("/checkabl/{$job_code}");
		}

		
		return $this->render('@App/checkabl/aml.html.twig', array(
			'jobcode' => $job_code,
			'form' => $form->createView(),
		));
	}
	
	
	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/visualid/{jobcode}", name="checkabl_visualid")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function visualidAction(Request $request)
    {
		$this->_checkValidUser();
		$job_code = $request->get('jobcode');		
		$user = $this->getUser();
		$user_id = $user->getId();
		$photo = null;
		$media = $this->em->getRepository('AppBundle:Media');
		
		
		//  Check to see if a pasport (preferred) or driving licence ID have
		//  been uploaded, before allowing user to submit an image.
		
		$passport = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'PASSPORT', 1);
		$driving = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'DRIVING', 1);
		$ready_to_capture = (empty($passport) and empty($driving)) ? false : true;

		if($_POST)
		{
			//  Retrieve photo from POST
			$srcfile = null;
			if(!empty($_FILES['img']['tmp_name']))
			{
				$srcfile = $_FILES['img']['tmp_name'];
				chmod($srcfile,0777);
			}
			if(!empty($_POST['raw']))
			{
				$data = substr($_POST['raw'],22);
				$data = base64_decode($data);
				$tmpname = tempnam("/tmp","IMG") . ".png";
				$srcfile = $tmpname . ".jpg";
				file_put_contents($tmpname,$data);
				exec("convert $tmpname $srcfile");
				unlink($tmpname);
				chmod($srcfile,0777);
			}
			
			//  Store photo and process
			if(file_exists($srcfile))
			{
				$media->createMediaRecord('PHOTO', 'VISUALID', 'jpg', 1, $user_id, $job_code);
				$dest_filename = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'VISUALID', 1);
				$destination_filename = substr($this->getParameter('media_full_path'),0,-6) . $dest_filename;
				exec("mv $srcfile $destination_filename");
				
				// Send image for facial recognition
				$facerec = new \AppBundle\Model\Facerec();
				
				if($passport)	{ $srcimg = $passport; $source='PASSPORT'; } 
				else			{ $srcimg = $driving; $source='DRIVING'; } 
				$res = $facerec->compare($srcimg, $dest_filename);
				
				//  Store result
				$fc = new \AppBundle\Entity\FaceCompareChecks();
				$fc->setUserId($user_id);
				$fc->setJobCode($job_code);
				$fc->setSource($source);
				$fc->setResponse($res);
				$fc->setResult($res);
				$this->em->persist($fc);
				$this->em->flush();
				
				//  Update the extrachecks record
				$sv = $this->em->getRepository('AppBundle\Entity\ExtraChecks')->findOneBy(['jobCode' => $job_code, 'userId'=>$user_id, 'checkType'=>'Visual/Checkabl']);
				if(!$sv)
				{
					return $this->render('@App/error/usererror.html.twig', array(
						'title' => 'ID Check processing error',
						'msg' => 'The ID Check you are uploading does not seem to be a valid request.',
					));
				}
				$sv->setStatus('Completed');
				$sv->setDateCompleted(new \DateTime("now"));
				$sv->setResult($res);
				$this->em->persist($sv);
				$this->em->flush();
			}
			
			//  Re-direct here
			return $this->redirect("/checkabl/visualid/{$job_code}");
		}
		else
		{
			//  If a photo was already uploaded, show it
			$photo = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'VISUALID', 1);
			
		}
		
		return $this->render('@App/checkabl/visualid.html.twig', array(
			'jobcode' => $job_code,
			'photo' => $photo,
			'ready_to_capture' => $ready_to_capture,
		));
	}

	
	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/director/{jobcode}", name="checkabl_director")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function directorAction(Request $request)
    {
		$this->_checkValidUser();
		$job_code = $request->get('jobcode');
		$user = $this->getUser();
		$user_id = $user->getId();
		$dir = new \AppBundle\Model\Directorship();
		$dc = new \AppBundle\Entity\DirectorChecks();
		
		
		//  Check to see if part 1 (full name) has been posted. If so, look up companies house data

		$firstname = $user->getFirstname();
		$surname = $user->getSurname();
		$list = array();
		
		if(!empty($_POST['part1']))
		{
			$name = $_POST['firstname'].' '.$_POST['surname'];
			$list = $dir->search($name);
			$_SESSION['directorslist'] = $list;
		}

		if(!empty($_POST['part2']))
		{
			//  If part 2 (company selection) has been posted, store data and return
			$sv = $this->em->getRepository('AppBundle\Entity\ExtraChecks')->findOneBy(['jobCode' => $job_code, 'userId'=>$user_id, 'checkType'=>'Director']);
			if(!$sv)
			{
				return $this->render('@App/error/usererror.html.twig', array(
					'title' => 'ID Check processing error',
					'msg' => 'The ID Check you are uploading does not seem to be a valid request.',
				));
			}
			$output = '';
			foreach($_POST as $fld=>$val)
			{
				if(substr($fld,0,3)=='chk' and $val=='on')
				{
					$id = substr($fld,3);
					$url = $_SESSION['directorslist'][$id]['link'];
					$recs = $dir->getAppointments($url);
					foreach($recs as $idx=>$rec) {
						$output .= ucfirst($rec['role']) . ", " . $rec['companyName'] . ' (' . $rec['companyNumber'] . ")\n";
					}
				}
			}

			$sv->setStatus('Completed');
			$sv->setDateCompleted(new \DateTime("now"));
			$sv->setResult('n/a');
			$this->em->persist($sv);
			
			$dc->setUserId($user_id);
			$dc->setJobCode($job_code);
			$dc->setCompanies($output);
			$this->em->persist($dc);
			$this->em->flush();			
			return $this->redirect("/checkabl/{$job_code}");
		}

		//  Get the users firstname and surname and display form
		
		return $this->render('@App/checkabl/director.html.twig', array(
			'firstname' => $firstname,
			'surname' => $surname,
			'list' => $list,
		));
	}



	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/checkabl/dbs/{jobid}", name="checkabl_dbs")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dbsAction(Request $request)
    {
		$job_code = $request->get('jobid');
		return $this->render('@App/checkabl/nomodule.html.twig', array(
			'jobid' => $job_code,
		));
	}

	
	public function dateToString($date)
	{
		if(empty($date)) return '';
		return $date->format('d-m-Y');
	}
	
	
	public function stringToDate($string)
	{
		if(empty($string)) return '';
		$Ymd = substr($string,6,4) .'-'.  substr($string,3,2) .'-'. substr($string,0,2);
		$d = new \DateTime($Ymd);
		return $d;
	}

	
}
