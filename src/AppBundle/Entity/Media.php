<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Table(name="media")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MediaRepository")
 */
class Media
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
     * @var string
     *
     * @ORM\Column(name="mediatype", type="string", length=20, nullable=false)
     */
    private $mediaType;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="job_id", type="integer", nullable=true)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="seq", type="integer", nullable=false)
     */
    private $seq;

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=20, nullable=false)
     */
    private $format;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="extn", type="text", nullable=false)
     */
    private $extn;



	
    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Media
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

	
    /**
     * Set 
     *
     * @param  $mediaType
     *
     * @return Media
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * Get employerId
     *
     * @return integer
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

	
	/**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Media
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
     * Set jobId
     *
     * @param string $jobId
     *
     * @return Media
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
     * @param int $seq
     * @return Media
     */
    public function setSeq($seq)
    {
        $this->seq = $seq;
        return $this;
    }
	
	/**
     * @return int $seq
     */
    public function getSeq()
    {
        return $this->seq;
    }


	/**
     * @param string $format
     * @return Media
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }
	
	/**
     * @return string $format
     */
    public function getFormat()
    {
        return $this->format;
    }


	/**
     * @param string $filename
     * @return Media
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }
	
	/**
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }	
	
	/**
     * @param string $extn
     * @return Media
     */
    public function setExtn($extn)
    {
        $this->extn = $extn;
        return $this;
    }
	
	/**
     * @return string $extn
     */
    public function getExtn()
    {
        return $this->extn;
    }	
}
