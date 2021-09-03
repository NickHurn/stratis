<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SectionDefaults
 *
 * @ORM\Table(name="section_defaults")
 * @ORM\Entity
 */
class SectionDefaults
{
    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="checkabl", type="integer", nullable=false, options={"default" = 1})
     */
    private $checkabl = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="testabl", type="integer", nullable=false, options={"default" = 1})
     */
    private $testabl = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="personabl", type="integer", nullable=false, options={"default" = 1})
     */
    private $personabl = '1';

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
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return SectionDefaults
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
     * Set checkabl
     *
     * @param integer $checkabl
     *
     * @return SectionDefaults
     */
    public function setCheckabl($checkabl)
    {
        $this->checkabl = $checkabl;

        return $this;
    }

    /**
     * Get checkabl
     *
     * @return integer
     */
    public function getCheckabl()
    {
        return $this->checkabl;
    }

    /**
     * Set testabl
     *
     * @param integer $testabl
     *
     * @return SectionDefaults
     */
    public function setTestabl($testabl)
    {
        $this->testabl = $testabl;

        return $this;
    }

    /**
     * Get testabl
     *
     * @return integer
     */
    public function getTestabl()
    {
        return $this->testabl;
    }

    /**
     * Set personabl
     *
     * @param integer $personabl
     *
     * @return SectionDefaults
     */
    public function setPersonabl($personabl)
    {
        $this->personabl = $personabl;

        return $this;
    }

    /**
     * Get personabl
     *
     * @return integer
     */
    public function getPersonabl()
    {
        return $this->personabl;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return SectionDefaults
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
