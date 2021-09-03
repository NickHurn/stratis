<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * FormJobs
 *
 * @ORM\Table(name="form_jobs")
 * @ORM\Entity
 */
class FormJobs
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
     * @return integer
     */
	public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return FormJobs
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
     * @return FormJobs
     */
	public function setEmployerId($id)
    {
        $this->employerId = $id;
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
     * @return FormJobs
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
     * @return FormJobs
     */
	public function setJobId($id)
    {
        $this->jobId = $id;
        return $this;
    }
	
}
