<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use AppBundle\Form\ForgotPassword;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class SecurityController extends Controller
{
	/**
     * @Route("/newpassword", name="home_change_password")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setPasswordAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
		if(empty($user)) 
		{
			$reset = $request->query->get('reset');
			if(is_null($reset)){
                return $this->redirect('/');
            }
			$user = $em->getRepository('AppBundle:Users')->findOneBy(['reset'=>$reset]);
		}
		if(empty($user)) return $this->redirect('/');

        $newPassword = $this->createForm(\AppBundle\Form\NewPassword::class);
		$newPassword->handleRequest($request);

        if($newPassword->isSubmitted() && $newPassword->isValid())
        {
            $data = $newPassword->getData();
            $encoder = $this->get('security.password_encoder');
            $user->setPassword($data['password'], $encoder);
            $user->setTempPassword(0);
            $user->setReset('');

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                'Your password has been updated and you now have full access to the site.'
            );

            return $this->redirect('/');
        }

        return $this->render('@App/security/index.html.twig', [
            'name' => $user->getName(),
            'form' => $newPassword->createView()
        ]);
    }
	
	
	/**
     * @Route("/forgotpassword", name="forgotten_password")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function forgottenPasswordAction(Request $request)
    {
        $forgotPassword = $this->createForm(ForgotPassword::class);
        $forgotPassword->handleRequest($request);

        if($forgotPassword->isSubmitted() && $forgotPassword->isValid())
        {
            $data = $forgotPassword->getData();
			$em = $this->getDoctrine()->getManager();
			$user = $em->getRepository('AppBundle:Users')->findOneBy(['emailaddress' => $data['emailaddress']]);
			if($user)
			{
				$reset = substr(md5(time()),0,10);
				$user->setReset($reset);
				$em->persist($user);
				$em->flush();	
				// Send code via email
				$emp = $em->getRepository('AppBundle:CssSchemes')->getEmployerFromDomain();
				if($emp and $user)
				{
					$se = new \AppBundle\Model\SendEmail($this->get('twig'), $this->get('mailer'), $this->getDoctrine()->getManager());
					$se->send(
						$emp->getEmailFrom(), 
						$user->getEmailaddress(), 
						null, 
						"Reset Password",
						"resetpassword", 
						array(
							'reset' => $reset,
							'company' => $emp->getCompanyName(),
							'domain' => $emp->getDomain(),
						)
					);
				}
			}
			
			//$this->login->sendForgottenPasswordEmail($_POST['email']);
			return $this->render('@App/security/resetPasswordSent.html.twig');
		}
        return $this->render('@App/security/forgottenPassword.html.twig', [
			'form' => $forgotPassword->createView(),
		]);
    }

}


