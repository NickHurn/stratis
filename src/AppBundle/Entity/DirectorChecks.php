<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="director_checks")
 * @ORM\Entity
 */
class DirectorChecks
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
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="job_code", type="string", nullable=true)
     */
    private $jobCode;

	/**
     * @var string
     *
     * @ORM\Column(name="companies", type="text", length=65535, nullable=true)
     */
    private $companies;

	
    /**
     * Set Id
     *
     * @param integer $id
     *
     * @return DirectorChecks
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
     * Set jobCode
     *
     * @param string $jobCode
     *
     * @return DirectorChecks
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
     * @return DirectorChecks
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
     * Set companies
     *
     * @param string $companies
     *
     * @return DirectorChecks
     */
    public function setCompanies($s)
    {
        $this->companies = $s;
        return $this;
    }

    /**
     * Get companies
     *
     * @return string
     */
    public function getCompanies()
    {
        return $this->companies;
    }
}
