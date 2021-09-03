<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriesComplete
 *
 * @ORM\Table(name="histories_complete")
 * @ORM\Entity
 */
class HistoriesComplete
{
    /**
     * @var integer
     *
     * @ORM\Column(name="education", type="integer", nullable=true)
     */
    private $education;

    /**
     * @var integer
     *
     * @ORM\Column(name="employment", type="integer", nullable=true)
     */
    private $employment;

    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=32)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $userId;



    /**
     * Set education
     *
     * @param integer $education
     *
     * @return HistoriesComplete
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
     * Set employment
     *
     * @param integer $employment
     *
     * @return HistoriesComplete
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
     * Set jobId
     *
     * @param string $jobId
     *
     * @return HistoriesComplete
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
     * @return HistoriesComplete
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
}
