<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WebHookTests;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DevphoneController extends Controller
{
    /**
     * @Route("/devphone/clear", name="devphone_clear")
     */
    public function clearAction(Request $request)
    {
		$user_id = null;
		if($this->getUser()) $user_id = $this->getUser()->getId();
		$this->getDoctrine()->getEntityManager()->getRepository('AppBundle\Entity\Devphone')->clearmsgs($user_id);
		die('OK');
	}

	
	/**
     * @Route("/devphone/check", name="devphone_check")
     */
    public function checkAction(Request $request)
    {
		if(!$this->getUser())
		{
			$user_id = null;
		}
		else
		{
			$user_id = $this->getUser()->getId();
		}

		$ph = $this->getDoctrine()->getManager()->getRepository('AppBundle\Entity\Devphone');
		$msgs = $ph->check($user_id);
		$ph->clear($user_id);
		print $msgs;
		die;
    }

	
}
