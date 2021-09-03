<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cv
 *
 * @ORM\Table(name="cv")
 * @ORM\Entity
 */
class Cv
{
    /**
     * @var string
     *
     * @ORM\Column(name="original_name", type="string", length=255, nullable=true)
     */
    private $originalName;

    /**
     * @var string
     *
     * @ORM\Column(name="stored_name", type="string", length=45, nullable=false)
     */
    private $storedName;

    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=45, nullable=false)
     */
    private $jobId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_id", type="string", length=45, nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="mime_type", type="string", length=255, nullable=true)
     */
    private $mimeType;

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
     * Set originalName
     *
     * @param string $originalName
     *
     * @return Cv
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get originalName
     *
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set storedName
     *
     * @param string $storedName
     *
     * @return Cv
     */
    public function setStoredName($storedName)
    {
        $this->storedName = $storedName;

        return $this;
    }

    /**
     * Get storedName
     *
     * @return string
     */
    public function getStoredName()
    {
        return $this->storedName;
    }

    /**
     * Set jobId
     *
     * @param string $jobId
     *
     * @return Cv
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
     * @param string $userId
     *
     * @return Cv
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return Cv
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Cv
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
