<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Counties
 *
 * @ORM\Table(name="counties")
 * @ORM\Entity
 */
class Counties
{
    /**
     * @var string
     *
     * @ORM\Column(name="county", type="string", length=155, nullable=false)
     */
    private $county;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set county
     *
     * @param string $county
     *
     * @return Counties
     */
    public function setCounty($county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
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
