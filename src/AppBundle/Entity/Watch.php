<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Watch
 *
 * @ORM\Table(name="watch")
 * @ORM\Entity
 */
class Watch
{

    /**
     * Many Watches have One job.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Jobs")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
    private $job;

    /**
     * Many Watches have One user.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumn(name="applicant_id", referencedColumnName="id")
     */
    private $applicant;

    /**
     * Many Watches have One Employer.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employers")
     * @ORM\JoinColumn(name="employer_id", referencedColumnName="id")
     */
    private $employer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
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
     * @return Jobs
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param mixed $job
     * @return Watch
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * @return Users
     */
    public function getApplicant()
    {
        return $this->applicant;
    }

    /**
     * @param mixed $applicant
     * @return Watch
     */
    public function setApplicant($applicant)
    {
        $this->applicant = $applicant;
        return $this;
    }

    /**
     * @return Employers
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @param mixed $employer
     * @return Watch
     */
    public function setEmployer($employer)
    {
        $this->employer = $employer;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     * @return Watch
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Watch
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    public function toArray(){
        return [
            'id' => $this->getId(),
            'applicant' => $this->getApplicant()->getName(),
            'employer' => $this->getEmployer()->getCompany(),
            'job' => $this->getJob()->getTitle(),
        ];
    }


}
