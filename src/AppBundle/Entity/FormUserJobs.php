<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * FormUserJobs
 *
 * @ORM\Table(name="form_user_jobs")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FormUserJobsRepository")
 */
class FormUserJobs
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
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

	/**
     * @var integer
     *
     * @ORM\Column(name="form_id", type="integer", nullable=true)
     */
    private $formId;

	/**
     * @var integer
     *
     * @ORM\Column(name="job_id", type="integer", nullable=true)
     */
    private $jobId;

	/**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=15, nullable=false)
     */
    private $status;


	
	/**
     * @return integer
     */
	public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return FormUserJobs
     */
	public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

	
	/**
     * @return integer
     */
	public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * @param integer $id
     * @return FormUserJobs
     */
	public function setEmployerId($id)
    {
        $this->employerId = $id;
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
     * @param integer $id
     * @return FormUserJobs
     */
	public function setUserId($id)
    {
        $this->userId = $id;
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
     * @param integer $id
     * @return FormUserJobs
     */
	public function setFormId($id)
    {
        $this->formId = $id;
        return $this;
    }
	
	
	/**
     * @return integer
     */
	public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param integer $id
     * @return FormUserJobs
     */
	public function setJobId($id)
    {
        $this->jobId = $id;
        return $this;
    }


	/**
     * @return string
     */
	public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return FormUserJobs
     */
	public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
	
}
