<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;
use AppBundle\Entity\PoolQuestions;
use AppBundle\Entity\FormQuestions;


class PostcodeController extends Controller {

	/**
	 * @Route("/postcode/lookup", name="postcode_lookup")
	 */
	public function postcodeAction(Request $request)
    {
		$postcode = $request->get('pcode');
		$house = $request->get('house');

		$em = $this->getDoctrine()->getManager();
        $postcodeLookUpKey = $this->getParameter('postcode_lookup_key');
        $postcodeLookUpURL = $this->getParameter('postcode_lookup_url');


        $data = $em->getRepository('AppBundle:PostcodeCache')->getData($postcode, $house, $postcodeLookUpKey,$postcodeLookUpURL);

        return $this->json(['address' => $data]);

    }



    /**
	 * @Route("/postcode/test", name="postcode_test")
	 */
	public function postcodetestAction(Request $request)
    {
        return $this->render('@App/postcode/test.html.twig', [
        ]);
    }

    
}

