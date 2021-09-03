<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="applicant_prev_address")
 * @ORM\Entity
 */
class ApplicantPrevAddress
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
     * @ORM\Column(name="line1", type="string", length=60)
     */
    private $Line1;

    /**
     * @ORM\Column(name="line2", type="string", length=60, nullable=true)
     */
    private $Line2;

    /**
     * @ORM\Column(name="town_city", type="string", length=60)
     */
    private $TownCity;
	
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Counties")
     * @ORM\JoinColumn(name="county", referencedColumnName="id")
     */
    private $County;
	
    /**
     * @ORM\Column(name="country", type="string", length=2)
     */
    private $Country;

	/**
     * @ORM\Column(name="postcode", type="string", length=10)
     */
    private $Postcode;

	/**
     * @ORM\Column(name="start_on", type="date", nullable=true)
     */
    private $StartOn;

	/**
     * @ORM\Column(name="end_on", type="date", nullable=true)
     */
    private $EndOn;
	
	
	/**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ApplicantPrevAddress
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getLine1()
    {
        return $this->Line1;
    }

    /**
     * @param mixed $Line1
     * @return ApplicantPrevAddress
     */
    public function setLine1($Line1)
    {
        $this->Line1 = $Line1;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getLine2()
    {
        return $this->Line2;
    }

    /**
     * @param mixed $Line2
     * @return ApplicantPrevAddress
     */
    public function setLine2($Line2)
    {
        $this->Line2 = $Line2;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getTownCity()
    {
        return $this->TownCity;
    }

    /**
     * @param mixed $TownCity
     * @return ApplicantPrevAddress
     */
    public function setTownCity($TownCity)
    {
        $this->TownCity = $TownCity;
        return $this;
    }

	/**
     * @return Counties
     */
    public function getCounty()
    {
        return $this->County;
    }

    /**
     * @param mixed $County
     * @return ApplicantPrevAddress
     */
    public function setCounty($County)
    {
        $this->County = $County;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     * @param mixed $Country
     * @return ApplicantPrevAddress
     */
    public function setCountry($Country)
    {
        $this->Country = $Country;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->Postcode;
    }

    /**
     * @param mixed $Postcode
     * @return ApplicantPrevAddress
     */
    public function setPostcode($Postcode)
    {
        $this->Postcode = $Postcode;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getStartOn()
    {
        return $this->StartOn;
    }

    /**
     * @param mixed $StartOn
     * @return ApplicantPrevAddress
     */
    public function setStartOn($StartOn)
    {
        $this->StartOn = $StartOn;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getEndOn()
    {
        return $this->EndOn;
    }

    /**
     * @param mixed $EndOn
     * @return ApplicantPrevAddress
     */
    public function setEndOn($EndOn)
    {
        $this->EndOn = $EndOn;
        return $this;
    }
}
