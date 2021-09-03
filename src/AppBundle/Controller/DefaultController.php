<?php

namespace AppBundle\Controller;

use AppBundle\Entity\WebHookTests;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		// Verify the domain has been added to CssSchemes before allowing use.
		$em = $this->getDoctrine()->getManager();
		//$d = $em->getRepository('AppBundle:CssSchemes')->getEmployerIdFromDomain();
//		if(empty($d)) {
//			die("This domain has not been configured in Client Whitelabelling");
//		}
		
		// If not logged on, re-direct to /login
		// If admin, re-direct to /admin
		// If user, re-direct to /candidate

		$user = $this->getUser();
		if($user==null) return $this->redirect('/login');
		if($user->getEmployerId()==0) return $this->redirect('/candidate/home');
		return $this->redirect('/admin');
    }


    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
		// Verify the domain has been added to CssSchemes before allowing use.
		$em = $this->getDoctrine()->getManager();
		$d = $em->getRepository('AppBundle:CssSchemes')->getEmployerIdFromDomain();
		if(empty($d)) {
			//die("This domain has not been configured in Client Whitelabelling");
		}

		$whitelabel = $this->get('app.whitelabel');
		$companyName = $whitelabel->getWhiteLabel()->getCompanyName();
		$domain = $whitelabel->getWhiteLabel()->getDomain();

		//  This is a dirty hack to get the login error message, as the code
		//  seems to be non-standard for any SF version.
		$error = '';
		if(!empty($_SESSION['_sf2_attributes']['_security.last_error'])) {
			$error = $_SESSION['_sf2_attributes']['_security.last_error']->getMessage();
			unset($_SESSION['_sf2_attributes']['_security.last_error']);
		}

		return $this->render('@App/default/login.html.twig', [
			'companyName' => $companyName,
			'domain' => $domain,
			'from' => 'DefaultController',
			'error' => $error,
        ]);
	}

	
	/**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
		$user = $this->getUser();
		$user_id = $user->getId();
		die("A");
		ob_clean();
		// clear token column in users table
		setcookie("UD2token","",86400,"/",".desktop.local");
		setcookie("UD2token","",86400,"/",".voosoftware.com");
		session_start();
		session_destroy();
		return $this->redirect('/login');
	}
	
	
	
    /**
     * @Route("/webhooktest", name="webhooktest")
     * @param Request $request
     */
    public function webHookTestAction(Request $request)
    {
        $json = $request->getContent();

        $em = $this->getDoctrine()->getManager();

        $webHookTest = new WebHookTests();
        $webHookTest->setData($json);

        $em->persist($webHookTest);
        $em->flush();

        return $this->json(['status' => 'ok']);
    }

    /**
     * @Route("/search/applicants/reindex ")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexSearchAction ()
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();


        $search = $this->get('app.search');
        $message = $search->reIndexApplicants($em);

        return  $this->json($message);
    }

    /**
     * @Route("/search/applicants ")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function applicantSearchAction ()
    {
        $em = $this->getDoctrine()->getManager();
        $search = $this->get('app.search');
        $result = $search->search('matt', 3);

        return  new Response('<pre>'. print_r ($result,true).' </pre>');
    }

    /**
     * @Route("/search/applicants/index/{applicantId}/{employerId}", name="add_applicant_search_index")
     *
     */
    public function indexAddAction(Request $request,$applicantId, $employerId)
    {
        $em = $this->getDoctrine()->getManager();
        $search = $this->get('app.search');
        $applicant = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$applicantId]);
        $search->indexApplicant($applicant, $employerId);
        return  new Response('ok');
    }

    /**
     * @Route("/id/add", name="checkabl_id_add")
     */
    public function idAddAction()
    {
        return $this->render('@App/default/id.add.html.twig', [
            'openpage' => 'checkabl_id_add'
        ]);
    }


    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacyAction()
    {
		$whitelabel = $this->get('app.whitelabel');
		$companyName = $whitelabel->getWhiteLabel()->getCompanyName();
		$domain = $whitelabel->getWhiteLabel()->getDomain();

        return $this->render('@App/default/privacy.html.twig', [
			'companyName' => $companyName,
			'domain' => $domain,
		]);
    }

    /**
     * @Route("/cookie/response", name="cookie_response")
     *
     */
    public function cookieResponseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cookieResponse = $request->query->get('accept');
        //get cookie policy version
        // Set cookie value
        $response = new Response();
        $cookie = new Cookie('cookies_policy', 'accepted', time() + 31556926);
        $response->headers->setCookie($cookie);
        $response->send();


        return $this->json(array(
            'status' => 'ok',
        ));
    }
}
