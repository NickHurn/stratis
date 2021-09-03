<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UsersJob
 *
 * @ORM\Table(name="users_job")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UsersJobsRepository")
 */
class UsersJob
{
    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=32, nullable=false)
     */
    private $jobId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modified", type="datetime", nullable=true)
     */
    private $lastModified;

    /**
     * @var integer
     *
     * @ORM\Column(name="pre_screen_pass", type="integer", nullable=true)
     */
    private $preScreenPass;

    /**
     * @var integer
     *
     * @ORM\Column(name="archived", type="integer", nullable=true, options={"default" = 0})
     */
    private $archived = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="accepted", type="integer", nullable=true)
     */
    private $accepted;

    /**
     * @var integer
     *
     * @ORM\Column(name="web_hook_processed", type="integer", nullable=true)
     */
    private $webhookProcessed;

    /**
     * @var integer
     *
     * @ORM\Column(name="offered", type="integer", nullable=true)
     */
    private $offered;

    /**
     * @var integer
     *
     * @ORM\Column(name="rejected", type="integer", nullable=true)
     */
    private $rejected;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accepted_on", type="datetime", nullable=true)
     */
    private $acceptedOn;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\WebHookLog")
     * @ORM\JoinTable(name="usersjob_webhooklog",
     *      joinColumns={@ORM\JoinColumn(name="userjob_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="weblog_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $webHookLogs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="offered_on", type="datetime", nullable=true)
     */
    private $offeredOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rejected_on", type="datetime", nullable=true)
     */
    private $rejectedOn;

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
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

	/**
     * @var integer
     * @ORM\Column(name="checkabl_count", type="integer", nullable=true)
     */
    private $checkablCount;

	/**
     * @var integer
     * @ORM\Column(name="checkabl_completed", type="integer", nullable=true)
     */
    private $checkablCompleted;

	/**
     * @var integer
     * @ORM\Column(name="testabl_count", type="integer", nullable=true)
     */
    private $testablCount;

	/**
     * @var integer
     * @ORM\Column(name="testabl_completed", type="integer", nullable=true)
     */
    private $testablCompleted;
	
	/**
     * @var integer
     * @ORM\Column(name="personabl_count", type="integer", nullable=true)
     */
    private $personablCount;

	/**
     * @var integer
     * @ORM\Column(name="personabl_completed", type="integer", nullable=true)
     */
    private $personablCompleted;
	
	
	public function __construct()
    {
        $this->webHookLogs = new ArrayCollection();
        $this->webhookProcessed = 0;
        $this->createdOn = new \DateTime('now');
    }

    /**
     * Set jobId
     *
     * @param string $jobId
     *
     * @return UsersJob
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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return UsersJob
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
     * Set lastModified
     *
     * @param \DateTime $lastModified
     *
     * @return UsersJob
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set preScreenPass
     *
     * @param integer $preScreenPass
     *
     * @return UsersJob
     */
    public function setPreScreenPass($preScreenPass)
    {
        $this->preScreenPass = $preScreenPass;

        return $this;
    }

    /**
     * Get preScreenPass
     *
     * @return integer
     */
    public function getPreScreenPass()
    {
        return $this->preScreenPass;
    }

    /**
     * Set archived
     *
     * @param integer $archived
     *
     * @return UsersJob
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return integer
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set accepted
     *
     * @param integer $accepted
     *
     * @return UsersJob
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return integer
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set offered
     *
     * @param integer $offered
     *
     * @return UsersJob
     */
    public function setOffered($offered)
    {
        $this->offered = $offered;

        return $this;
    }

    /**
     * Get offered
     *
     * @return integer
     */
    public function getOffered()
    {
        return $this->offered;
    }

    /**
     * Set rejected
     *
     * @param integer $rejected
     *
     * @return UsersJob
     */
    public function setRejected($rejected)
    {
        $this->rejected = $rejected;

        return $this;
    }

    /**
     * Get rejected
     *
     * @return integer
     */
    public function getRejected()
    {
        return $this->rejected;
    }

    /**
     * Set acceptedOn
     *
     * @param \DateTime $acceptedOn
     *
     * @return UsersJob
     */
    public function setAcceptedOn($acceptedOn)
    {
        $this->acceptedOn = $acceptedOn;

        return $this;
    }

    /**
     * Get acceptedOn
     *
     * @return \DateTime
     */
    public function getAcceptedOn()
    {
        return $this->acceptedOn;
    }

    /**
     * Set offeredOn
     *
     * @param \DateTime $offeredOn
     *
     * @return UsersJob
     */
    public function setOfferedOn($offeredOn)
    {
        $this->offeredOn = $offeredOn;

        return $this;
    }

    /**
     * Get offeredOn
     *
     * @return \DateTime
     */
    public function getOfferedOn()
    {
        return $this->offeredOn;
    }

    /**
     * Set rejectedOn
     *
     * @param \DateTime $rejectedOn
     *
     * @return UsersJob
     */
    public function setRejectedOn($rejectedOn)
    {
        $this->rejectedOn = $rejectedOn;

        return $this;
    }

    /**
     * Get rejectedOn
     *
     * @return \DateTime
     */
    public function getRejectedOn()
    {
        return $this->rejectedOn;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return UsersJob
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return UsersJob
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
     * @return mixed
     */
    public function getWebHookLogs()
    {
        return $this->webHookLogs;
    }

    /**
     * @param mixed $webHookLogs
     * @return UsersJob
     */
    public function setWebHookLogs($webHookLogs)
    {
        $this->webHookLogs = $webHookLogs;
        return $this;
    }

    /**
     * @return int
     */
    public function getWebhookProcessed()
    {
        return $this->webhookProcessed;
    }

    /**
     * @param int $webhookProcessed
     * @return UsersJob
     */
    public function setWebhookProcessed($webhookProcessed)
    {
        $this->webhookProcessed = $webhookProcessed;
        return $this;
    }

    
	/**
     * Set checkabl_count
     * @param integer $n
     * @return UsersJob
     */
    public function setCheckablCount($n)
    {
        $this->checkablCount = $n;
        return $this;
    }

    /**
     * Get checkabl_count
     * @return integer
     */
    public function getCheckablCount()
    {
        return $this->checkablCount;
    }

	/**
     * Set testabl_count
     * @param integer $n
     * @return UsersJob
     */
    public function setTestablCount($n)
    {
        $this->testablCount = $n;
        return $this;
    }

    /**
     * Get testabl_count
     * @return integer
     */
    public function getTestablCount()
    {
        return $this->testablCount;
    }

	/**
     * Set personabl_count
     * @param integer $n
     * @return UsersJob
     */
    public function setPersonablCount($n)
    {
        $this->personablCount = $n;
        return $this;
    }

    /**
     * Get personabl_count
     * @return integer
     */
    public function getPersonablCount()
    {
        return $this->personablCount;
    }
	
	
	/**
     * Set checkabl_completed
     * @param integer $n
     * @return UsersJob
     */
    public function setCheckablCompleted($n)
    {
        $this->checkablCompleted = $n;
        return $this;
    }

    /**
     * Get checkabl_completed
     * @return integer
     */
    public function getCheckablCompleted()
    {
        return $this->checkablCompleted;
    }

	/**
     * Set testabl_completed
     * @param integer $n
     * @return UsersJob
     */
    public function setTestablCompleted($n)
    {
        $this->testablCompleted = $n;
        return $this;
    }

    /**
     * Get testabl_completed
     * @return integer
     */
    public function getTestablCompleted()
    {
        return $this->testablCompleted;
    }

	/**
     * Set personabl_completed
     * @param integer $n
     * @return UsersJob
     */
    public function setPersonablCompleted($n)
    {
        $this->personablCompleted = $n;
        return $this;
    }

    /**
     * Get personabl_completed
     * @return integer
     */
    public function getPersonablCompleted()
    {
        return $this->personablCompleted;
    }
}
