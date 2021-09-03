<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="passport_data")
 * @ORM\Entity
 */
class PassportData
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
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;
    
	/**
     * @ORM\Column(name="job_code", type="string", nullable=false)
     */
    private $jobCode;

	/**
     * @ORM\Column(name="firstname", type="string", nullable=true)
     */
    private $firstname;

	/**
     * @ORM\Column(name="middlename", type="string", nullable=true)
     */
    private $middlename;

	/**
     * @ORM\Column(name="surname", type="string", nullable=true)
     */
    private $surname;
	
	/**
     * @ORM\Column(name="gender", type="string", nullable=true)
     */
    private $gender;
	
	/**
     * @ORM\Column(name="dob", type="string", nullable=true)
     */
    private $dob;
	
	/**
     * @ORM\Column(name="nationality", type="string", nullable=true)
     */
    private $nationality;

	/**
     * @ORM\Column(name="issue_date", type="string", nullable=true)
     */
    private $issueDate;
	
	/**
     * @ORM\Column(name="expiry_date", type="string", nullable=true)
     */
    private $expiryDate;
	
	/**
     * @ORM\Column(name="mrz", type="string", nullable=true)
     */
    private $mrz;

	/**
     * @ORM\Column(name="document_number", type="string", nullable=true)
     */
    private $documentNumber;

	/**
     * @ORM\Column(name="country", type="string", nullable=true)
     */
    private $country;

	/**
     * @ORM\Column(name="authenticity", type="string", nullable=true)
     */
    private $authenticity;

	/**
     * @ORM\Column(name="testinfo", type="text", nullable=true)
     */
    private $testinfo;

	/**
     * @ORM\Column(name="response", type="text", nullable=true)
     */
    private $response;
	
    /**
     * @ORM\Column(name="date_scanned", type="datetime", nullable=false)
     */
    private $dateScanned;


	
	/**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PassportData
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


	/**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $id
     * @return PassportData
     */
    public function setUserId($id)
    {
        $this->userId = $id;
        return $this;
    }

	
	/**
     * @return string
     */
    public function getJobCode()
    {
        return $this->jobCode;
    }

    /**
     * @param string $jobCode
     * @return PassportData
     */
    public function setJobCode($jobCode)
    {
        $this->jobCode = $jobCode;
        return $this;
    }


	/**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return PassportData
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }


	/**
     * @return string
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * @param string $middlename
     * @return DrivingData
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;
        return $this;
    }


	/**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return PassportData
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }


	/**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return PassportData
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }


	/**
     * @return string
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param string $dob
     * @return PassportData
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
        return $this;
    }

	
	/**
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     * @return PassportData
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
        return $this;
    }

	
	/**
     * @return string
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * @param string $issueDate
     * @return PassportData
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;
        return $this;
    }
	
	
	/**
     * @return string
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @param string $expiryDate
     * @return PassportData
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }


	/**
     * @return string
     */
    public function getMrz()
    {
        return $this->mrz;
    }

    /**
     * @param string $mrz
     * @return PassportData
     */
    public function setMrz($mrz)
    {
        $this->mrz = $mrz;
        return $this;
    }


	/**
     * @return string
     */
    public function getDocumentNumber()
    {
        return $this->documentNumber;
    }

    /**
     * @param string $documentNumber
     * @return PassportData
     */
    public function setDocumentNumber($dn)
    {
        $this->documentNumber = $dn;
        return $this;
    }


	/**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return PassportData
     */
    public function setCountry($c)
    {
        $this->country = $c;
        return $this;
    }


	/**
     * @return string
     */
    public function getAuthenticity()
    {
        return $this->authenticity;
    }

    /**
     * @param string $country
     * @return PassportData
     */
    public function setAuthenticity($a)
    {
        $this->authenticity = $a;
        return $this;
    }

	
	/**
     * @return string
     */
    public function getTestinfo()
    {
        return $this->testinfo;
    }

    /**
     * @param string $country
     * @return PassportData
     */
    public function setTestinfo($t)
    {
        $this->testinfo = $t;
        return $this;
    }


	/**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param string $response
     * @return PassportData
     */
    public function setResponse($r)
    {
        $this->response = $r;
        return $this;
    }


	/**
     * @return string
     */
    public function getDateScanned()
    {
        return $this->dateScanned;
    }

    /**
     * @param string $dateScanned
     * @return PassportData
     */
    public function setDateScanned($dt)
    {
        $this->dateScanned = $dt;
        return $this;
    }
}
