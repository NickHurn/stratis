<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GbgResponses
 *
 * @ORM\Table(name="gbg_responses")
 * @ORM\Entity
 */
class GbgResponses
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employerId;

    /**
     * @var string
     *
     * @ORM\Column(name="response", type="text", length=65535, nullable=true)
     */
    private $response;

    /**
     * @var string
     *
     * @ORM\Column(name="check_id", type="string", length=36, nullable=false)
     */
    private $checkId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25, nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

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
     * Set userId
     *
     * @param integer $userId
     *
     * @return GbgResponses
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
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return GbgResponses
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
     * Set response
     *
     * @param string $response
     *
     * @return GbgResponses
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set checkId
     *
     * @param string $checkId
     *
     * @return GbgResponses
     */
    public function setCheckId($checkId)
    {
        $this->checkId = $checkId;

        return $this;
    }

    /**
     * Get checkId
     *
     * @return string
     */
    public function getCheckId()
    {
        return $this->checkId;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return GbgResponses
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return GbgResponses
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
