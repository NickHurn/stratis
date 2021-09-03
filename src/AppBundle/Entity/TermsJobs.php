<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TermsJobs
 *
 * @ORM\Table(name="terms_jobs")
 * @ORM\Entity
 */
class TermsJobs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="terms_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $termsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="job_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $jobId;



    /**
     * Set termsId
     *
     * @param integer $termsId
     *
     * @return TermsJobs
     */
    public function setTermsId($termsId)
    {
        $this->termsId = $termsId;

        return $this;
    }

    /**
     * Get termsId
     *
     * @return integer
     */
    public function getTermsId()
    {
        return $this->termsId;
    }

    /**
     * Set jobId
     *
     * @param integer $jobId
     *
     * @return TermsJobs
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Get jobId
     *
     * @return integer
     */
    public function getJobId()
    {
        return $this->jobId;
    }
}
