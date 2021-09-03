<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WebHookTests;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\TermsEdit;
use AppBundle\Entity\Terms;

class TermsAdminController extends Controller
{
    /**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/terms/admin", name="terms_admin")
     */
    public function listAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();		

		//  If we were POSTed to, then process request to add a new T&C form
		//  (ignore the request if the title is blank)
		
		if($_POST)
		{
			if(!empty($_POST['title']))
			{
				$t = new Terms();
				$t->setTitle(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
				$t->setTerms("To be edited");
				$t->setEmployer($employer_id);
				$t->setCreatedOn(new \DateTime("now"));
				$em->persist($t);
				$em->flush();
			}
			return $this->redirect("/terms/admin");
		}
		
		//  Non-POST, grab terms list and display it
		$termslist = $em->getRepository('AppBundle:Terms')->getTermsList($employer_id);
		return $this->render('@App/termsadmin/list.html.twig', array(
			'terms' => $termslist,
		));
	}
	
	
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/terms/delete/{id}", name="terms_delete")
     */
    public function deleteAction(Request $request)
    {
		$id = $request->get('id');
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();

		$em = $this->getDoctrine()->getManager();				
		$em->getRepository('AppBundle:Terms')->deleteTerms($employer_id, $id);
		return $this->redirect("/terms/admin");
	}
	
		
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/terms/edit/{id}", name="terms_edit")
     */
    public function editAction(Request $request)
    {
		$id = $request->get('id');
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		// TODO: verify this terms belongs to this employer

		$em = $this->getDoctrine()->getManager();
		$terms = $em->getRepository('AppBundle:Terms')->findOneBy(['id'=>$id]);
	
		$form = $this->createForm(TermsEdit::class, $terms); 
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$data = $form->getData();
			$em->persist($data);
			$em->flush();
			return $this->redirect("/terms/admin");
		}

		return $this->render('@App/termsadmin/edit.html.twig', array(
			'form' => $form->createView(),
		));
	}


	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/terms/assign/{terms_id}", name="terms_assign")
     */
    public function assignAction(Request $request)
    {
		$terms_id = $request->get('terms_id');
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();		
		$terms = $em->getRepository('AppBundle:Terms')->findOneBy(['id'=>$terms_id]);

		// TODO: verify this terms belongs to this employer

		// If POSTed, write changes to database
		if($request->isMethod('POST'))
		{
			$em->getRepository('AppBundle:Terms')->saveAssignedJobs($terms_id, $_POST);
			return $this->redirect("/terms/admin");
		}
		
		//  Otherwise, fetch database and display
		$recs = $em->getRepository('AppBundle:Terms')->getAssignedJobs($employer_id, $terms_id);

		
		return $this->render('@App/termsadmin/assign.html.twig', array(
			'recs' => $recs,
			'title' => $terms->getTitle(),
		));
	}
	
}
