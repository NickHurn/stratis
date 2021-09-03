<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CheckablFilters
 *
 * @ORM\Table(name="checkabl_filters")
 * @ORM\Entity
 */
class CheckablFilters
{


    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=45, nullable=false)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="pre_screen", type="integer", nullable=false)
     */
    private $preScreen;

    /**
     * @var integer
     *
     * @ORM\Column(name="history", type="integer", nullable=false)
     */
    private $history;

    /**
     * @var integer
     *
     * @ORM\Column(name="disclosures", type="integer", nullable=false, options={"default" : 0})
     */
    private $disclosures;

    /**
     * @var integer
     *
     * @ORM\Column(name="visualid", type="integer", nullable=false, options={"default" : 0})
     */
    private $visualid;

	/**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false )
     */
    private $createdOn ;

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
     * @return CheckablFilters
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
     * Set preScreen
     *
     * @param integer $preScreen
     *
     * @return CheckablFilters
     */
    public function setPreScreen($preScreen)
    {
        $this->preScreen = $preScreen;

        return $this;
    }

    /**
     * Get preScreen
     *
     * @return integer
     */
    public function getPreScreen()
    {
        return $this->preScreen;
    }

    /**
     * Set history
     *
     * @param integer $history
     *
     * @return CheckablFilters
     */
    public function setHistory($history)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history
     *
     * @return integer
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set disclosures
     *
     * @param integer $disclosures
     *
     * @return CheckablFilters
     */
    public function setDisclosures($disclosures)
    {
        $this->disclosures = $disclosures;

        return $this;
    }

    /**
     * Get disclosures
     *
     * @return integer
     */
    public function getDisclosures()
    {
        return $this->disclosures;
    }

    /**
     * Set visualid
     *
     * @param integer $visualid
     *
     * @return CheckablFilters
     */
    public function setVisualId($visualid)
    {
        $this->visualid = $visualid;

        return $this;
    }

    /**
     * Get visualid
     *
     * @return integer
     */
    public function getVisualId()
    {
        return $this->visualid;
    }

	/**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return CheckablFilters
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
