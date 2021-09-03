<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoriesDefaults
 *
 * @ORM\Table(name="histories_defaults")
 * @ORM\Entity
 */
class HistoriesDefaults
{
    /**
     * @var integer
     *
     * @ORM\Column(name="employment", type="integer", nullable=false)
     */
    private $employment;

    /**
     * @var integer
     *
     * @ORM\Column(name="education", type="integer", nullable=false)
     */
    private $education;

    /**
     * @var integer
     * @ORM\Column(name="employer_id", type="integer")
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
     * Set employment
     *
     * @param integer $employment
     *
     * @return HistoriesDefaults
     */
    public function setEmployment($employment)
    {
        $this->employment = $employment;

        return $this;
    }

    /**
     * Get employment
     *
     * @return integer
     */
    public function getEmployment()
    {
        return $this->employment;
    }

    /**
     * Set education
     *
     * @param integer $education
     *
     * @return HistoriesDefaults
     */
    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return integer
     */
    public function getEducation()
    {
        return $this->education;
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}
