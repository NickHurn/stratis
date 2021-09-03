<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailVerification
 *
 * @ORM\Table(name="email_verification")
 * @ORM\Entity
 */
class EmailVerification
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=32, nullable=false)
     */
    private $code;

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmed", type="boolean", nullable=true)
     */
    private $confirmed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="issue_date", type="datetime", nullable=false)
     */
    private $issueDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="confirm_date", type="datetime", nullable=true)
     */
    private $confirmDate;
    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=150)
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

    public function __construct() {
        $this->issueDate = new \DateTime('now');
    }



    /**
     * Set code
     *
     * @param string $code
     *
     * @return EmailVerification
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set confirmed
     *
     * @param boolean $confirmed
     *
     * @return EmailVerification
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
     * Set issueDate
     *
     * @param \DateTime $issueDate
     *
     * @return EmailVerification
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    /**
     * Get issueDate
     *
     * @return \DateTime
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * Set confirmDate
     *
     * @param \DateTime $confirmDate
     *
     * @return EmailVerification
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
     * Set id
     *
     * @param integer $id
     *
     * @return EmailVerification
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

    /**
     * Set email
     *
     * @param string $email
     *
     * @return EmailVerification
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
}
