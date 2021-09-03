<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TermsFiles
 *
 * @ORM\Table(name="terms_files")
 * @ORM\Entity
 */
class TermsFiles
{
    /**
     * @var integer
     *
     * @ORM\Column(name="terms_id", type="integer", nullable=false)
     */
    private $termsId;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="friendlyname", type="string", length=255, nullable=false)
     */
    private $friendlyname;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set termsId
     *
     * @param integer $termsId
     *
     * @return TermsFiles
     */
    public function setTermsId($termsId)
    {
        $this->termsId = $termsId;

        return $this;
    }

    /**
     * Get termsId
     *
     * @return integer
     */
    public function getTermsId()
    {
        return $this->termsId;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return TermsFiles
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set friendlyname
     *
     * @param string $friendlyname
     *
     * @return TermsFiles
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
