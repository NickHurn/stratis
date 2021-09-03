<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interviews
 *
 * @ORM\Table(name="interviews")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\InterviewsRepository")
 */
class Interviews
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=45, nullable=false)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="employer_user_id", type="integer", nullable=false)
     */
    private $employerUserId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="interview_date", type="datetime", nullable=false)
     */
    private $interviewDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="sms", type="integer", nullable=false, options={"default" = 0})
     */
    private $sms;

    /**
     * @var integer
     *
     * @ORM\Column(name="email", type="integer", nullable=false, options={"default" = 0})
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="accepted", type="integer", nullable=true)
     */
    private $accepted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accepted_on", type="datetime", nullable=true)
     */
    private $acceptedOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="rejected", type="integer", nullable=true)
     */
    private $rejected;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rejected_on", type="datetime", nullable=true)
     */
    private $rejectedOn;

    /**
     * @var string
     *
     * @ORM\Column(name="reject_reason", type="string", length=255, nullable=true)
     */
    private $rejectReason;

    /**
     * @var string
     *
     * @ORM\Column(name="rejected_by", type="string", length=255, nullable=true)
     */
    private $rejectedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="details_url", type="string", length=30, nullable=true)
     */
    private $detailsUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="unique_ref", type="string", length=32, nullable=true)
     */
    private $uniqueRef;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="text", length=65535, nullable=true)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="ics", type="string", length=255, nullable=true)
     */
    private $ics;

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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Interviews
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
     * Set jobId
     *
     * @param string $jobId
     *
     * @return Interviews
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
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return Interviews
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;

        return $this;
    }

    /**
     * Get employerId
     *
     * @return integer
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * Set employerUserId
     *
     * @param integer $employerUserId
     *
     * @return Interviews
     */
    public function setEmployerUserId($employerUserId)
    {
        $this->employerUserId = $employerUserId;

        return $this;
    }

    /**
     * Get employerUserId
     *
     * @return integer
     */
    public function getEmployerUserId()
    {
        return $this->employerUserId;
    }

    /**
     * Set interviewDate
     *
     * @param \DateTime $interviewDate
     *
     * @return Interviews
     */
    public function setInterviewDate($interviewDate)
    {
        $this->interviewDate = $interviewDate;

        return $this;
    }

    /**
     * Get interviewDate
     *
     * @return \DateTime
     */
    public function getInterviewDate()
    {
        return $this->interviewDate;
    }

    /**
     * Set sms
     *
     * @param integer $sms
     *
     * @return Interviews
     */
    public function setSms($sms)
    {
        $this->sms = $sms;

        return $this;
    }

    /**
     * Get sms
     *
     * @return integer
     */
    public function getSms()
    {
        return $this->sms;
    }

    /**
     * Set email
     *
     * @param integer $email
     *
     * @return Interviews
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return integer
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Interviews
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
     * Set accepted
     *
     * @param integer $accepted
     *
     * @return Interviews
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return integer
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set acceptedOn
     *
     * @param \DateTime $acceptedOn
     *
     * @return Interviews
     */
    public function setAcceptedOn($acceptedOn)
    {
        $this->acceptedOn = $acceptedOn;

        return $this;
    }

    /**
     * Get acceptedOn
     *
     * @return \DateTime
     */
    public function getAcceptedOn()
    {
        return $this->acceptedOn;
    }

    /**
     * Set rejected
     *
     * @param integer $rejected
     *
     * @return Interviews
     */
    public function setRejected($rejected)
    {
        $this->rejected = $rejected;

        return $this;
    }

    /**
     * Get rejected
     *
     * @return integer
     */
    public function getRejected()
    {
        return $this->rejected;
    }

    /**
     * Set rejectedOn
     *
     * @param \DateTime $rejectedOn
     *
     * @return Interviews
     */
    public function setRejectedOn($rejectedOn)
    {
        $this->rejectedOn = $rejectedOn;

        return $this;
    }

    /**
     * Get rejectedOn
     *
     * @return \DateTime
     */
    public function getRejectedOn()
    {
        return $this->rejectedOn;
    }

    /**
     * Set rejectReason
     *
     * @param string $rejectReason
     *
     * @return Interviews
     */
    public function setRejectReason($rejectReason)
    {
        $this->rejectReason = $rejectReason;

        return $this;
    }

    /**
     * Get rejectReason
     *
     * @return string
     */
    public function getRejectReason()
    {
        return $this->rejectReason;
    }

    /**
     * Set rejectedBy
     *
     * @param string $rejectedBy
     *
     * @return Interviews
     */
    public function setRejectedBy($rejectedBy)
    {
        $this->rejectedBy = $rejectedBy;

        return $this;
    }

    /**
     * Get rejectedBy
     *
     * @return string
     */
    public function getRejectedBy()
    {
        return $this->rejectedBy;
    }

    /**
     * Set detailsUrl
     *
     * @param string $detailsUrl
     *
     * @return Interviews
     */
    public function setDetailsUrl($detailsUrl)
    {
        $this->detailsUrl = $detailsUrl;

        return $this;
    }

    /**
     * Get detailsUrl
     *
     * @return string
     */
    public function getDetailsUrl()
    {
        return $this->detailsUrl;
    }

    /**
     * Set uniqueRef
     *
     * @param string $uniqueRef
     *
     * @return Interviews
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
     * Set location
     *
     * @param string $location
     *
     * @return Interviews
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set ics
     *
     * @param string $ics
     *
     * @return Interviews
     */
    public function setIcs($ics)
    {
        $this->ics = $ics;

        return $this;
    }

    /**
     * Get ics
     *
     * @return string
     */
    public function getIcs()
    {
        return $this->ics;
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

    public function getStatus()
    {
        if($this->getAccepted() == 1){
            return 'Accepted';
        }
        if($this->getRejected() == 1){
            return 'Rejected';
        }
       return 'Requested';

    }



}
