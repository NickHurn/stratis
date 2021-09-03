<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CheckedDetails
 *
 * @ORM\Table(name="checked_details")
 * @ORM\Entity
 */
class CheckedDetails
{
    /**
     * @var integer
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="jobId", type="string", length=45, nullable=false)
     */
    private $jobid;

    /**
     * @var string
     *
     * @ORM\Column(name="uniqueId", type="string", length=45, nullable=false)
     */
    private $uniqueid;

    /**
     * @var string
     *
     * @ORM\Column(name="forename", type="string", length=45, nullable=false)
     */
    private $forename;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=45, nullable=false)
     */
    private $surname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="date", nullable=false)
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="line1", type="string", length=45, nullable=false)
     */
    private $line1;

    /**
     * @var string
     *
     * @ORM\Column(name="line2", type="string", length=45, nullable=false)
     */
    private $line2;

    /**
     * @var string
     *
     * @ORM\Column(name="line3", type="string", length=45, nullable=false)
     */
    private $line3;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=45, nullable=false)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=45, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="dlNo", type="string", length=44, nullable=true)
     */
    private $dlno;

    /**
     * @var string
     *
     * @ORM\Column(name="passportNo", type="string", length=2555, nullable=true)
     */
    private $passportno;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateExp", type="date", nullable=true)
     */
    private $dateexp;

    /**
     * @var string
     *
     * @ORM\Column(name="ppOrigin", type="string", length=45, nullable=true)
     */
    private $pporigin;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set userid
     *
     * @param integer $userid
     *
     * @return CheckedDetails
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set jobid
     *
     * @param string $jobid
     *
     * @return CheckedDetails
     */
    public function setJobid($jobid)
    {
        $this->jobid = $jobid;

        return $this;
    }

    /**
     * Get jobid
     *
     * @return string
     */
    public function getJobid()
    {
        return $this->jobid;
    }

    /**
     * Set uniqueid
     *
     * @param string $uniqueid
     *
     * @return CheckedDetails
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
     * Set forename
     *
     * @param string $forename
     *
     * @return CheckedDetails
     */
    public function setForename($forename)
    {
        $this->forename = $forename;

        return $this;
    }

    /**
     * Get forename
     *
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return CheckedDetails
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return CheckedDetails
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set line1
     *
     * @param string $line1
     *
     * @return CheckedDetails
     */
    public function setLine1($line1)
    {
        $this->line1 = $line1;

        return $this;
    }

    /**
     * Get line1
     *
     * @return string
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * Set line2
     *
     * @param string $line2
     *
     * @return CheckedDetails
     */
    public function setLine2($line2)
    {
        $this->line2 = $line2;

        return $this;
    }

    /**
     * Get line2
     *
     * @return string
     */
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * Set line3
     *
     * @param string $line3
     *
     * @return CheckedDetails
     */
    public function setLine3($line3)
    {
        $this->line3 = $line3;

        return $this;
    }

    /**
     * Get line3
     *
     * @return string
     */
    public function getLine3()
    {
        return $this->line3;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return CheckedDetails
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set county
     *
     * @param string $county
     *
     * @return CheckedDetails
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
     * Set postcode
     *
     * @param string $postcode
     *
     * @return CheckedDetails
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return CheckedDetails
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set dlno
     *
     * @param string $dlno
     *
     * @return CheckedDetails
     */
    public function setDlno($dlno)
    {
        $this->dlno = $dlno;

        return $this;
    }

    /**
     * Get dlno
     *
     * @return string
     */
    public function getDlno()
    {
        return $this->dlno;
    }

    /**
     * Set passportno
     *
     * @param string $passportno
     *
     * @return CheckedDetails
     */
    public function setPassportno($passportno)
    {
        $this->passportno = $passportno;

        return $this;
    }

    /**
     * Get passportno
     *
     * @return string
     */
    public function getPassportno()
    {
        return $this->passportno;
    }

    /**
     * Set dateexp
     *
     * @param \DateTime $dateexp
     *
     * @return CheckedDetails
     */
    public function setDateexp($dateexp)
    {
        $this->dateexp = $dateexp;

        return $this;
    }

    /**
     * Get dateexp
     *
     * @return \DateTime
     */
    public function getDateexp()
    {
        return $this->dateexp;
    }

    /**
     * Set pporigin
     *
     * @param string $pporigin
     *
     * @return CheckedDetails
     */
    public function setPporigin($pporigin)
    {
        $this->pporigin = $pporigin;

        return $this;
    }

    /**
     * Get pporigin
     *
     * @return string
     */
    public function getPporigin()
    {
        return $this->pporigin;
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
