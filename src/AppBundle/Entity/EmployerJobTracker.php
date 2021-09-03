<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmployerJobTracker
 *
 * @ORM\Table(name="employer_job_tracker")
 * @ORM\Entity
 */
class EmployerJobTracker
{
    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=45, nullable=true)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_accessed", type="datetime", nullable=true)
     */
    private $lastAccessed;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct() {
        $this->lastAccessed = new \DateTime('now');
    }

    /**
     * Set jobId
     *
     * @param string $jobId
     *
     * @return EmployerJobTracker
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return EmployerJobTracker
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
     * Set lastAccessed
     *
     * @param \DateTime $lastAccessed
     *
     * @return EmployerJobTracker
     */
    public function setLastAccessed($lastAccessed)
    {
        $this->lastAccessed = $lastAccessed;

        return $this;
    }

    /**
     * Get lastAccessed
     *
     * @return \DateTime
     */
    public function getLastAccessed()
    {
        return $this->lastAccessed;
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
