<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IdCheckFiles
 *
 * @ORM\Table(name="id_check_files")
 * @ORM\Entity
 */
class IdCheckFiles
{
    /**
     * @var string
     *
     * @ORM\Column(name="uniqueId", type="string", length=45, nullable=false)
     */
    private $uniqueid;

    /**
     * @var string
     *
     * @ORM\Column(name="friendlyName", type="string", length=45, nullable=false)
     */
    private $friendlyname;

    /**
     * @var string
     *
     * @ORM\Column(name="storedName", type="string", length=45, nullable=false)
     */
    private $storedname;

    /**
     * @var string
     *
     * @ORM\Column(name="mimeType", type="string", length=45, nullable=false)
     */
    private $mimetype;

    /**
     * @var string
     *
     * @ORM\Column(name="docType", type="string", length=45, nullable=false)
     */
    private $doctype;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateStored", type="date", nullable=false)
     */
    private $datestored;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set uniqueid
     *
     * @param string $uniqueid
     *
     * @return IdCheckFiles
     */
    public function setUniqueid($uniqueid)
    {
        $this->uniqueid = $uniqueid;

        return $this;
    }

    /**
     * Get uniqueid
     *
     * @return string
     */
    public function getUniqueid()
    {
        return $this->uniqueid;
    }

    /**
     * Set friendlyname
     *
     * @param string $friendlyname
     *
     * @return IdCheckFiles
     */
    public function setFriendlyname($friendlyname)
    {
        $this->friendlyname = $friendlyname;

        return $this;
    }

    /**
     * Get friendlyname
     *
     * @return string
     */
    public function getFriendlyname()
    {
        return $this->friendlyname;
    }

    /**
     * Set storedname
     *
     * @param string $storedname
     *
     * @return IdCheckFiles
     */
    public function setStoredname($storedname)
    {
        $this->storedname = $storedname;

        return $this;
    }

    /**
     * Get storedname
     *
     * @return string
     */
    public function getStoredname()
    {
        return $this->storedname;
    }

    /**
     * Set mimetype
     *
     * @param string $mimetype
     *
     * @return IdCheckFiles
     */
    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;

        return $this;
    }

    /**
     * Get mimetype
     *
     * @return string
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * Set doctype
     *
     * @param string $doctype
     *
     * @return IdCheckFiles
     */
    public function setDoctype($doctype)
    {
        $this->doctype = $doctype;

        return $this;
    }

    /**
     * Get doctype
     *
     * @return string
     */
    public function getDoctype()
    {
        return $this->doctype;
    }

    /**
     * Set datestored
     *
     * @param \DateTime $datestored
     *
     * @return IdCheckFiles
     */
    public function setDatestored($datestored)
    {
        $this->datestored = $datestored;

        return $this;
    }

    /**
     * Get datestored
     *
     * @return \DateTime
     */
    public function getDatestored()
    {
        return $this->datestored;
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
