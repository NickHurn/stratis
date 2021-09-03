<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReferenceRequest
 *
 * @ORM\Table(name="reference_request")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ReferenceRequestsRepository")
 */
class ReferenceRequest
{
    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=36, nullable=false)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="applicant_id", type="integer", nullable=false)
     */
    private $applicantId;

    /**
     * @var string
     *
     * @ORM\Column(name="applicant_message", type="text", length=65535, nullable=false)
     */
    private $applicantMessage;

    /**
     * @var integer
     *
     * @ORM\Column(name="no_of_references", type="integer", nullable=false)
     */
    private $noOfReferences;

    /**
     * @var string
     *
     * @ORM\Column(name="return_emails", type="text", length=65535, nullable=false)
     */
    private $returnEmails;

    /**
     * @var string
     *
     * @ORM\Column(name="unique_ref", type="string", length=36, nullable=false)
     */
    private $uniqueRef;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct() {
        $this->createdOn = new \DateTime('now');
    }

    /**
     * Set jobId
     *
     * @param string $jobId
     *
     * @return ReferenceRequest
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Get jobId
     *
     * @return string
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Set applicantId
     *
     * @param integer $applicantId
     *
     * @return ReferenceRequest
     */
    public function setApplicantId($applicantId)
    {
        $this->applicantId = $applicantId;

        return $this;
    }

    /**
     * Get applicantId
     *
     * @return integer
     */
    public function getApplicantId()
    {
        return $this->applicantId;
    }

    /**
     * Set applicantMessage
     *
     * @param string $applicantMessage
     *
     * @return ReferenceRequest
     */
    public function setApplicantMessage($applicantMessage)
    {
        $this->applicantMessage = $applicantMessage;

        return $this;
    }

    /**
     * Get applicantMessage
     *
     * @return string
     */
    public function getApplicantMessage()
    {
        return $this->applicantMessage;
    }

    /**
     * Set noOfReferences
     *
     * @param integer $noOfReferences
     *
     * @return ReferenceRequest
     */
    public function setNoOfReferences($noOfReferences)
    {
        $this->noOfReferences = $noOfReferences;

        return $this;
    }

    /**
     * Get noOfReferences
     *
     * @return integer
     */
    public function getNoOfReferences()
    {
        return $this->noOfReferences;
    }

    /**
     * Set returnEmails
     *
     * @param string $returnEmails
     *
     * @return ReferenceRequest
     */
    public function setReturnEmails($returnEmails)
    {
        $this->returnEmails = $returnEmails;

        return $this;
    }

    /**
     * Get returnEmails
     *
     * @return string
     */
    public function getReturnEmails()
    {
        return $this->returnEmails;
    }

    /**
     * Set uniqueRef
     *
     * @param string $uniqueRef
     *
     * @return ReferenceRequest
     */
    public function setUniqueRef($uniqueRef)
    {
        $this->uniqueRef = $uniqueRef;

        return $this;
    }

    /**
     * Get uniqueRef
     *
     * @return string
     */
    public function getUniqueRef()
    {
        return $this->uniqueRef;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return ReferenceRequest
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
