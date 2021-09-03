<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SourceByEmployers
 *
 * @ORM\Table(name="source_by_employers")
 * @ORM\Entity
 */
class SourceByEmployers
{
    /**
     * @var string
     *
     * @ORM\Column(name="source_id", type="string", length=45, nullable=false)
     */
    private $sourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="employer_id", type="string", length=45, nullable=false)
     */
    private $employerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set sourceId
     *
     * @param string $sourceId
     *
     * @return SourceByEmployers
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Get sourceId
     *
     * @return string
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Set employerId
     *
     * @param string $employerId
     *
     * @return SourceByEmployers
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;

        return $this;
    }

    /**
     * Get employerId
     *
     * @return string
     */
    public function getEmployerId()
    {
        return $this->employerId;
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
