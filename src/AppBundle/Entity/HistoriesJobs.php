<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriesJobs
 *
 * @ORM\Table(name="histories_jobs")
 * @ORM\Entity
 */
class HistoriesJobs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="employment", type="integer", nullable=false)
     */
    private $employment;

    /**
     * @var integer
     *
     * @ORM\Column(name="education", type="integer", nullable=false)
     */
    private $education;

    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=36)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return HistoriesJobs
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
     * Set employment
     *
     * @param integer $employment
     *
     * @return HistoriesJobs
     */
    public function setEmployment($employment)
    {
        $this->employment = $employment;

        return $this;
    }

    /**
     * Get employment
     *
     * @return integer
     */
    public function getEmployment()
    {
        return $this->employment;
    }

    /**
     * Set education
     *
     * @param integer $education
     *
     * @return HistoriesJobs
     */
    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return integer
     */
    public function getEducation()
    {
        return $this->education;
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
}
