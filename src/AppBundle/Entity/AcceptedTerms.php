<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AcceptedTerms
 *
 * @ORM\Table(name="accepted_terms")
 * @ORM\Entity
 */
class AcceptedTerms
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="terms_id", type="integer", nullable=false)
     */
    private $termsId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accepted_on", type="datetime", nullable=false )
     */
    private $acceptedOn = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return AcceptedTerms
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set termsId
     *
     * @param integer $termsId
     *
     * @return AcceptedTerms
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
     * Set acceptedOn
     *
     * @param \DateTime $acceptedOn
     *
     * @return AcceptedTerms
     */
    public function setAcceptedOn($acceptedOn)
    {
        $this->acceptedOn = $acceptedOn;

        return $this;
    }

    /**
     * Get acceptedOn
     *
     * @return \DateTime
     */
    public function getAcceptedOn()
    {
        return $this->acceptedOn;
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
