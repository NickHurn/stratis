<?php

namespace AppBundle\Model;

class SendEmail
{
	private $twig;
	private $mailer;
	private $em;
	
	public function __construct($twig, $mailer, $entityManager)
	{
		$this->twig = $twig;
		$this->mailer = $mailer;
		$this->em = $entityManager;
	}
	
	
    public function send($from, $to, $user_id, $subject, $template, $variables, $attachment=null)
    {
		//  Get company name and default 'from' email address
		$css = $this->em->getRepository('AppBundle:CssSchemes')->getEmployerFromDomain();
		$companyname = $css->getCompanyName();
		// If the 'from' address is not provided, set it to the domain's client default
		if(empty($from)) $from = $css->getEmailFrom();
		
		//  If the email address ends in .dev, then send the message to our 'dev phone'.
		if(substr($to,-4)==".dev")
		{
			$now = date("d/M H:i:s");
			$body = $this->twig->render("AppBundle:Emails:{$template}.text.twig", $variables);
			$msg = "EMAIL: $now\nTO: $to\nSUBJECT: $subject\nMSG:$body";

			$devphone = new \AppBundle\Entity\Devphone();
			if(empty($user_id))	$devphone->setUserId(session_id());
			else				$devphone->setUserId($user_id);
			$devphone->setMsg($msg);
			$this->em->persist($devphone);
			$this->em->flush();
			return 1;
		}
		else
		{
			$message = \Swift_Message::newInstance();
			$message->setSubject($subject)
				->setFrom($from)
				->setTo($to)
				->setBody($this->twig->render("AppBundle:Emails:{$template}.html.twig", $variables), 'text/html')
				->addPart($this->twig->render("AppBundle:Emails:{$template}.text.twig", $variables), 'text/plain');
			if(!empty($attachment)) $message->attach($attachment);
			$resp = $this->mailer->send($message);
			return $resp;
		}
	}
}