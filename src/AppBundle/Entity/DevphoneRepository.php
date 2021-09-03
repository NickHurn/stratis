<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DevphoneRepository extends EntityRepository
{
	public function sendEmail($user_id, $msg)
	{
		$msg = "EMAIL: " . date("j/n H:i:s") . "<br/>" . $msg;
		$this->send($user_id, $msg);
	}

	public function sendSMS($user_id, $msg)
	{
		$msg = "SMS: " . date("j/n H:i:s") . "<br/>" . $msg;
		$this->send($user_id, $msg);
	}

	public function send($user_id, $msg)
	{
		$em = $this->getEntityManager();
		$ph = new Devphone();
		$ph->setUserId($user_id); // could be user_id or session_id
		$ph->setMsg($msg);
		$em->persist($ph);
		$em->flush();
	}
	
	public function clearmsgs($user_id = null)
	{
		$em = $this->getEntityManager();
		$sess = session_id();
		
		$q = $em->createQuery("delete from AppBundle:Devphone ph where ph.userId='{$user_id}' or ph.userId='{$sess}'");
		$q->execute();
	}

	public function check($user_id)
	{
		$em = $this->getEntityManager();
		$msgs = $em->getRepository('AppBundle:Devphone')->findBy(['userId'=>array($user_id,session_id())], array('id'=>'ASC'));

		$msgoutput = '';
		if(!empty($msgs))
		{
			foreach($msgs as $msg)
			{
				$msgoutput .= $msg->getMsg() . "<br/><br/>";
			}
		}
		$this->clearmsgs($user_id);
		return $msgoutput;
	}
}