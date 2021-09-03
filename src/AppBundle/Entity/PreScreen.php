<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PreScreen
 *
 * @ORM\Table(name="pre_screen")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PreScreenRepository")
 */
class PreScreen
{
    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=45, nullable=true)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     */
    private $updatedOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="java_development_experience", type="integer", nullable=false)
     */
    private $javaDevelopmentExperience;

    /**
     * @var integer
     *
     * @ORM\Column(name="low_latency_experience", type="integer", nullable=false)
     */
    private $lowLatencyExperience;
    /**
     * @var integer
     *
     * @ORM\Column(name="network_layer_experience", type="integer", nullable=false)
     */
    private $networkLayerExperience;
    /**
     * @var integer
     *
     * @ORM\Column(name="lock_free_algorithms_experience", type="integer", nullable=false)
     */
    private $lockFreeAlgorithmsExperience;
    /**
     * @var integer
     *
     * @ORM\Column(name="linear_algebra_experience", type="integer", nullable=false)
     */
    private $linearAlgebraExperience;
    /**
     * @var integer
     *
     * @ORM\Column(name="telemetry_systems_experience", type="integer", nullable=false)
     */
    private $TelemetrySystemsExperience;
    /**
     * @var integer
     *
     * @ORM\Column(name="cexperience", type="integer", nullable=false)
     */
    private $cExperience;
    /**
     * @var integer
     *
     * @ORM\Column(name="database_experience", type="integer", nullable=false)
     */
    private $databaseExperience;

    public function __construct() {
        $this->createdOn = new \DateTime('now');
    }

    /**
     * @return string
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param string $jobId
     * @return PreScreen
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return PreScreen
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     * @return PreScreen
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param \DateTime $updatedOn
     * @return PreScreen
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PreScreen
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getJavaDevelopmentExperience()
    {
        return $this->javaDevelopmentExperience;
    }

    /**
     * @param int $javaDevelopmentExperience
     * @return PreScreen
     */
    public function setJavaDevelopmentExperience($javaDevelopmentExperience)
    {
        $this->javaDevelopmentExperience = $javaDevelopmentExperience;
        return $this;
    }

    /**
     * @return int
     */
    public function getLowLatencyExperience()
    {
        return $this->lowLatencyExperience;
    }

    /**
     * @param int $lowLatencyExperience
     * @return PreScreen
     */
    public function setLowLatencyExperience($lowLatencyExperience)
    {
        $this->lowLatencyExperience = $lowLatencyExperience;
        return $this;
    }

    /**
     * @return int
     */
    public function getNetworkLayerExperience()
    {
        return $this->networkLayerExperience;
    }

    /**
     * @param int $networkLayerExperience
     * @return PreScreen
     */
    public function setNetworkLayerExperience($networkLayerExperience)
    {
        $this->networkLayerExperience = $networkLayerExperience;
        return $this;
    }

    /**
     * @return int
     */
    public function getLockFreeAlgorithmsExperience()
    {
        return $this->lockFreeAlgorithmsExperience;
    }

    /**
     * @param int $lockFreeAlgorithmsExperience
     * @return PreScreen
     */
    public function setLockFreeAlgorithmsExperience($lockFreeAlgorithmsExperience)
    {
        $this->lockFreeAlgorithmsExperience = $lockFreeAlgorithmsExperience;
        return $this;
    }

    /**
     * @return int
     */
    public function getLinearAlgebraExperience()
    {
        return $this->linearAlgebraExperience;
    }

    /**
     * @param int $linearAlgebraExperience
     * @return PreScreen
     */
    public function setLinearAlgebraExperience($linearAlgebraExperience)
    {
        $this->linearAlgebraExperience = $linearAlgebraExperience;
        return $this;
    }

    /**
     * @return int
     */
    public function getTelemetrySystemsExperience()
    {
        return $this->TelemetrySystemsExperience;
    }

    /**
     * @param int $TelemetrySystemsExperience
     * @return PreScreen
     */
    public function setTelemetrySystemsExperience($TelemetrySystemsExperience)
    {
        $this->TelemetrySystemsExperience = $TelemetrySystemsExperience;
        return $this;
    }

    /**
     * @return int
     */
    public function getCExperience()
    {
        return $this->cExperience;
    }

    /**
     * @param int $cExperience
     * @return PreScreen
     */
    public function setCExperience($cExperience)
    {
        $this->cExperience = $cExperience;
        return $this;
    }

    /**
     * @return int
     */
    public function getDatabaseExperience()
    {
        return $this->databaseExperience;
    }

    /**
     * @param int $databaseExperience
     * @return PreScreen
     */
    public function setDatabaseExperience($databaseExperience)
    {
        $this->databaseExperience = $databaseExperience;
        return $this;
    }



}
