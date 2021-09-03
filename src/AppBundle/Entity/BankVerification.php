<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankVerification
 *
 * @ORM\Table(name="bank_verification")
 * @ORM\Entity
 */
class BankVerification
{
    public function __construct() {
        $this->confirmDate = new \DateTime('now');
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmed", type="boolean", nullable=false)
     */
    private $confirmed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="confirm_date", type="datetime", nullable=false )
     */
    private $confirmDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set confirmed
     *
     * @param boolean $confirmed
     *
     * @return BankVerification
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * Get confirmed
     *
     * @return boolean
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Set confirmDate
     *
     * @param \DateTime $confirmDate
     *
     * @return BankVerification
     */
    public function setConfirmDate($confirmDate)
    {
        $this->confirmDate = $confirmDate;

        return $this;
    }

    /**
     * Get confirmDate
     *
     * @return \DateTime
     */
    public function getConfirmDate()
    {
        return $this->confirmDate;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return BankVerification
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
