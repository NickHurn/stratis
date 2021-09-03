<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApplicantRating;
use AppBundle\Entity\Employers;
use AppBundle\Entity\Jobs;
use AppBundle\Entity\Watch;
use AppBundle\Form\ApplicantViewDateFilters;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\UsersJob;
use AppBundle\Entity\ApplicantShare;
use AppBundle\Entity\Users;
use AppBundle\Form\ApplicantDelete;
use AppBundle\Form\ApplicantVerifyDelete;


class MediaRecordController extends Controller
{
    /**
     * @Route("/mediarecord/videoa/{questionId}", name="mediarecord_videoanswer")
     */
    public function mediarecordAAction(Request $request)
    {
		$rawdata = file_get_contents("php://input");
		
		$user = $this->getUser();
		$user_id = $user->getId();
		$em = $this->getDoctrine()->getManager();		
		$questionId = $request->get('questionId');
		$media = $em->getRepository('AppBundle:Media')->createMediaRecord('VIDEO', 'VIDEO-ANSWER', 'mp4', 1, $user_id, null);
		$id = $media->getId();
		$dir = '/'.floor($id/1000);
		$filename = $media->getFilename() . '.' . $media->getExtn();
		$filename_orig = $media->getFilename() . '.orig';
		$mediapath = $this->getParameter('media_full_path');
		file_put_contents("{$mediapath}{$dir}/{$id}-video-{$filename_orig}", $rawdata);
		exec("cd {$mediapath}{$dir} && /usr/bin/ffmpeg2/ffmpeg -i {$id}-video-{$filename_orig} -c:a aac -c:v h264 {$id}-video-{$filename}");
		
		// Write the media Id to the video_answers table
		$va = $em->getRepository('AppBundle\Entity\VideoAnswers')->findOneBy(array('questionId' => $questionId, 'userId'=>$user_id));
		if(!$va) {
			//  If answer record does not exist, copy it from question record
			$vq = $em->getRepository('AppBundle\Entity\VideoQuestions')->findOneBy(array('id' => $questionId));
			$va = new \AppBundle\Entity\VideoAnswers();
			$va->setJobId($vq->getJobId());
			$va->setQuestionId($questionId);
			$va->setUserId($user_id);
			$va->setCreatedOn(new \DateTime()); 
			file_put_contents("/tmp/va", var_export($vq));
		}
		$va->setMediaId($id);
		$em->persist($va);
		$em->flush();
		die('OK');
    }
	

	/**
     * @Route("/mediadelete/videoa/{jobid}/{id}", name="mediadelete_videoanswer")
     */
    public function mediadeleteAAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$id = $request->get('id');
		$jobid = $request->get('jobid');

		$em = $this->getDoctrine()->getManager();

		
		//  Clear out old record from video_answers
		$va = $em->getRepository('AppBundle\Entity\VideoAnswers')->findOneBy(array('questionId' => $id, 'jobId'=>$jobid, 'userId'=>$user_id));
		if($va)
		{
			$mediaId = $va->getMediaId();
			$job_code = $va->getJobId();
			//$va->setMediaId(0);
			$em->remove($va);
			$em->flush();

			if($mediaId) 
			{
				$mediapath = $this->getParameter('media_full_path');
				$em->getRepository('AppBundle\Entity\Media')->deleteMediaFile($mediaId, $mediapath);
			}
			die('OK');
		}
		else
		{
			die('ERROR');
		}
	}


	/**
     * @Route("/mediarecord/videoq/{questionId}", name="mediarecord_videoquestion")
     */
    public function mediarecordQAction(Request $request, $questionId)
    {
		$rawdata = file_get_contents("php://input");
        $user = $this->getUser();
        $user_id = $user->getId();
		$em = $this->getDoctrine()->getManager();		
		$media = $em->getRepository('AppBundle:Media')->createMediaRecord('VIDEO', 'VIDEO-QUESTION', 'mp4',1, $user_id, null);
		$id = $media->getId();
		$dir = '/'.floor($id/1000);
		$filename = $media->getFilename() . '.' . $media->getExtn();
        $filename_orig = $media->getFilename() . '.orig';
		$mediapath = $this->getParameter('media_full_path');
        file_put_contents("{$mediapath}{$dir}/{$id}-video-{$filename_orig}", $rawdata);
        exec("cd {$mediapath}{$dir} && /usr/bin/ffmpeg2/ffmpeg -i {$id}-video-{$filename_orig} -c:a aac -c:v h264 {$id}-video-{$filename}");

		// Write the media Id to the video_questions table
		$vq = $em->getRepository('AppBundle\Entity\VideoQuestions')->findOneBy(array('id' => $questionId));
		$vq->setMediaId($id);
		$em->flush();
		die('OK');
    }

	
	/**
     * @Route("/mediadelete/videoq/{id}", name="mediadelete_videoquestion")
     */
    public function mediadeleteQAction(Request $request, $id)
    {
		$em = $this->getDoctrine()->getManager();
		//  TODO: authority check

		//  Clear out id from media_id on video_questions
		$vq = $em->getRepository('AppBundle\Entity\VideoQuestions')->findOneBy(array('id' => $id));
		$mediaId = $vq->getMediaId();
		$vq->setMediaId(0);
		$em->flush();

		if($mediaId) 
		{
			$mediapath = $this->getParameter('media_full_path');
			$em->getRepository('AppBundle\Entity\Media')->deleteMediaFile($mediaId, $mediapath);
		}
		die('OK');
    }
}

