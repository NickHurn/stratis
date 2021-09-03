<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Checks
 *
 * @ORM\Table(name="checks")
 * @ORM\Entity
 */
class Checks
{
    /**
     * @var string
     *
     * @ORM\Column(name="checkname", type="string", length=45, nullable=false)
     */
    private $checkname;

    /**
     * @var integer
     *
     * @ORM\Column(name="standard", type="integer", nullable=false)
     */
    private $standard;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set checkname
     *
     * @param string $checkname
     *
     * @return Checks
     */
    public function setCheckname($checkname)
    {
        $this->checkname = $checkname;

        return $this;
    }

    /**
     * Get checkname
     *
     * @return string
     */
    public function getCheckname()
    {
        return $this->checkname;
    }

    /**
     * Set standard
     *
     * @param integer $standard
     *
     * @return Checks
     */
    public function setStandard($standard)
    {
        $this->standard = $standard;

        return $this;
    }

    /**
     * Get standard
     *
     * @return integer
     */
    public function getStandard()
    {
        return $this->standard;
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
