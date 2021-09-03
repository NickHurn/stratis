<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassmarkerGroupResults
 *
 * @ORM\Table(name="classmarker_group_results", uniqueConstraints={@ORM\UniqueConstraint(name="user_id", columns={"user_id", "test_id", "group_id", "time_finished"})}, indexes={@ORM\Index(name="test_id", columns={"test_id"}), @ORM\Index(name="group_id", columns={"group_id"})})
 * @ORM\Entity
 */
class ClassmarkerGroupResults
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="test_id", type="integer", nullable=false)
     */
    private $testId;

    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false)
     */
    private $groupId;

    /**
     * @var string
     *
     * @ORM\Column(name="first", type="string", length=50, nullable=true)
     */
    private $first;

    /**
     * @var string
     *
     * @ORM\Column(name="last", type="string", length=50, nullable=true)
     */
    private $last;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="percentage", type="decimal", precision=5, scale=1, nullable=false)
     */
    private $percentage;

    /**
     * @var string
     *
     * @ORM\Column(name="points_scored", type="decimal", precision=5, scale=1, nullable=false)
     */
    private $pointsScored;

    /**
     * @var string
     *
     * @ORM\Column(name="points_available", type="decimal", precision=5, scale=1, nullable=false)
     */
    private $pointsAvailable;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_started", type="integer", nullable=false)
     */
    private $timeStarted;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_finished", type="integer", nullable=false)
     */
    private $timeFinished;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=8, nullable=false)
     */
    private $duration = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=2, nullable=false)
     */
    private $status = 'f';

    /**
     * @var string
     *
     * @ORM\Column(name="requires_grading", type="string", length=3, nullable=false)
     */
    private $requiresGrading = 'No';

    /**
     * @var integer
     *
     * @ORM\Column(name="pk_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkId;



    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return ClassmarkerGroupResults
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
     * Set testId
     *
     * @param integer $testId
     *
     * @return ClassmarkerGroupResults
     */
    public function setTestId($testId)
    {
        $this->testId = $testId;

        return $this;
    }

    /**
     * Get testId
     *
     * @return integer
     */
    public function getTestId()
    {
        return $this->testId;
    }

    /**
     * Set groupId
     *
     * @param integer $groupId
     *
     * @return ClassmarkerGroupResults
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set first
     *
     * @param string $first
     *
     * @return ClassmarkerGroupResults
     */
    public function setFirst($first)
    {
        $this->first = $first;

        return $this;
    }

    /**
     * Get first
     *
     * @return string
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * Set last
     *
     * @param string $last
     *
     * @return ClassmarkerGroupResults
     */
    public function setLast($last)
    {
        $this->last = $last;

        return $this;
    }

    /**
     * Get last
     *
     * @return string
     */
    public function getLast()
    {
        return $this->last;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return ClassmarkerGroupResults
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set percentage
     *
     * @param string $percentage
     *
     * @return ClassmarkerGroupResults
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return string
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set pointsScored
     *
     * @param string $pointsScored
     *
     * @return ClassmarkerGroupResults
     */
    public function setPointsScored($pointsScored)
    {
        $this->pointsScored = $pointsScored;

        return $this;
    }

    /**
     * Get pointsScored
     *
     * @return string
     */
    public function getPointsScored()
    {
        return $this->pointsScored;
    }

    /**
     * Set pointsAvailable
     *
     * @param string $pointsAvailable
     *
     * @return ClassmarkerGroupResults
     */
    public function setPointsAvailable($pointsAvailable)
    {
        $this->pointsAvailable = $pointsAvailable;

        return $this;
    }

    /**
     * Get pointsAvailable
     *
     * @return string
     */
    public function getPointsAvailable()
    {
        return $this->pointsAvailable;
    }

    /**
     * Set timeStarted
     *
     * @param integer $timeStarted
     *
     * @return ClassmarkerGroupResults
     */
    public function setTimeStarted($timeStarted)
    {
        $this->timeStarted = $timeStarted;

        return $this;
    }

    /**
     * Get timeStarted
     *
     * @return integer
     */
    public function getTimeStarted()
    {
        return $this->timeStarted;
    }

    /**
     * Set timeFinished
     *
     * @param integer $timeFinished
     *
     * @return ClassmarkerGroupResults
     */
    public function setTimeFinished($timeFinished)
    {
        $this->timeFinished = $timeFinished;

        return $this;
    }

    /**
     * Get timeFinished
     *
     * @return integer
     */
    public function getTimeFinished()
    {
        return $this->timeFinished;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return ClassmarkerGroupResults
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return ClassmarkerGroupResults
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set requiresGrading
     *
     * @param string $requiresGrading
     *
     * @return ClassmarkerGroupResults
     */
    public function setRequiresGrading($requiresGrading)
    {
        $this->requiresGrading = $requiresGrading;

        return $this;
    }

    /**
     * Get requiresGrading
     *
     * @return string
     */
    public function getRequiresGrading()
    {
        return $this->requiresGrading;
    }

    /**
     * Get pkId
     *
     * @return integer
     */
    public function getPkId()
    {
        return $this->pkId;
    }
}
