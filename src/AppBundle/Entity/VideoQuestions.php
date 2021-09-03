<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VideoQuestions
 *
 * @ORM\Table(name="video_questions")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VideoQuestionsRepository")
 */
class VideoQuestions
{
    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=32, nullable=false)
     */
    private $jobId;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=512, nullable=false)
     */
    private $question;

    /**
     * @var integer
     *
     * @ORM\Column(name="video", type="integer", nullable=true, options={"default" = 0})
     */
    private $video = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="video_id", type="string", length=45, nullable=true)
     */
    private $videoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="media_id", type="integer", nullable=true, options={"default" = 0})
     */
    private $mediaId = '0';

	/**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer", nullable=true)
     */
    private $active;

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
     * @return VideoQuestions
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
     * Set question
     *
     * @param string $question
     *
     * @return VideoQuestions
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set video
     *
     * @param integer $video
     *
     * @return VideoQuestions
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return integer
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set videoId
     *
     * @param string $videoId
     *
     * @return VideoQuestions
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get videoId
     *
     * @return string
     */
    public function getVideoId()
    {
        return $this->videoId;
    }


	/**
     * Set mediaId
     *
     * @param integer $mediaId
     *
     * @return VideoQuestions
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;

        return $this;
    }

    /**
     * Get mediaId
     *
     * @return integer
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

	
	/**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return VideoQuestions
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
     * Set active
     *
     * @param integer $active
     *
     * @return VideoQuestions
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
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
