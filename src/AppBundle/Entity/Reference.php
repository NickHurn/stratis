<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reference
 *
 * @ORM\Table(name="reference")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ReferenceRepository")
 */
class Reference
{
    /**
     * @var string
     *
     * @ORM\Column(name="reference_request_id", type="string", length=36, nullable=false)
     */
    private $referenceRequestId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=155, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=155, nullable=false)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=155, nullable=false)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set referenceRequestId
     *
     * @param string $referenceRequestId
     *
     * @return Reference
     */
    public function setReferenceRequestId($referenceRequestId)
    {
        $this->referenceRequestId = $referenceRequestId;

        return $this;
    }

    /**
     * Get referenceRequestId
     *
     * @return string
     */
    public function getReferenceRequestId()
    {
        return $this->referenceRequestId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Reference
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Reference
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Reference
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
