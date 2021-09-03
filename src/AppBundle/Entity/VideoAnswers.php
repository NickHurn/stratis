<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VideoAnswers
 *
 * @ORM\Table(name="video_answers")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VideoAnswersRepository")
 */
class VideoAnswers
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
     * @ORM\Column(name="job_id", type="string", length=32, nullable=false)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="question_id", type="integer", nullable=false)
     */
    private $questionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

	/**
     * @var integer
     *
     * @ORM\Column(name="media_id", type="integer", nullable=false)
     */
    private $mediaId;

	/**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     */
    private $createdOn;


    public function __construct() {
        $this->createdOn = new \DateTime('now');
    }

	/**
     * Set id
     *
     * @param integer $id
     *
     * @return VideoAnswers
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
     * Set jobId
     *
     * @param string $jobId
     * @return VideoAnswers
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
     * Set question_id
     * @param integer $question_id
     * @return VideoAnswers
     */
    public function setQuestionId($question_id)
    {
        $this->questionId = $question_id;
        return $this;
    }

    /**
     * Get question_id
     * @return integer
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }


	/**
     * Set user_id
     * @param integer $user_id
     * @return VideoAnswers
     */
    public function setUserId($user_id)
    {
        $this->userId = $user_id;
        return $this;
    }

    /**
     * Get user_id
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

	
	/**
     * Set videoId
     * @param string $videoId
     * @return VideoQuestions
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Get videoId
     * @return string
     */
    public function getVideoId()
    {
        return $this->videoId;
    }


	/**
     * Set mediaId
     * @param integer $mediaId
     * @return VideoQuestions
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;

        return $this;
    }

    /**
     * Get mediaId
     * @return integer
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

	
	/**
     * Set createdOn
     * @param \DateTime $createdOn
     * @return VideoQuestions
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * Get createdOn
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set active
     * @param integer $active
     * @return VideoQuestions
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Get active
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

}
