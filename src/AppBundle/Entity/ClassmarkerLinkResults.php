<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassmarkerLinkResults
 *
 * @ORM\Table(name="classmarker_link_results", uniqueConstraints={@ORM\UniqueConstraint(name="link_result_id", columns={"link_result_id", "time_finished"})}, indexes={@ORM\Index(name="test_id", columns={"test_id"}), @ORM\Index(name="link_id", columns={"link_id"})})
 * @ORM\Entity
 */
class ClassmarkerLinkResults
{
    /**
     * @var integer
     *
     * @ORM\Column(name="link_result_id", type="integer", nullable=false)
     */
    private $linkResultId;

    /**
     * @var integer
     *
     * @ORM\Column(name="test_id", type="integer", nullable=false)
     */
    private $testId;

    /**
     * @var integer
     *
     * @ORM\Column(name="link_id", type="integer", nullable=false)
     */
    private $linkId;

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
     * @ORM\Column(name="percentage", type="decimal", precision=5, scale=1, nullable=true)
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
     * @ORM\Column(name="time_started", type="integer", nullable=true)
     */
    private $timeStarted;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_finished", type="integer", nullable=true)
     */
    private $timeFinished;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=8, nullable=false)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=2, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="requires_grading", type="string", length=3, nullable=true)
     */
    private $requiresGrading = 'No';

    /**
     * @var string
     *
     * @ORM\Column(name="cm_user_id", type="string", length=100, nullable=true)
     */
    private $cmUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="access_code", type="string", length=255, nullable=true)
     */
    private $accessCode;

    /**
     * @var string
     *
     * @ORM\Column(name="extra_info", type="string", length=255, nullable=true)
     */
    private $extraInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="extra_info2", type="string", length=255, nullable=true)
     */
    private $extraInfo2;

    /**
     * @var string
     *
     * @ORM\Column(name="extra_info3", type="string", length=255, nullable=true)
     */
    private $extraInfo3;

    /**
     * @var string
     *
     * @ORM\Column(name="extra_info4", type="string", length=255, nullable=true)
     */
    private $extraInfo4;

    /**
     * @var string
     *
     * @ORM\Column(name="extra_info5", type="string", length=255, nullable=true)
     */
    private $extraInfo5;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=16, nullable=false)
     */
    private $ipAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="pk_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkId;



    /**
     * Set linkResultId
     *
     * @param integer $linkResultId
     *
     * @return ClassmarkerLinkResults
     */
    public function setLinkResultId($linkResultId)
    {
        $this->linkResultId = $linkResultId;

        return $this;
    }

    /**
     * Get linkResultId
     *
     * @return integer
     */
    public function getLinkResultId()
    {
        return $this->linkResultId;
    }

    /**
     * Set testId
     *
     * @param integer $testId
     *
     * @return ClassmarkerLinkResults
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
     * Set linkId
     *
     * @param integer $linkId
     *
     * @return ClassmarkerLinkResults
     */
    public function setLinkId($linkId)
    {
        $this->linkId = $linkId;

        return $this;
    }

    /**
     * Get linkId
     *
     * @return integer
     */
    public function getLinkId()
    {
        return $this->linkId;
    }

    /**
     * Set first
     *
     * @param string $first
     *
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * @return ClassmarkerLinkResults
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
     * Set cmUserId
     *
     * @param string $cmUserId
     *
     * @return ClassmarkerLinkResults
     */
    public function setCmUserId($cmUserId)
    {
        $this->cmUserId = $cmUserId;

        return $this;
    }

    /**
     * Get cmUserId
     *
     * @return string
     */
    public function getCmUserId()
    {
        return $this->cmUserId;
    }

    /**
     * Set accessCode
     *
     * @param string $accessCode
     *
     * @return ClassmarkerLinkResults
     */
    public function setAccessCode($accessCode)
    {
        $this->accessCode = $accessCode;

        return $this;
    }

    /**
     * Get accessCode
     *
     * @return string
     */
    public function getAccessCode()
    {
        return $this->accessCode;
    }

    /**
     * Set extraInfo
     *
     * @param string $extraInfo
     *
     * @return ClassmarkerLinkResults
     */
    public function setExtraInfo($extraInfo)
    {
        $this->extraInfo = $extraInfo;

        return $this;
    }

    /**
     * Get extraInfo
     *
     * @return string
     */
    public function getExtraInfo()
    {
        return $this->extraInfo;
    }

    /**
     * Set extraInfo2
     *
     * @param string $extraInfo2
     *
     * @return ClassmarkerLinkResults
     */
    public function setExtraInfo2($extraInfo2)
    {
        $this->extraInfo2 = $extraInfo2;

        return $this;
    }

    /**
     * Get extraInfo2
     *
     * @return string
     */
    public function getExtraInfo2()
    {
        return $this->extraInfo2;
    }

    /**
     * Set extraInfo3
     *
     * @param string $extraInfo3
     *
     * @return ClassmarkerLinkResults
     */
    public function setExtraInfo3($extraInfo3)
    {
        $this->extraInfo3 = $extraInfo3;

        return $this;
    }

    /**
     * Get extraInfo3
     *
     * @return string
     */
    public function getExtraInfo3()
    {
        return $this->extraInfo3;
    }

    /**
     * Set extraInfo4
     *
     * @param string $extraInfo4
     *
     * @return ClassmarkerLinkResults
     */
    public function setExtraInfo4($extraInfo4)
    {
        $this->extraInfo4 = $extraInfo4;

        return $this;
    }

    /**
     * Get extraInfo4
     *
     * @return string
     */
    public function getExtraInfo4()
    {
        return $this->extraInfo4;
    }

    /**
     * Set extraInfo5
     *
     * @param string $extraInfo5
     *
     * @return ClassmarkerLinkResults
     */
    public function setExtraInfo5($extraInfo5)
    {
        $this->extraInfo5 = $extraInfo5;

        return $this;
    }

    /**
     * Get extraInfo5
     *
     * @return string
     */
    public function getExtraInfo5()
    {
        return $this->extraInfo5;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return ClassmarkerLinkResults
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
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
