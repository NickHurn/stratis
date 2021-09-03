<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WebHookTests;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Forgot2PasswordController extends Controller
{
    /**
     * @Route("/forgettenpassword", name="forgotten_password")
     */
    public function forgettenpasswordAction(Request $request)
    {
		die('OK!');
    }
}
