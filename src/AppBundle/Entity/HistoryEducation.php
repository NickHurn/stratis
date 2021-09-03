<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoryEducation
 *
 * @ORM\Table(name="history_education")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\HistoryEducationRepository")
 */
class HistoryEducation
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
     * @var int
     *
     * @ORM\Column(name="seq", type="integer", nullable=false)
     */
    private $seq;

    /**
     * @var string
     *
     * @ORM\Column(name="establishment", type="string", length=255, nullable=true)
     */
    private $establishment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="datetime", nullable=true)
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="datetime", nullable=true)
     */
    private $enddate;

    /**
     * @var string
     *
     * @ORM\Column(name="qualification", type="string", length=255, nullable=true)
     */
    private $qualification;

    /**
     * @var string
     *
     * @ORM\Column(name="course_title", type="string", length=255, nullable=true)
     */
    private $courseTitle;

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
     * Set userId
     *
     * @param integer $userId
     *
     * @return HistoryEducation
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
     * @return HistoryEducation
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
     * Set establishment
     *
     * @param string $establishment
     *
     * @return HistoryEducation
     */
    public function setEstablishment($establishment)
    {
        $this->establishment = $establishment;

        return $this;
    }

    /**
     * Get establishment
     *
     * @return string
     */
    public function getEstablishment()
    {
        return $this->establishment;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return HistoryEducation
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     *
     * @return HistoryEducation
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set qualification
     *
     * @param string $qualification
     *
     * @return HistoryEducation
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return HistoryEducation
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

    /**
     * @return string
     */
    public function getCourseTitle()
    {
        return $this->courseTitle;
    }

    /**
     * @param string $courseTitle
     * @return HistoryEducation
     */
    public function setCourseTitle($courseTitle)
    {
        $this->courseTitle = $courseTitle;
        return $this;
    }

    /**
     * Set seq
     *
     * @param integer $seq
     *
     * @return HistoryEmployment
     */
    public function setSeq($seq)
    {
        $this->seq = $seq;

        return $this;
    }

    /**
     * Get seq
     *
     * @return integer
     */
    public function getSeq()
    {
        return $this->seq;
    }

}
