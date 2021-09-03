<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GbgImageResponse
 *
 * @ORM\Table(name="gbg_image_response")
 * @ORM\Entity
 */
class GbgImageResponse
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
     * @ORM\Column(name="response", type="text", length=65535, nullable=false)
     */
    private $response;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * @var string
     *
     * @ORM\Column(name="authenticated", type="string", length=25, nullable=true)
     */
    private $authenticated;

    /**
     * @var string
     *
     * @ORM\Column(name="extracted_data", type="text", length=65535, nullable=true)
     */
    private $extractedData;

    /**
     * @var string
     *
     * @ORM\Column(name="document_type", type="string", length=45, nullable=true)
     */
    private $documentType;

    /**
     * @var string
     *
     * @ORM\Column(name="document_number", type="string", length=45, nullable=true)
     */
    private $documentNumber;

    public function __construct() {
        $this->createdOn = new \DateTime('now');
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set checkId
     *
     * @param string $checkId
     *
     * @return GbgImageResponse
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
     * Set response
     *
     * @param string $response
     *
     * @return GbgImageResponse
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return GbgImageResponse
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
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return GbgImageResponse
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
     * Set authenticated
     *
     * @param string $authenticated
     *
     * @return GbgImageResponse
     */
    public function setAuthenticated($authenticated)
    {
        $this->authenticated = $authenticated;

        return $this;
    }

    /**
     * Get authenticated
     *
     * @return string
     */
    public function getAuthenticated()
    {
        return $this->authenticated;
    }

    /**
     * Set extractedData
     *
     * @param string $extractedData
     *
     * @return GbgImageResponse
     */
    public function setExtractedData($extractedData)
    {
        $this->extractedData = $extractedData;

        return $this;
    }

    /**
     * Get extractedData
     *
     * @return string
     */
    public function getExtractedData()
    {
        return $this->extractedData;
    }

    /**
     * Set documentType
     *
     * @param string $documentType
     *
     * @return GbgImageResponse
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;

        return $this;
    }

    /**
     * Get documentType
     *
     * @return string
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * Set documentNumber
     *
     * @param string $documentNumber
     *
     * @return GbgImageResponse
     */
    public function setDocumentNumber($documentNumber)
    {
        $this->documentNumber = $documentNumber;

        return $this;
    }

    /**
     * Get documentNumber
     *
     * @return string
     */
    public function getDocumentNumber()
    {
        return $this->documentNumber;
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
