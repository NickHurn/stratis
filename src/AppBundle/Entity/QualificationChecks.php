<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Qualification
 *
 * @ORM\Table(name="qualification_checks")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\QualificationChecksRepository")
 */
class QualificationChecks
{
    public function __construct()
    {
        $this->setCreatedOn(new \DateTime('now'));
    }
    /**
     * @var string
     * @ORM\Column(name="institute_id", type="string", length=255, nullable=true)
     */
    private $instituteId;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var Jobs
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Jobs")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
    private $jobId;

    /**
     * @var string
     *
     * @ORM\Column(name="employer_id", type="string", length=45, nullable=false)
     */
    private $employer_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", nullable=true)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="submitted_on", type="datetime", nullable=true)
     */
    private $submittedOn;

    /**
     * @var string
     *
     * @ORM\Column(name="short_url", type="string", length=150, nullable=false)
     */
    private $shortUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=45)
     */
    private $token;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;
    /**
     * @var string
     * @ORM\Column(name="middle_name", type="string", length=255, nullable=true)
     */
    private $middleName;
    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;
    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;
    /**
     * @var \DateTime
     * @ORM\Column(name="dob", type="datetime", nullable=true)
     */
    private $dob;
    /**
     * @var string
     * @ORM\Column(name="gender", type="string", length=255, nullable=true)
     */
    private $gender;
    /**
     * @var string
     * @ORM\Column(name="student_id", type="string", length=255, nullable=true)
     */
    private $studentId;
    /**
     * @var string
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;
    /**
     * @var string
     * @ORM\Column(name="membership", type="string", length=255, nullable=true)
     */
    private $membership;
    /**
     * @var string
     * @ORM\Column(name="course_title", type="string", length=255, nullable=true)
     */
    private $courseTitle;
    /**
     * @var string
     * @ORM\Column(name="award", type="string", length=255, nullable=true)
     */
    private $award;
    /**
     * @var string
     * @ORM\Column(name="grade", type="string", length=255, nullable=true)
     */
    private $grade;
    /**
     * @var string
     * @ORM\Column(name="enrolment", type="integer", nullable=true)
     */
    private $enrolment;
    /**
     * @var integer
     * @ORM\Column(name="graduated", type="integer", nullable=true)
     */
    private $graduated;

    /**
     * @var integer
     * @ORM\Column(name="verification_id", type="integer", nullable=true)
     */
    private $verificationId;

    /**
     * @var string
     * @ORM\Column(name="verification_status", type="string", length=255, nullable=true)
     */
    private $verificationStatus;

    /**
     * @var string
     * @ORM\Column(name="verification_response", type="text", nullable=true)
     */
    private $verificationResponse;


    /**
     * @var $job Jobs
     */
    private $job;

    /**
     * @var $candidate Users
     */
    private $candidate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return QualificationChecks
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
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
     * @return QualificationChecks
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy
     * @return QualificationChecks
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSubmittedOn()
    {
        return $this->submittedOn;
    }

    /**
     * @param \DateTime $submittedOn
     * @return QualificationChecks
     */
    public function setSubmittedOn($submittedOn)
    {
        $this->submittedOn = $submittedOn;
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
     * @return QualificationChecks
     */
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return QualificationChecks
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return Jobs
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param Jobs $jobId
     * @return QualificationChecks
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
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
     * @return QualificationChecks
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return QualificationChecks
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     * @return QualificationChecks
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return QualificationChecks
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param \DateTime $dob
     * @return QualificationChecks
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return QualificationChecks
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * @param string $studentId
     * @return QualificationChecks
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return QualificationChecks
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
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
     * @return QualificationChecks
     */
    public function setCourseTitle($courseTitle)
    {
        $this->courseTitle = $courseTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getAward()
    {
        return $this->award;
    }

    /**
     * @param string $award
     * @return QualificationChecks
     */
    public function setAward($award)
    {
        $this->award = $award;
        return $this;
    }

    /**
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param string $grade
     * @return QualificationChecks
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnrolment()
    {
        return $this->enrolment;
    }

    /**
     * @param string $enrolment
     * @return QualificationChecks
     */
    public function setEnrolment($enrolment)
    {
        $this->enrolment = $enrolment;
        return $this;
    }

    /**
     * @return int
     */
    public function getGraduated()
    {
        return $this->graduated;
    }

    /**
     * @param int $graduated
     * @return QualificationChecks
     */
    public function setGraduated($graduated)
    {
        $this->graduated = $graduated;
        return $this;
    }

    /**
     * @return string
     */
    public function getInstituteId()
    {
        return $this->instituteId;
    }

    /**
     * @param string $instituteId
     * @return QualificationChecks
     */
    public function setInstituteId($instituteId)
    {
        $this->instituteId = $instituteId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return QualificationChecks
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMembership()
    {
        return $this->membership;
    }

    /**
     * @param string $membership
     * @return QualificationChecks
     */
    public function setMembership($membership)
    {
        $this->membership = $membership;
        return $this;
    }

    /**
     * @return int
     */
    public function getVerificationId()
    {
        return $this->verificationId;
    }

    /**
     * @param int $verificationId
     * @return QualificationChecks
     */
    public function setVerificationId($verificationId)
    {
        $this->verificationId = $verificationId;
        return $this;
    }

    /**
     * @return int
     */
    public function getVerificationResponse()
    {
        return $this->verificationResponse;
    }

    /**
     * @param int $verificationResponse
     * @return QualificationChecks
     */
    public function setVerificationResponse($verificationResponse)
    {
        $this->verificationResponse = $verificationResponse;
        return $this;
    }

    /**
     * @return string
     */
    public function getVerificationStatus()
    {
        return $this->verificationStatus;
    }

    /**
     * @param string $verificationStatus
     * @return QualificationChecks
     */
    public function setVerificationStatus($verificationStatus)
    {
        $this->verificationStatus = $verificationStatus;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmployerId()
    {
        return $this->employer_id;
    }

    /**
     * @param string $employer_id
     * @return QualificationChecks
     */
    public function setEmployerId($employer_id)
    {
        $this->employer_id = $employer_id;
        return $this;
    }

}
