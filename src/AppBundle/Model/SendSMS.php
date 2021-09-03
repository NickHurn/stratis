<?php

namespace AppBundle\Model;

class SendSMS
{
	private $em;
	private $user_id;
	
    private $username = "mdangerfield";
    private $password = "UaAMYbDdPGXdKY";
    private $apiid = "3572761";
    private $url = "https://api.clickatell.com/http/sendmsg";
    private $queryUrl = "https://api.clickatell.com/http/querymsg";
	
	
	public function __construct($user_id, $entityManager)
	{
		$this->em = $entityManager;
		$this->user_id = $user_id;
	}
	

	public function send($from, $to, $message)
    {
		//  If the mobile number starts with +99, send it to our 'dev phone' instead.
		if(substr($to,0,3)=="+99")
		{
			$now = date("d/M H:i:s");
			$msg = "SMS: $now\nTO: $to\nMSG:$message";
			
			$devphone = new \AppBundle\Entity\Devphone();
			$devphone->setUserId($this->user_id);
			$devphone->setMsg($msg);
			$this->em->persist($devphone);
			$this->em->flush();
		}
		else
		{
			$url = $this->url.'?user='.$this->username.'&password='.$this->password.'&api_id='.$this->apiid.'&to='.urlencode($to).'&text='.urlencode($message);
			$result = file_get_contents($url);
		}
	}
}