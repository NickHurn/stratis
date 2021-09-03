<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity
 */
class Video
{
    /**
     * @var string
     *
     * @ORM\Column(name="video_id", type="string", length=45, nullable=false)
     */
    private $videoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=32, nullable=false)
     */
    private $jobId;

    /**
     * @var string
     *
     * @ORM\Column(name="app_id", type="string", length=45, nullable=false)
     */
    private $appId;

    /**
     * @var integer
     *
     * @ORM\Column(name="question_id", type="integer", nullable=false)
     */
    private $questionId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="recorded_on", type="datetime", nullable=true)
     */
    private $recordedOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct() {
        $this->recordedOn = new \DateTime('now');
    }

    /**
     * Set videoId
     *
     * @param string $videoId
     *
     * @return Video
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Video
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
     * @return Video
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
     * Set appId
     *
     * @param string $appId
     *
     * @return Video
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * Get appId
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Set questionId
     *
     * @param integer $questionId
     *
     * @return Video
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * Get questionId
     *
     * @return integer
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Set recordedOn
     *
     * @param \DateTime $recordedOn
     *
     * @return Video
     */
    public function setRecordedOn($recordedOn)
    {
        $this->recordedOn = $recordedOn;

        return $this;
    }

    /**
     * Get recordedOn
     *
     * @return \DateTime
     */
    public function getRecordedOn()
    {
        return $this->recordedOn;
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
