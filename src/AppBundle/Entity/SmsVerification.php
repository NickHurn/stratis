<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SmsVerification
 *
 * @ORM\Table(name="sms_verification")
 * @ORM\Entity
 */
class SmsVerification
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
     *
     * @ORM\Column(name="status", type="string", length=55, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="msgid", type="string", length=65, nullable=true)
     */
    private $msgid;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=150)
     */
    private $mobile;


    public function __construct() {
        $this->issueDate = new \DateTime('now');
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return SmsVerification
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
     * @return SmsVerification
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
     * @return SmsVerification
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
     * @return SmsVerification
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
     * Set status
     *
     * @param string $status
     *
     * @return SmsVerification
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set msgid
     *
     * @param string $msgid
     *
     * @return SmsVerification
     */
    public function setMsgid($msgid)
    {
        $this->msgid = $msgid;

        return $this;
    }

    /**
     * Get msgid
     *
     * @return string
     */
    public function getMsgid()
    {
        return $this->msgid;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return SmsVerification
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
     * Set mobile
     *
     * @param string $mobile
     *
     * @return SmsVerification
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }
}
