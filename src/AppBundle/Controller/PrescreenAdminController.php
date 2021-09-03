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



class PrescreenAdminController extends Controller
{
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/prescreenadmin", name="prescreenadmin_list")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		$wl = $em->getRepository('AppBundle:CssSchemes')->getEmployerIdFromDomain();

		// Search for all Pre-screen jobs for this employer and display
		$jobs = $em->getRepository('AppBundle:Forms')->getList($employer_id, 'PRESCREEN');

		// Get counts of complete pre-screen forms for this employer
		$x = $em->getRepository('AppBundle:Forms')->getCompletedPreScreenCount($employer_id);

		// Merge the two
		foreach($x as $idx=>$i) {
		    $count[$i['formId']] = $i['c'];
        }
		foreach($jobs as $idx=>$j) { 
			if(!empty($j['id'])) {
				if(!empty($count[$j['id']])) {
				    $jobs[$idx]['completed'] = $count[$j['id']];
                }else{
                    $jobs[$idx]['completed'] = '--';
                }
			}
		}

		return $this->render('@App/prescreenadmin/list.html.twig', array(
			'jobs' => $jobs,
			'companyName' => $wl['company_name'],
			'urlprefix' => 'https://' . $wl['domain'] . '/jobs/apply/id/',
		));
    }


	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/prescreenadmin/answers/{completedId}/{applicantId}", name="prescreenadmin_answers")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function answersAction(Request $request, $completedId,$applicantId )
    {
		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();

		// Check that this form is owned by this employer
		$info = $em->getRepository('AppBundle:Forms')->getFormCandidateInfo($completedId, $employer_id,$applicantId);
		$rec = $info[0];

		
		//  Get all the answers by this candidate 
		$answers = $em->getRepository('AppBundle:FormAnswers')->findBy(['formId'=>$completedId, 'userId'=>$rec['userId']], ['seq'=>'ASC']);
		//$answers = $em->getRepository('AppBundle:FormAnswers')->findBy(['formId'=>$completed_id, 'userId'=>$rec['userId']] );

		//  Display
		return $this->render('@App/prescreenadmin/answers.html.twig', array(
			'info' => $rec,
			'answers' => $answers,
		));
    }

	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/prescreenadmin/edit/{uniqueid}", name="prescreenadmin_edit")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
		$job_id = $request->get('uniqueid');
		$em = $this->getDoctrine()->getManager();
		
		//  Create questionnaire record if needed
		$form = $em->getRepository('AppBundle:Forms')->createOrFetchForm('Pre-Screen', 'PRESCREEN', $employer_id, $job_id);

		$job = $em->getRepository('AppBundle:Jobs')->findOneBy(array('uniqueid' => $job_id));

		//  Display
		return $this->render('@App/prescreenadmin/edit.html.twig', array(
			'title' => $job->getTitle(),
			'formid' => $form->getId(),
			'passscore' =>floor($form->getPassScore()),
		));
    }


	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/prescreenadmin/delete/{uniqueid}", name="prescreenadmin_delete")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
		$job_id = $request->get('uniqueid');
		$em = $this->getDoctrine()->getManager();

		$form = $em->getRepository('AppBundle:Forms')->findOneBy(array('jobId' => $job_id, 'formType'=>'PRESCREEN', 'employerId'=>$employer_id));
		$form_id =$form->getId();
		$em->remove($form);
		$em->flush();

		//  delete from form_questions where form_id=id
		$q = $em->createQuery("delete from AppBundle:FormQuestions fq WHERE fq.formId = {$form_id}");
		$q->execute();

		//  Return
		return $this->redirect('/prescreenadmin');
    }

	
}
