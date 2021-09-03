<?php
/**
 * Created by PhpStorm.
 * User: scottbaverstock
 * Date: 28/07/2017
 * Time: 14:21
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="applicant_share")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ApplicantShareRepository")
 */
class ApplicantShare
{

    public function __construct()
    {
        $this->setCreatedOn(new \DateTime('now'));
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(name="applicant_id", type="integer", nullable=false)
     */
    private $applicantId;



    /**
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employerId;

    /**
     * @ORM\Column(name="created_on", type="date", nullable=false)
     */
    private $createdOn;

    /**
     * @ORM\Column(name="unique_id", type="string", nullable=false)
     */
    private $uniqueId;

    /**
     * @ORM\Column(name="job_id", type="string", nullable=false)
     */
    private $jobId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ApplicantShare
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return ApplicantShare
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApplicantId()
    {
        return $this->applicantId;
    }

    /**
     * @param mixed $applicantId
     * @return ApplicantShare
     */
    public function setApplicantId($applicantId)
    {
        $this->applicantId = $applicantId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * @param mixed $employerId
     * @return ApplicantShare
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param mixed $createdOn
     * @return ApplicantShare
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @param mixed $uniqueId
     * @return ApplicantShare
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param mixed $jobId
     * @return ApplicantShare
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
        return $this;
    }








}