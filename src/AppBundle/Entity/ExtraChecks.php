<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExtraChecks
 *
 * @ORM\Table(name="extrachecks")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ExtraChecksRepository")
 */
class ExtraChecks
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
     * @ORM\Column(name="employer_id", type="integer", nullable=true)
     */
    private $employerId;

	/**
     * @var string
     *
     * @ORM\Column(name="job_code", type="string", length=64, nullable=true)
     */
    private $jobCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="check_type", type="string", length=20, nullable=true)
     */
    private $checkType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_requested", type="datetime", nullable=false)
     */
    private $dateRequested;

	/**
     * @var \DateTime
     *
     * @ORM\Column(name="date_completed", type="datetime", nullable=true)
     */
    private $dateCompleted;
	
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=30, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="string", length=20, nullable=true)
     */
    private $result;

	
    /**
     * Set Id
     *
     * @param integer $id
     *
     * @return ExtraChecks
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

	
    /**
     * Set EmployerId
     *
     * @param integer $employer_id
     *
     * @return ExtraChecks
     */
    public function setEmployerId($id)
    {
        $this->employerId = $id;
        return $this;
    }

    /**
     * Get EmployerId
     *
     * @return integer
     */
    public function getEmployerId()
    {
        return $this->EmployerId;
    }


	/**
     * Set jobCode
     *
     * @param string $jobCode
     *
     * @return ExtraChecks
     */
    public function setJobCode($jobCode)
    {
        $this->jobCode = $jobCode;
        return $this;
    }

    /**
     * Get jobCode
     *
     * @return string
     */
    public function getJobCode()
    {
        return $this->jobCode;
    }


	/**
     * Set userId
     *
     * @param integer $userId
     *
     * @return ExtraChecks
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }


	/**
     * Set checkType
     *
     * @param string $checkType
     *
     * @return ExtraChecks
     */
    public function setCheckType($s)
    {
        $this->checkType = $s;
        return $this;
    }

    /**
     * Get checkType
     *
     * @return string
     */
    public function getCheckType()
    {
        return $this->checkType;
    }


	/**
     * Set dateRequested
     *
     * @param \DateTime $dateRequested
     *
     * @return ExtraChecks
     */
    public function setDateRequested($d)
    {
        $this->dateRequested = $d;
        return $this;
    }

    /**
     * Get dateRequested
     *
     * @return \DateTime
     */
    public function getDateRequested()
    {
        return $this->dateRequested;
    }


	/**
     * Set dateCompleted
     *
     * @param \DateTime $dateCompleted
     *
     * @return ExtraChecks
     */
    public function setDateCompleted($d)
    {
        $this->dateCompleted = $d;
        return $this;
    }

    /**
     * Get dateCompleted
     *
     * @return \DateTime
     */
    public function getDateCompleted()
    {
        return $this->dateCompleted;
    }


	/**
     * Set status
     *
     * @param string $status
     *
     * @return ExtraChecks
     */
    public function setStatus($s)
    {
        $this->status = $s;
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }


	/**
     * Set result
     *
     * @param string $result
     *
     * @return ExtraChecks
     */
    public function setResult($s)
    {
        $this->result = $s;
        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }
	
}
