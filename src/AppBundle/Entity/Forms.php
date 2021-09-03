<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Forms
 *
 * @ORM\Table(name="forms")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FormsRepository")
 */
class Forms
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
     * @var string
     *
     * @ORM\Column(name="form_name", type="string", length=100, nullable=false)
     */
    private $formName;


	/**
     * @var string
     *
     * @ORM\Column(name="form_type", type="string", length=20, nullable=false)
     */
    private $formType;

	
	/**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=true)
     */
    private $employerId;

	
	/**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=32, nullable=true)
     */
    private $jobId;

	
	/**
     * @var integer
     *
     * @ORM\Column(name="num_questions", type="integer", nullable=false, options={"default" = 0} )
     */
    private $numQuestions;


	/**
     * @var integer
     *
     * @ORM\Column(name="time_limit", type="integer", nullable=false, options={"default" = 0} )
     */
    private $timeLimit;

	
	/**
     * @var integer
     *
     * @ORM\Column(name="pass_score", type="integer", nullable=false, options={"default" = 0} )
     */
    private $passScore;

	
	
	/**
     * @return integer
     */
	public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return Forms
     */
	public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


	/**
     * @return string
     */
    public function getFormName()
    {
        return $this->formName;
    }

    /**
     * @param string $formName
     * @return Forms
     */
    public function setFormName($formName)
    {
        $this->formName = $formName;
        return $this;
    }

	
	
    /**
     * @return string
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * @param string $formType
     * @return Forms
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
        return $this;
    }


	/**
     * @return int
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * @param int $employerId
     * @return Forms
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;
        return $this;
    }

	
	/**
     * @return int
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param int $jobId
     * @return Forms
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
        return $this;
    }
	
	
	/**
     * @return int
     */
    public function getNumQuestions()
    {
        return $this->numQuestions;
    }

    /**
     * @param int $numQuestions
     * @return Forms
     */
    public function setNumQuestions($numQuestions)
    {
        $this->numQuestions = $numQuestions;
        return $this;
    }

	
	/**
     * @return int
     */
    public function getTimeLimit()
    {
        return $this->timeLimit;
    }

    /**
     * @param int $timeLimit
     * @return Forms
     */
    public function setTimeLimit($timeLimit)
    {
        $this->timeLimit = $timeLimit;
        return $this;
    }

	
	/**
     * @return int
     */
    public function getPassScore()
    {
        return $this->passScore;
    }

    /**
     * @param int $passScore
     * @return Forms
     */
    public function setPassScore($passScore)
    {
        $this->passScore = $passScore;
        return $this;
    }

}
