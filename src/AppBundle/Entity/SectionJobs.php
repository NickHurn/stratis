<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SectionJobs
 *
 * @ORM\Table(name="section_jobs")
 * @ORM\Entity
 */
class SectionJobs
{
    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=32, nullable=false)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="checkabl", type="integer", nullable=false, options={"default" = 1})
     */
    private $checkabl = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="testabl", type="integer", nullable=false, options={"default" = 1})
     */
    private $testabl = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="personabl", type="integer", nullable=false, options={"default" = 1})
     */
    private $personabl = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
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
     * Set jobId
     *
     * @param string $jobId
     *
     * @return SectionJobs
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
     * Set checkabl
     *
     * @param integer $checkabl
     *
     * @return SectionJobs
     */
    public function setCheckabl($checkabl)
    {
        $this->checkabl = $checkabl;

        return $this;
    }

    /**
     * Get checkabl
     *
     * @return integer
     */
    public function getCheckabl()
    {
        return $this->checkabl;
    }

    /**
     * Set testabl
     *
     * @param integer $testabl
     *
     * @return SectionJobs
     */
    public function setTestabl($testabl)
    {
        $this->testabl = $testabl;

        return $this;
    }

    /**
     * Get testabl
     *
     * @return integer
     */
    public function getTestabl()
    {
        return $this->testabl;
    }

    /**
     * Set personabl
     *
     * @param integer $personabl
     *
     * @return SectionJobs
     */
    public function setPersonabl($personabl)
    {
        $this->personabl = $personabl;

        return $this;
    }

    /**
     * Get personabl
     *
     * @return integer
     */
    public function getPersonabl()
    {
        return $this->personabl;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return SectionJobs
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
}
