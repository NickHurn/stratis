<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TermsAgreed
 *
 * @ORM\Table(name="terms_agreed")
 * @ORM\Entity
 */
class TermsAgreed
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

	/**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

	/**
     * @var integer
     *
     * @ORM\Column(name="job_id", type="integer", nullable=false)
     */
    private $jobId;



	
	/**
     * Set user_id
     *
     * @param integer $user_id
     *
     * @return TermsAgreed
     */
    public function setUserId($user_id)
    {
        $this->userId = $user_id;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }
	

	/**
     * Set job_id
     *
     * @param integer $job_id
     *
     * @return TermsAgreed
     */
    public function setJobId($job_id)
    {
        $this->jobId = $job_id;

        return $this;
    }

    /**
     * Get job_id
     *
     * @return integer
     */
    public function getJobId()
    {
        return $this->jobId;
    }
}
