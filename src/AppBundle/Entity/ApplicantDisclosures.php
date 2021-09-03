<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Address
 *
 * @ORM\Table(name="applicant_disclosures", indexes={@ORM\Index(name="user1_idx", columns={"applicant_id"})},  uniqueConstraints={@ORM\UniqueConstraint(name="code_idx", columns={"code"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ApplicantDisclosuresRepository")
 */
class ApplicantDisclosures
{
    public function __construct() {
        $this->status_date = new \DateTime('now');
    }

	/**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employer_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="employee_id", type="integer", nullable=false)
     */
    private $employeeId;

    /**
     * @var string
     * @ORM\Column(name="code", type="string", length=32, nullable=true)
     */
    private $code;
    
	/**
     * @var integer
     *
     * @ORM\Column(name="applicant_id", type="integer", nullable=false)
     */
    private $applicant_id;

	/**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=32, nullable=true)
     */
    private $job_id;

	/**
     * @var string
     *
     * @ORM\Column(name="applicant_status", type="string", length=32, nullable=true)
     */
    private $applicant_status;

	/**
     * @var string
     *
     * @ORM\Column(name="hireabl_status", type="string", length=32, nullable=true)
     */
    private $hireabl_status;
	
	/**
     * @var int
     *
     * @ORM\Column(name="gbg_status_code", type="integer", nullable=true, options={"default" = 0} )
     */
    private $gbg_status_code;

	/**
     * @var string
     *
     * @ORM\Column(name="gbg_status", type="string", length=32, nullable=true)
     */
    private $gbg_status;

    /**
     * @var string
     *
     * @ORM\Column(name="gbg_outcome", type="string", length=32, nullable=true)
     */
    private $gbg_outcome;

    /**
     * @var string
     *
     * @ORM\Column(name="gbg_disclosure_number", type="string", length=32, nullable=true)
     */
    private $gbg_disclosure_number;

	/**
     * @var \DateTime
     *
     * @ORM\Column(name="status_date", type="datetime", nullable=true )
     */
    private $status_date;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ApplicantDisclosureVerification", mappedBy="application")
     */
    private $verification;

    /**
     * @var string
     * @ORM\Column(name="short_url", type="string", length=32, nullable=true)
     */
    private $shortUrl;

    /**
     * @return int
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * @param int $employeeId
     * @return ApplicantDisclosures
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
        return $this;
    }

    /**
     * @return int
     */
    public function getApplicantId()
    {
        return $this->applicant_id;
    }

    /**
     * @param int $applicant_id
     * @return ApplicantDisclosures
     */
    public function setApplicantId($applicant_id)
    {
        $this->applicant_id = $applicant_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortUrl()
    {
        return $this->shortUrl;
    }

    /**
     * @param string $shortUrl
     * @return ApplicantDisclosures
     */
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVerification()
    {
        return $this->verification;
    }

    /**
     * @param mixed $verification
     * @return ApplicantDisclosures
     */
    public function setVerification($verification)
    {
        $this->verification = $verification;
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
     * @return ApplicantDisclosures
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getEmployerId()
    {
        return $this->employer_id;
    }

    /**
     * @param int $employer_id
     * @return ApplicantDisclosures
     */
    public function setEmployerId($employer_id)
    {
        $this->employer_id = $employer_id;
        return $this;
    }


    /**
     * @return string
     */
    public function getJobId()
    {
        return $this->job_id;
    }

    /**
     * @param string $job_id
     * @return ApplicantDisclosures
     */
    public function setJobId($job_id)
    {
        $this->job_id = $job_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getApplicantStatus()
    {
        return $this->applicant_status;
    }

    /**
     * @param string $applicant_status
     * @return ApplicantDisclosures
     */
    public function setApplicantStatus($applicant_status)
    {
        $this->applicant_status = $applicant_status;
        return $this;
    }

    /**
     * @return string
     */
    public function getHireablStatus()
    {
        return $this->hireabl_status;
    }

    /**
     * @param string $hireabl_status
     * @return ApplicantDisclosures
     */
    public function setHireablStatus($hireabl_status)
    {
        $this->hireabl_status = $hireabl_status;
        return $this;
    }

    /**
     * @return int
     */
    public function getGbgStatusCode()
    {
        return $this->gbg_status_code;
    }

    /**
     * @param int $gbg_status_code
     * @return ApplicantDisclosures
     */
    public function setGbgStatusCode($gbg_status_code)
    {
        $this->gbg_status_code = $gbg_status_code;
        return $this;
    }

	/**
     * @return string
     */
    public function getGbgStatus()
    {
        return $this->gbg_status;
    }

    /**
     * @param string $gbg_status
     * @return ApplicantDisclosures
     */
    public function setGbgStatus($gbg_status)
    {
        $this->gbg_status = $gbg_status;
        return $this;
    }

    /**
     * @return string
     */
    public function getGbgOutcome()
    {
        return $this->gbg_outcome;
    }

    /**
     * @param string $gbg_outcome
     * @return ApplicantDisclosures
     */
    public function setGbgOutcome($gbg_outcome)
    {
        $this->gbg_outcome = $gbg_outcome;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisclosureNumber()
    {
        return $this->gbg_disclosure_number;
    }

    /**
     * @param string $gbg_disclosure_number
     * @return ApplicantDisclosures
     */
    public function setGbgDisclosureNumber($gbg_disclosure_number)
    {
        $this->gbg_disclosure_number = $gbg_disclosure_number;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStatusDate()
    {
        return $this->status_date;
    }

    /**
     * @param \DateTime $status_date
     * @return ApplicantDisclosures
     */
    public function setStatusDate($status_date)
    {
        $this->status_date = $status_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return ApplicantDisclosures
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Return disclosure records which have been submitted to governing body
     * @return ApplicantDisclosures
     */
	public function getGBGSubmittedRecords()
	{
		$ids = array(7,10,11,12,14);
		$criteria = Criteria::create()->where(Criteria::expr()->in("gbg_status_code", $ids));
		return $this->fetchAll()->matching($criteria);
	}
	
	/**
     * Return disclosure records which have NOT been submitted to governing body
     * @return ApplicantDisclosures
     */
	public function getGBGNonSubmittedRecords()
	{
		$ids = array(0,1,2,3,4,5,6,8,9);
		$criteria = Criteria::create()->where(Criteria::expr()->in("gbg_status_code", $ids));
		return $this->fetchAll()->matching($criteria);
	}

}
