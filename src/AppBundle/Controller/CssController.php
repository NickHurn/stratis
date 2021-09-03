<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;
use AppBundle\Entity\CssSchemes;


//  This controller will output the css for the currently selected client, based on the domain name.



class CssController extends Controller
{
    /**
     * @Route("/css/custom.css", name="custom_css")
     */
    public function cssAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$css = $em->getRepository('AppBundle:CssSchemes')->findOneBy(array('domain'=>$_SERVER['HTTP_HOST']));
		if(!$css)
		{
			$css = new \AppBundle\Entity\CssSchemes();
			$css->setHeaderBackground('#f3c412');
            $css->setHeaderBackgroundAdmin('#3c8dbc');
            $css->setFooterBackground('#f3c412');
            $css->setFooterBackgroundAdmin('#3c8dbc');
            $css->setHeaderLogo('default_logo.png');
            $css->setHeaderLogoAdmin('default_logo.png');
		}

		header('Content-type: text/css');
		print ".application-header {background:" . $css->getHeaderBackground() . "}\n";
		print ".navbar-layout {background:" . $css->getHeaderBackground()  . "}\n";
		print ".dashboard-header {background:" . $css->getHeaderBackground()  . "}\n";
		print ".dashboard-footer {background:" . $css->getHeaderBackground()  . " none repeat scroll 0 0}\n";
		die;
	}
}
