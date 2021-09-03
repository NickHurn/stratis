<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * FormCompleted
 *
 * @ORM\Entity
 * @ORM\Table(name="form_completed")
 */
class FormCompleted
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
     * @var integer
     *
     * @ORM\Column(name="form_id", type="integer", nullable=false)
     */
    private $formId;

	/**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_started", type="datetime", nullable=true)
     */
    private $dtStarted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_completed", type="datetime", nullable=true)
     */
    private $dtCompleted;

	/**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

	/**
     * @var integer
     *
     * @ORM\Column(name="max_score", type="integer", nullable=true)
     */
    private $maxScore;

	/**
     * @var integer
     *
     * @ORM\Column(name="pass_score", type="integer", nullable=true)
     */
    private $passScore;

	/**
     * @var integer
     *
     * @ORM\Column(name="percentage", type="integer", nullable=true)
     */
    private $percentage;

	/**
     * @var string
     *
     * @ORM\Column(name="user_agent", type="string", length=255, nullable=true)
     */
    private $userAgent;

	/**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=20, nullable=true)
     */
    private $ipAddress;





	/**
     * @return integer
     */
	public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return FormCompleted
     */
	public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


	/**
     * @return integer
     */
	public function getFormId()
    {
        return $this->formId;
    }

    /**
     * @param integer $formId
     * @return FormCompleted
     */
	public function setFormId($formId)
    {
        $this->formId = $formId;
        return $this;
    }


	/**
     * @return integer
     */
	public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param integer $userId
     * @return FormCompleted
     */
	public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getDtStarted()
    {
        return $this->dtStarted;
    }
	
	/**
     * @param \DateTime $dtStarted
     * @return FormCompleted
     */
    public function setDtStarted($dtStarted)
    {
        $this->dtStarted = $dtStarted;
        return $this;
    }

    
    /**
     * @return \DateTime
     */
    public function getDtCompleted()
    {
        return $this->dtCompleted;
    }
	
	/**
     * @param \DateTime $dtCompleted
     * @return FormCompleted
     */
    public function setDtCompleted($dtCompleted)
    {
        $this->dtCompleted = $dtCompleted;
        return $this;
    }
	

	/**
     * @return integer
     */
	public function getScore()
    {
        return $this->score;
    }

	/**
     * @param integer $score
     * @return FormCompleted
     */
	public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }


	/**
     * @return integer
     */
	public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     * @param integer $maxScore
     * @return FormCompleted
     */
	public function setMaxScore($maxScore)
    {
        $this->maxScore = $maxScore;
        return $this;
    }

	
	/**
     * @return integer
     */
	public function getPassScore()
    {
        return $this->passScore;
    }

	/**
     * @param integer $passScore
     * @return FormCompleted
     */
	public function setPassScore($passScore)
    {
        $this->passScore = $passScore;
        return $this;
    }
	
	
	/**
     * @return integer
     */
	public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param integer $percentage
     * @return FormCompleted
     */
	public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }
	
	
	/**
     * @return string
     */
	public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     * @return FormCompleted
     */
	public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
		return $this;
    }
	
	
	/**
     * @return string
     */
	public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return FormCompleted
     */
	public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
		return $this;
    }
	
	
}
