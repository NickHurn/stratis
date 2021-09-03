<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;
use AppBundle\Entity\FormQuestionsRepository;


class PrescreenController extends Controller
{
	/**
	 * @Security("has_role('ROLE_APPLICANT')")
     * @Route("/prescreen/{jobid}", name="prescreen_form")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
		$job_id = $request->get('jobid');
		$user = $this->getUser();
		$user_id = $user->getId();

		$em = $this->getDoctrine()->getManager();		
		$fb = $em->getRepository('AppBundle:Forms');
		$fq = $em->getRepository('AppBundle:FormQuestions');
		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$job_id]);
		$form_id = $fb->getIdFromJob($job_id);

		//  If this user is not an applicant for the jobid specified, re-direct to [alt_domain]/jobs/selection
		//  TODO

		//  If this user has already completed the form, re-direct to [alt_domain]/jobs/selection
		//  TODO


		//  If this a POST then save the form answers
		if ($request->isMethod('POST'))
		{
			// Save form contents and re-direct back to /jobs/selection
			$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$em->getRepository('AppBundle:FormAnswers')->saveFormAnswers($form_id, $user_id, $_POST);
			return $this->redirect("/checkabl/$job_id");
		}

		//  Load the pre-screen form and display it
		$html = $fq->buildFormHtml($form_id, $user_id);
		return $this->render('@App/prescreen/applicantform.html.twig', array(
			'form_html' => $html,
			'jobtitle' => $job->getTitle(),
		));
    }

}
