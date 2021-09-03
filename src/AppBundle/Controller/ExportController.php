<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WebHookTests;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ExportController extends Controller
{
    /**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/export/user/{id}", name="export_user")
     */
    public function exportAction(Request $request)
    {

		$user = $this->getUser();
		$user_id = $user->getId();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();		

		return $this->render('@App/export/user.html.twig', array(
		));
	}
}
