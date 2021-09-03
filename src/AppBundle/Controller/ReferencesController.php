<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Entity;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Repository;


class ReferencesController extends Controller
{
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/references/view/{id}", defaults={"id"=0}, name="references_list")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
	{
		$id = $request->get('id');
		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();
		$jobs = $em->getRepository('AppBundle:Jobs')->getJoblistByEmployer($employer_id);

		return $this->render('@App/references/list.html.twig', array(
			'jobs' => $jobs,
			'id'=> $id,
		));
	}
}
