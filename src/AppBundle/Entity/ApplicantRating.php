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
 * @ORM\Table(name="applicant_rating")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ApplicantRatingRepository")
 */
class ApplicantRating
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
     * @ORM\Column(name="unique_id", type="string", nullable=false)
     */
    private $uniqueId;

    /**
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(name="created_on", type="date", nullable=false)
     */
    private $createdOn;

    /**
     * @ORM\Column(name="notes", type="string", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(name="job_id", type="string", nullable=false)
     */
    private $jobId;

    /**
     * @ORM\Column(name="applicant_id", type="integer", nullable=false)
     */
    private $applicantId;


    /**
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employerId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ApplicantRating
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return ApplicantRating
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     * @return ApplicantRating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
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
     * @return ApplicantRating
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     * @return ApplicantRating
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
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
     * @return ApplicantRating
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
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
     * @return ApplicantRating
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
     * @return ApplicantRating
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;
        return $this;
    }





}