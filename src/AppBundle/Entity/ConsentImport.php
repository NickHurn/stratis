<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="consent_import")
 * @ORM\Entity()
 */
class ConsentImport
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="consent_file")
     * @Assert\NotBlank(message="Please, upload a consent file.")
     * @Assert\File(mimeTypes={ "application/pdf", "application/x-pdf", "text/plain"})
     */
    private $consentFile;

    /**
     * @var string
     * @ORM\Column(name="mime_type", type="string", length=150, nullable=true)
     */
    private $mimeType;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=150, nullable=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="qualification_id", type="integer", nullable=true)
     */
    private $qualificationId;


    private $token;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;


    public function __construct()
    {
        $this->createdOn = new \DateTime('now');
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
     * @return ConsentImport
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConsentFile()
    {
        return $this->consentFile;
    }

    /**
     * @param mixed $consentFile
     * @return ConsentImport
     */
    public function setConsentFile($consentFile)
    {
        $this->consentFile = $consentFile;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param \DateTime $createdOn
     * @return ConsentImport
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     * @return ConsentImport
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param \DateTime $mimeType
     * @return ConsentImport
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ConsentImport
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getQualificationId()
    {
        return $this->qualificationId;
    }

    /**
     * @param string $qualificationId
     * @return ConsentImport
     */
    public function setQualificationId($qualificationId)
    {
        $this->qualificationId = $qualificationId;
        return $this;
    }



}
