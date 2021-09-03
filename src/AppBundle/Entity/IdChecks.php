<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IdChecks
 *
 * @ORM\Table(name="id_checks")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\IdChecksRepository")
 */
class IdChecks
{
    public function __construct()
    {
        $this->setCreatedOn(new \DateTime('now'));
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=45, nullable=false)
     */
    private $jobId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", nullable=true)
     */
    private $createdBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="string", length=45, nullable=true)
     */
    private $pass;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_lines", type="string", length=50, nullable=true)
     */
    private $credit;

    /**
     * @var string
     *
     * @ORM\Column(name="sanctions", type="integer", nullable=true)
     */
    private $sanctions;

    /**
     * @var string
     *
     * @ORM\Column(name="pep", type="integer", nullable=true)
     */
    private $pep;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="submitted_on", type="datetime", nullable=true)
     */
    private $submittedOn;

    /**
     * @var string
     *
     * @ORM\Column(name="short_url", type="string", length=150, nullable=false)
     */
    private $shortUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="unique_id", type="string", length=45)
     */
    private $uniqueId;

    /**
     * @var string
     *
     * @ORM\Column(name="profile", type="string", length=45, nullable=true)
     */
    private $profile;

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
     * Values: NULL, PENDING, FOUND, NOT FOUND, INCONCLUSIVE
     * @ORM\Column(name="director_status", type="string", length=20, nullable=true, options={"default" = "PENDING"} )
	 *
     */
    private $director_status;

    /**
     * @var string
     *
     * @ORM\Column(name="directorships", type="text", length=65535, nullable=true)
     */
    private $directorships;

    /**
     * @var string
     *
     * @ORM\Column(name="director_links", type="text", length=65535, nullable=true)
     */
    private $director_links;

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return IdChecks
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
     * @return IdChecks
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
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     * @return IdChecks
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
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
     * @return IdChecks
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return IdChecks
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
     * Set createdBy
     *
     * @param integer $createdBy
     *
     * @return IdChecks
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return IdChecks
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @param string $credit
     * @return IdChecks
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
        return $this;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return IdChecks
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set submittedOn
     *
     * @param \DateTime $submittedOn
     *
     * @return IdChecks
     */
    public function setSubmittedOn($submittedOn)
    {
        $this->submittedOn = $submittedOn;

        return $this;
    }

    /**
     * Get submittedOn
     *
     * @return \DateTime
     */
    public function getSubmittedOn()
    {
        return $this->submittedOn;
    }

    /**
     * Set shortUrl
     *
     * @param string $shortUrl
     *
     * @return IdChecks
     */
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    /**
     * Get shortUrl
     *
     * @return string
     */
    public function getShortUrl()
    {
        return $this->shortUrl;
    }

    /**
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @param string $uniqueId
     * @return IdChecks
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;
        return $this;
    }



    /**
     * @return string
     */
    public function getSanctions()
    {
        return $this->sanctions;
    }

    /**
     * @param string $sanctions
     * @return IdChecks
     */
    public function setSanctions($sanctions)
    {
        $this->sanctions = $sanctions;
        return $this;
    }

    /**
     * @return string
     */
    public function getPep()
    {
        return $this->pep;
    }

    /**
     * @param string $pep
     * @return IdChecks
     */
    public function setPep($pep)
    {
        $this->pep = $pep;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirectorStatus()
    {
        return $this->director_status;
    }

    /**
     * @param string $director_status
     * @return IdChecks
     */
    public function setDirectorStatus($director_status)
    {
        $this->director_status = $director_status;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirectorships()
    {
        return $this->directorships;
    }

    /**
     * @param string $director_status
     * @return IdChecks
     */
    public function setDirectorships($directorships)
    {
        $this->directorships = $directorships;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirectorLinks()
    {
        return $this->director_links;
    }

    /**
     * @param string $director_links
     * @return IdChecks
     */
    public function setDirectorLinks($director_links)
    {
        $this->director_links = $director_links;
        return $this;
    }

}
