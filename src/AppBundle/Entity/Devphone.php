<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Devphone
 *
 * @ORM\Table(name="devphone")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DevphoneRepository")
 */
class Devphone
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="user_id", type="string", length=60, nullable=false)
     */
    private $userId;


	/**
     * @var string
     * @ORM\Column(name="msg", type="string", length=2185, nullable=false)
     */
    private $msg;

	/**
     * @var string
     * @ORM\Column(name="rand", type="string", length=50, nullable=true)
     */
    private $rand;


	
    /**
     * Set id
     * @param integer $id
     * @return Devphone
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

	
	/**
     * Set user_id
     * @param string $userId
     * @return Devphone
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get user_id
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

	/**
     * Set msg
     * @param string $msg
     * @return Devphone
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
        return $this;
    }

    /**
     * Get msg
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }
	
	/**
     * Set rand
     * @param string $rand
     * @return Devphone
     */
    public function setRand($rand)
    {
        $this->rand = $rand;
        return $this;
    }

    /**
     * Get rand
     * @return string
     */
    public function getRand()
    {
        return $this->rand;
    }
}
