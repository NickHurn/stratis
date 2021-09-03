<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\ExtraChecks;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Entity;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Repository;


class IDChecksController extends Controller
{
	/**
	 * @Security("has_role('ROLE_CLIENT')")	q
     * @Route("/idchecks/list/{type}/{job}/{user}", defaults={"type"="Summary", "job"="0", "user"="0"}, name="idchecks_list")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function idchecksAction(Request $request)
    {
		$type = $request->get('type');
		$jobid = $request->get('job');
		$userid = $request->get('user');

		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();

		$users = $em->getRepository('AppBundle\Entity\ExtraChecks')->getUsersList($employer_id);
		$jobs = $em->getRepository('AppBundle\Entity\ExtraChecks')->getJobsList($employer_id);

		//  Check if passed parameters are OK
		$bOK = true;
		if(!$bOK)
		{
			return $this->render('@App/error/error.html.twig', array(
				'title' => 'Invalid Request',
				'msg' => 'The parameters passed are not valid',
			));
		}
		

		if($type=='Detail')
		{
			$recs = $em->getRepository('AppBundle\Entity\ExtraChecks')->getDetailList($employer_id, $jobid, $userid);
		}
		else
		{
			$recs = $em->getRepository('AppBundle\Entity\ExtraChecks')->getSummaryList($employer_id, $jobid, $userid);
		}

		return $this->render('@App/idchecks/list.html.twig', array(
			'type' => $type,
			'jobid' => $jobid,
			'userid' => $userid,
			'jobs' => $jobs,
			'users' => $users,
			'recs' => $recs,
		));
	}



	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/idchecks/{user}/{jobcode}", name="idchecks_user")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function idcheckresultAction(Request $request)
    {
		$user_id = $request->get('user');
		$job_code = $request->get('jobcode');
		$em = $this->getDoctrine()->getManager();
		$media = $em->getRepository('AppBundle:Media');

		$x = dirname(dirname(__FILE__)) . "/Model/gbgid.php";
		include $x;


		$id_photo = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'PHOTOID', 1);
		$face_photo = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'VISUALID', 1);
		$id_url = substr($this->getParameter('media_full_path'),0,-6) . $id_photo;
		$face_url = substr($this->getParameter('media_full_path'),0,-6) . $face_photo;

		
		//  Get and Cache the ID detect result
		$file = "/tmp/cache-id-" . strtr("/tmp/$id_url",array("/"=>"-"));
		if(file_exists($file))
		{
			$resp = file_get_contents($file);
		}
		else
		{
			$resp = $this->uploadAndDetect($id_url);
			file_put_contents($file,$resp);
		}
		$data = json_decode($resp, true);
		$id_info = $data['faces'][0];
		$id_nicedata = $this->getNiceData($data['faces'][0]);


		//  Get and Cache the photo detect result
		$file = "/tmp/cache-id-" . strtr("/tmp/$face_url",array("/"=>"-"));
		if(file_exists($file))
		{
			$resp = file_get_contents($file);
		}
		else
		{
			$resp = $this->uploadAndDetect($face_url);
			file_put_contents($file,$resp);
		}
		$data = json_decode($resp, true);
		$face_info = $data['faces'][0];
		$face_nicedata = $this->getNiceData($data['faces'][0]);

		
		//  Compare the faces
	
		$resp = $this->compare($face_info['face_token'], $id_info['face_token']);
		$data = json_decode($resp, true);
		$comp_info = $data;
		
		//  Get and cache the ID verification data
		
		$file = "/tmp/cache-validate-" . strtr("/tmp/$id_url",array("/"=>"-"));
		if(file_exists($file))
		{
			$resp = file_get_contents($file);
		}
		else
		{
			$resp = id3($id_url);
			file_put_contents($file,$resp);
		}
		$txt = $resp;
		$s = strpos($txt,"<UploadAndProcessResponse");
		$e = strpos($txt,"</UploadAndProcessResponse>");
		if($s>0 and $e>0)
		{
			$mid = substr($txt,$s,$e+26-$s+1);
			$xml = simplexml_load_string($mid, "SimpleXMLElement", LIBXML_NOCDATA);
			$json = json_encode($xml);
			$array = json_decode($json,TRUE);
			$x = print_r($array,true);
			$validation = nl2br($x);
		}
		else
		{
			$validation = htmlspecialchars($txt);
		}
				
		return $this->render('@App/idchecks/result.html.twig', array(
			'id_photo' => $id_photo,
			'face_photo' => $face_photo,
			'id_info' => nl2br(print_r($id_info,true)),
			'face_info' => nl2br(print_r($face_info,true)),
			'id_nicedata' => $id_nicedata,
			'face_nicedata' => $face_nicedata,
			'comp_info' => $comp_info['confidence'],
			'validation' => $validation,
		));
	}

	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/idchecks/extrachecks/{user}/{jobcode}", name="idchecks_extrachecks")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function idchecksextraAction(Request $request)
    {
		$job_code = $request->get('jobcode');
		$user = $request->get('user');
		$em = $this->getDoctrine()->getManager();
        $errors = false;
		//  Retrieve check record
		$ec = $em->getRepository('AppBundle:ExtraChecks')->findBy(['jobCode'=>$job_code, 'userId'=>$user]);
		$previousEC = $em->getRepository('AppBundle:IdChecks')->getPreviousExtraChecks($user, $job_code);
		$got = [];
		foreach($ec as $idx=>$r)
		{
			$t = $r->getCheckType();
			if(substr($t,0,4)=='DBS/') $got['DBS'] = substr($t,4);
			if(substr($t,0,8)=='KYC/Pack') $got['KYC'] = substr($t,8);
			$got[$t] = 1;
		}

		if($_POST)
		{
			$errors = $em->getRepository('AppBundle:ExtraChecks')->save($_POST['aid'], $_POST['jid'], $_POST, $this->getUser());
            if (empty($errors)) {
                //  Go back to calling page
                header("Location: " . $_POST['url']);
                exit;
            }
		}
		return $this->render('@App/idchecks/extrachecks.html.twig', array(
			'user_id' => $user,
			'job_code' => $job_code,
			'got' => $got,
            'ec'=>$ec,
            'previousEC'=>$previousEC,
            'errors'=>$errors,
		));
	}

	
	public function uploadAndDetect($imageurl)
	{
		$url = 'https://api-us.faceplusplus.com/facepp/v3/detect';
		$fields = ['image_file' => new \CurlFile($imageurl, 'image/jpg', 'image.jpg')];
		$fields['api_key'] = 'hf7MG9stHAtT5u5WVQZERO8wt1q-HG4S';
		$fields['api_secret'] = 'RhJGthOCA2cwhaxt5-hffzQcU4RBoRUP';
		$fields['return_attributes'] = 'gender,age,smiling,headpose,facequality,blur,eyestatus,emotion,ethnicity,beauty,mouthstatus,eyegaze,skinstatus';

		$ch = curl_init($url);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		return $response;
	}

	
	public function compare($face1,$face2)
	{
		$url = 'https://api-us.faceplusplus.com/facepp/v3/compare';
		$fields['api_key'] = 'hf7MG9stHAtT5u5WVQZERO8wt1q-HG4S';
		$fields['api_secret'] = 'RhJGthOCA2cwhaxt5-hffzQcU4RBoRUP';
		$fields['face_token1'] = $face1;
		$fields['face_token2'] = $face2;

		$ch = curl_init($url);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		return $response;
	}

	public function getNiceData($data)
	{
		$ret['emotion'] = 'unknown';
		$score = 0;
		foreach($data['attributes']['emotion'] as $emot=>$sc)
		{
			if($sc>$score) { $score=$sc; $ret['emotion'] = $emot; }
		}

		$ret['gender'] = $data['attributes']['gender']['value'];
		$ret['approx_age'] = $data['attributes']['age']['value'];
		$ret['ethnicity'] = $data['attributes']['ethnicity']['value'];
		return $ret;
	}

	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/idchecks/report/{report_id}/{user_id}/{job_code}", name="idchecks_reportScreen")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function idchecksReportAction(Request $request)
    {
		$report_id = $request->get('report_id');
		$user_id = $request->get('user_id');
		$job_code = $request->get('job_code');

		$em = $this->getDoctrine()->getManager();
		
		//  Get the user and job records (to getuser name and job title
		$user = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$user_id]);
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$job_code]);
		$candidate = $user->getFirstname() . ' ' . $user->getSurname();
		$jobtitle = $job->getTitle();
        $repTyp = null;
        $data = null;
        $kycdata = null;
        $testinfo_html = null;
        $photo=null;
		//  Get the extrachecks report record. If not found, display error.
		$ec = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['id'=>$report_id, 'jobCode'=>$job_code, 'userId'=>$user_id]);
		if(!$ec)
		{
			return $this->render('@App/error/error.html.twig', array(
				'title' => 'Invalid Request',
				'msg' => 'Sorry but this report does not seem to exist.',
			));
		}
		$reportType = $ec->getCheckType();


		if($reportType=='Director')
		{
			$data = $em->getRepository('AppBundle:DirectorChecks')->findOneBy(['jobCode'=>$job_code, 'userId'=>$user_id]);
			$flag='tick';
            $dataText= "";
			if ($data) {
                if ($data->getCompanies() == '') $flag = 'na';
                $dataText = $data->getCompanies();
            }
			return $this->render('@App/idchecks/report.html.twig', array(
				'data' => $data,
				'flag' => $flag,
				'repTyp' => 'DIRECTOR',
				'reportType' => 'Directorships',
				'candidate' => $candidate,
				'jobtitle' => $jobtitle,
				'text' => $dataText,
                'photo'=>null,
			));
		}

		
		if($reportType=='Visual/Checkabl')
		{
			$data = $em->getRepository('AppBundle:FaceCompareChecks')->findOneBy(['jobCode'=>$job_code, 'userId'=>$user_id]);
			$result = $data->getResult();
			$media = $em->getRepository('AppBundle:Media');
			$leftphoto = $media->getMediaFilename('PHOTO', $user_id, $job_code, $data->getSource(), 1); // PASSPORT or DRIVING
			$rightphoto = $media->getMediaFilename('PHOTO', $user_id, $job_code, 'VISUALID', 1);

			$flag='tick';
			if($result<50) $flag='cross';
			if($result>=50 and $result<75) $flag=='na';
			
			return $this->render('@App/idchecks/report.html.twig', array(
				'result' => $result,
				'flag' => $flag,
				'leftphoto' => $flag,
				'repTyp' => 'FACECOMPARE',
				'reportType' => 'Facial Comparison',
				'candidate' => $candidate,
				'jobtitle' => $jobtitle,
				'leftphoto' => $leftphoto,
				'rightphoto' => $rightphoto,
			));
		}


		if(substr($reportType,0,3)=='KYC')
		{
			$repTyp = 'KYC';
			$photo = '';
			$data = $em->getRepository('AppBundle:AMLData')->findOneBy(['jobCode'=>$job_code, 'userId'=>$user_id]);
			$gc = new \AppBundle\Model\GbgCleanup();
            if($data) {
                $kycdata = unserialize($data->getTestinfo());
                $kycdata = $gc->fixdata($kycdata);
            }
		}
		if($reportType == 'IDENTITY/Driving')
		{
			$repTyp = 'ID';
			$photo = $em->getRepository('AppBundle:Media')->getMediaFilename('PHOTO', $user_id, $job_code, 'DRIVING', 1);
			$data = $em->getRepository('AppBundle:DrivingData')->findOneBy(['jobCode'=>$job_code, 'userId'=>$user_id]);
			$kycdata = '';
		}
		if($reportType == 'IDENTITY/Passport')
		{
			$repTyp = 'ID';
			$photo = $em->getRepository('AppBundle:Media')->getMediaFilename('PHOTO', $user_id, $job_code, 'PASSPORT', 1);
			$data = $em->getRepository('AppBundle:PassportData')->findOneBy(['jobCode'=>$job_code, 'userId'=>$user_id]);
			$kycdata = '';
		}

		if($repTyp <>'KYC')
		{
		    if($data) {
                $lines = explode("\n", $data->getTestinfo());
                $testinfo_html = '';
                foreach ($lines as $line) {
                    $line = trim($line);
                    $kv = explode(":", $line, 2);
                    if (!empty($kv[0]) and !empty($kv[1])) $testinfo_html .= "<tr><td>" . $kv[0] . "</td><td>" . $kv[1] . "</td></tr>";
                }
            }
		}
		else
		{
			$testinfo_html = '';
		}

		$flag='cross';
        if($data) {
            $x = $data->getAuthenticity();
            if($x=='Forged') $flag='cross';
            if($x=='Authentic') $flag='tick';
            if($x=='Refer') $flag='na';
        }

		return $this->render('@App/idchecks/report.html.twig', array(
			'data' => $data,
			'flag' => $flag,
			'kycdata' => $kycdata,
			'repTyp' => $repTyp,
			'testinfo_html' => $testinfo_html,
			'photo' => $photo,
			'reportType' => $reportType,
			'candidate' => $candidate,
			'jobtitle' => $jobtitle,
		));
	}
}
