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


class StaffController extends Controller
{
    /**
	 * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_CLIENT')")
     * @Route("/staff", name="staff")
     */
    public function staffAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();		

		$staff = $em->getRepository('AppBundle:Users')->getStaffList($employer_id);
		
		return $this->render('@App/staffadmin/list.html.twig', array(
			'staff' => $staff,
			'id' => $user_id,
		));
	}

	
	/**
	 * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_CLIENT')")
     * @Route("/staff/delete/{id}", name="staff_delete")
     */
    public function deleteAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$id = $request->get('id');

		$em = $this->getDoctrine()->getManager();		
		$q = $em->createQuery("delete from AppBundle:Users u WHERE u.id<>$user_id AND u.id=$id AND u.employerId=$employer_id");
		$numDeleted = $q->execute();
		if($q==1)
		{
			// delete role record
			$q = $em->createQuery("delete from AppBundle:UsersRoles ur WHERE ur.usersId=$id");
			$q->execute();
		}
		return $this->redirect("/staff");
	}

}
