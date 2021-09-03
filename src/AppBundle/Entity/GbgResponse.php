<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GbgResponse
 *
 * @ORM\Table(name="gbg_response")
 * @ORM\Entity
 */
class GbgResponse
{
    /**
     * @var string
     *
     * @ORM\Column(name="check_id", type="string", length=36, nullable=false)
     */
    private $checkId;

    /**
     * @var string
     *
     * @ORM\Column(name="repsonse", type="text", length=65535, nullable=false)
     */
    private $repsonse;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="descision", type="string", length=45, nullable=true)
     */
    private $descision;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
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
     * Set checkId
     *
     * @param string $checkId
     *
     * @return GbgResponse
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
     * Set repsonse
     *
     * @param string $repsonse
     *
     * @return GbgResponse
     */
    public function setRepsonse($repsonse)
    {
        $this->repsonse = $repsonse;

        return $this;
    }

    /**
     * Get repsonse
     *
     * @return string
     */
    public function getRepsonse()
    {
        return $this->repsonse;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return GbgResponse
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
     * Set descision
     *
     * @param string $descision
     *
     * @return GbgResponse
     */
    public function setDescision($descision)
    {
        $this->descision = $descision;

        return $this;
    }

    /**
     * Get descision
     *
     * @return string
     */
    public function getDescision()
    {
        return $this->descision;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return GbgResponse
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
