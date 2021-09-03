<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Apikeys
 *
 * @ORM\Table(name="apikeys")
 * @ORM\Entity
 */
class Apikeys
{
    /**
     * @var string
     *
     * @ORM\Column(name="apikey", type="string", length=36, nullable=false)
     */
    private $apikey;

    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=true)
     */
    private $employerId;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=false)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=255, nullable=false)
     */
    private $ipAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_accessed", type="datetime", nullable=true)
     */
    private $lastAccessed;

    /**
     * @var integer
     *
     * @ORM\Column(name="access_count", type="integer", nullable=true, options={"default" = 0} )
     */
    private $accessCount = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set apikey
     *
     * @param string $apikey
     *
     * @return Apikeys
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * Get apikey
     *
     * @return string
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return Apikeys
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;

        return $this;
    }

    /**
     * Get employerId
     *
     * @return integer
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Apikeys
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Apikeys
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
     * Set lastAccessed
     *
     * @param \DateTime $lastAccessed
     *
     * @return Apikeys
     */
    public function setLastAccessed($lastAccessed)
    {
        $this->lastAccessed = $lastAccessed;

        return $this;
    }

    /**
     * Get lastAccessed
     *
     * @return \DateTime
     */
    public function getLastAccessed()
    {
        return $this->lastAccessed;
    }

    /**
     * Set accessCount
     *
     * @param integer $accessCount
     *
     * @return Apikeys
     */
    public function setAccessCount($accessCount)
    {
        $this->accessCount = $accessCount;

        return $this;
    }

    /**
     * Get accessCount
     *
     * @return integer
     */
    public function getAccessCount()
    {
        return $this->accessCount;
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
