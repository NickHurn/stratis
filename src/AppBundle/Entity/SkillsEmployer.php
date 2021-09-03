<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkillsEmployer
 *
 * @ORM\Table(name="skills_employer")
 * @ORM\Entity
 */
class SkillsEmployer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="skill_id", type="integer", nullable=false)
     */
    private $skillId;

    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employerId;

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
     * Set skillId
     *
     * @param integer $skillId
     *
     * @return SkillsEmployer
     */
    public function setSkillId($skillId)
    {
        $this->skillId = $skillId;

        return $this;
    }

    /**
     * Get skillId
     *
     * @return integer
     */
    public function getSkillId()
    {
        return $this->skillId;
    }

    /**
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return SkillsEmployer
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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return SkillsEmployer
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
