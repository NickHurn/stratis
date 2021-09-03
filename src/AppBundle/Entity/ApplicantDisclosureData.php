<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

/**
 * Address
 *
 * @ORM\Table(name="applicant_disclosure_data", indexes={@ORM\Index(name="user1_idx", columns={"applicant_id"})})
 * @ORM\Entity
 */
class ApplicantDisclosureData
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
     * @var integer
     *
     * @ORM\Column(name="applicant_id", type="integer", nullable=false)
     */
    private $applicant_id;

	/**
     * @var string
     *
     * @ORM\Column(name="job_id", type="string", length=32, nullable=true)
     */
    private $job_id;

	/**
     * @var string
     *
     * @ORM\Column(name="applicant_data", type="text", length=65535, nullable=true)
     */
    private $applicant_data;

    /**
     * @ORM\Column(name="title", type="string", length=6)
     */
    private $Title;

    /**
     * @ORM\Column(name="firstname", type="string", length=30)
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $Firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=30)
     */
    private $Lastname;
    /**
     * @ORM\Column(name="middlename1", type="string", length=30, nullable=true)
     */
    private $Middlename1;
    /**
     * @ORM\Column(name="middlename2", type="string", length=30, nullable=true)
     */
    private $Middlename2;
    /**
     * @ORM\Column(name="middlename3", type="string", length=30, nullable=true)
     */
    private $Middlename3;

    /**
     * Many User have Many Names
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ApplicantPrevName", cascade={"persist"})
     * @ORM\JoinTable(name="applicantdata_applicantname",
     *      joinColumns={@ORM\JoinColumn(name="data_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="name_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $Names;

    /**
     * @ORM\Column(name="birth_surname", type="string", length=30, nullable=true)
     */
    private $BirthSurname;

    /**
     * @ORM\Column(name="birth_surname_until", type="integer", nullable=true)
     */
    private $BirthSurnameUntil;

    /**
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $BirthDate;
	
    /**
     * @ORM\Column(name="birth_town", type="string", length=30, nullable=true)
     */
    private $BirthTown;
	
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Counties")
     * @ORM\JoinColumn(name="birth_county", referencedColumnName="id")
     */
    private $BirthCounty;

    /**
     * @ORM\Column(name="birth_country", type="string", length=2)
     */
    private $BirthCountry;
	
	/**
     * @ORM\Column(name="nationality", type="string", length=30)
     */
    private $Nationality;
	
	/**
     * @ORM\Column(name="mothers_maiden_name", type="string", length=30)
     */
    private $MothersMaidenName;

	/**
     * @ORM\Column(name="phone_number", type="string", length=30)
     */
    private $PhoneNumber;

	/**
     * @ORM\Column(name="address_line_1", type="string", length=30)
     */
    private $AddressLine1;

    /**
     * @ORM\Column(name="address_line_2", type="string", length=30, nullable=true)
     */
    private $AddressLine2;

    /**
     * @ORM\Column(name="address_towncity", type="string", length=30)
     */
    private $AddressTownCity;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Counties")
     * @ORM\JoinColumn(name="address_county", referencedColumnName="id", nullable=true)
     */
    private $AddressCounty;

    /**
     * @ORM\Column(name="address_country", type="string", length=2)
     */
    private $AddressCountry;

    /**
     * @ORM\Column(name="address_postcode", type="string", length=10)
     */
    private $AddressPostcode;

    /**
     * @ORM\Column(name="address_start_date", type="date", nullable=true)
     */
    private $AddressStartDate;
	
    /**
     * @ORM\Column(name="has_convictions", type="integer", nullable=true)
     */
    private $HasConvictions;

	/**
     * @ORM\Column(name="ni_number", type="string", length=20, nullable=true)
     */
    private $NINumber;

	/**
     * @ORM\Column(name="dl_number", type="string", length=30, nullable=true)
     */
    private $DLNumber;

	/**
     * @ORM\Column(name="dl_country", type="string", length=2, nullable=true)
     */
    private $DLCountry;

	/**
     * @ORM\Column(name="passport_number", type="string", length=30, nullable=true)
     */
    private $PassportNumber;

	/**
     * @ORM\Column(name="passport_country", type="string", length=2, nullable=true)
     */
    private $PassportCountry;
	
	/**
     * @ORM\Column(name="idcard_number", type="string", length=30, nullable=true)
     */
    private $IDCardNumber;

	/**
     * @ORM\Column(name="idcard_country", type="string", length=2, nullable=true)
     */
    private $IDCardCountry;

	/**
     * @ORM\Column(name="applicant_declaration", type="integer", nullable=true)
     */
    private $ApplicantDeclaration;
	
	/**
     * User have Many PrevAddresses
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ApplicantPrevAddress", cascade={"persist"})
     * @ORM\JoinTable(name="applicantdata_applicantaddress",
     *      joinColumns={@ORM\JoinColumn(name="data_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="addr_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $Addresses;
	
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ApplicantDisclosureData
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getApplicantId()
    {
        return $this->applicant_id;
    }

    /**
     * @param int $applicant_id
     * @return ApplicantDisclosureData
     */
    public function setApplicantId($applicant_id)
    {
        $this->applicant_id = $applicant_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getJobId()
    {
        return $this->job_id;
    }

    /**
     * @param string $job_id
     * @return ApplicantDisclosureData
     */
    public function setJobId($job_id)
    {
        $this->job_id = $job_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getApplicantData()
    {
        return $this->applicant_data;
    }

    /**
     * @param string $applicant_data
     * @return ApplicantDisclosureData
     */
    public function setApplicantData($applicant_data)
    {
        $this->applicant_data = $applicant_data;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param mixed $Title
     * @return ApplicantDisclosureData
     */
    public function setTitle($Title)
    {
        $this->Title = $Title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->Firstname;
    }

    /**
     * @param mixed $Firstname
     * @return ApplicantDisclosureData
     */
    public function setFirstname($Firstname)
    {
        $this->Firstname = $Firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->Lastname;
    }

    /**
     * @param mixed $Lastname
     * @return ApplicantDisclosureData
     */
    public function setLastname($Lastname)
    {
        $this->Lastname = $Lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMiddlename1()
    {
        return $this->Middlename1;
    }

    /**
     * @param mixed $Middlename1
     * @return ApplicantDisclosureData
     */
    public function setMiddlename1($Middlename1)
    {
        $this->Middlename1 = $Middlename1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMiddlename2()
    {
        return $this->Middlename2;
    }

    /**
     * @param mixed $Middlename2
     * @return ApplicantDisclosureData
     */
    public function setMiddlename2($Middlename2)
    {
        $this->Middlename2 = $Middlename2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMiddlename3()
    {
        return $this->Middlename3;
    }

    /**
     * @param mixed $middlename3
     * @return ApplicantDisclosureData
     */
    public function setMiddlename3($middlename3)
    {
        $this->middlename3 = $middlename3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNames()
    {
        return $this->Names;
    }

    /**
     * @param mixed $Names
     * @return ApplicantDisclosureData
     */
    public function setNames($Names)
    {
        $this->Names = $Names;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthSurname()
    {
        return $this->BirthSurname;
    }

    /**
     * @param mixed $BirthSurname
     * @return ApplicantDisclosureData
     */
    public function setBirthSurname($BirthSurname)
    {
        $this->BirthSurname = $BirthSurname;
        return $this;
    }
	
    /**
     * @return mixed
     */
    public function getBirthSurnameUntil()
    {
        return $this->BirthSurnameUntil;
    }

    /**
     * @param mixed $BirthSurnameUntil
     * @return ApplicantDisclosureData
     */
    public function setBirthSurnameUntil($BirthSurnameUntil)
    {
        $this->BirthSurnameUntil = $BirthSurnameUntil;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->BirthDate;
    }

    /**
     * @param mixed $BirthDate
     * @return ApplicantDisclosureData
     */
    public function setBirthDate($BirthDate)
    {
        $this->BirthDate = $BirthDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthTown()
    {
        return $this->BirthTown;
    }

    /**
     * @param mixed $BirthTown
     * @return ApplicantDisclosureData
     */
    public function setBirthTown($BirthTown)
    {
        $this->BirthTown = $BirthTown;
        return $this;
    }

	/**
     * @return Counties
     */
    public function getBirthCounty()
    {
		$x = $this->BirthCounty;
        //var_dump($x->getCounty()); die("ab");
		return $x;
    }

    /**
     * @param Counties $BirthCounty
     * @return ApplicantDisclosureData
     */
    public function setBirthCounty($BirthCounty)
    {
        $this->BirthCounty = $BirthCounty;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getBirthCountry()
    {
		return 'GB';
        //return $this->BirthCountry;
    }

    /**
     * @param mixed $BirthCountry
     * @return ApplicantDisclosureData
     */
    public function setBirthCountry($BirthCountry)
    {
        $this->BirthCountry = $BirthCountry;
        return $this;
    }
	
	/**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->Nationality;
    }

    /**
     * @param mixed $Nationality
     * @return ApplicantDisclosureData
     */
    public function setNationality($Nationality)
    {
        $this->Nationality = $Nationality;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getMothersMaidenName()
    {
        return $this->MothersMaidenName;
    }

    /**
     * @param mixed $MothersMaidenName
     * @return ApplicantDisclosureData
     */
    public function setMothersMaidenName($MothersMaidenName)
    {
        $this->MothersMaidenName = $MothersMaidenName;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }

    /**
     * @param mixed $PhoneNumber
     * @return ApplicantDisclosureData
     */
    public function setPhoneNumber($PhoneNumber)
    {
        $this->PhoneNumber = $PhoneNumber;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getAddresses()
    {
        return $this->Addresses;
    }

    /**
     * @param mixed $Addresses
     * @return ApplicantDisclosureData
     */
    public function setAddresses($Addresses)
    {
        $this->Addresses = $Addresses;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressLine1()
    {
        return $this->AddressLine1;
    }

    /**
     * @param mixed $AddressLine1
     * @return ApplicantDisclosureData
     */
    public function setAddressLine1($AddressLine1)
    {
        $this->AddressLine1 = $AddressLine1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressLine2()
    {
        return $this->AddressLine2;
    }

    /**
     * @param mixed $AddressLine2
     * @return ApplicantDisclosureData
     */
    public function setAddressLine2($AddressLine2)
    {
        $this->AddressLine2 = $AddressLine2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressTownCity()
    {
        return $this->AddressTownCity;
    }

    /**
     * @param mixed $AddressTownCity
     * @return ApplicantDisclosureData
     */
    public function setAddressTownCity($AddressTownCity)
    {
        $this->AddressTownCity = $AddressTownCity;
        return $this;
    }

    /**
     * @return Counties
     */
    public function getAddressCounty()
    {
        return $this->AddressCounty;
    }

    /**
     * @param Counties $AddressCounty
     * @return ApplicantDisclosureData
     */
    public function setAddressCounty($AddressCounty)
    {
        $this->AddressCounty = $AddressCounty;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressCountry()
    {
        return $this->AddressCountry;
    }

    /**
     * @param mixed $AddressCountry
     * @return ApplicantDisclosureData
     */
    public function setAddressCountry($AddressCountry)
    {
        $this->AddressCountry = $AddressCountry;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressPostcode()
    {
        return $this->AddressPostcode;
    }

    /**
     * @param mixed $AddressPostcode
     * @return ApplicantDisclosureData
     */
    public function setAddressPostcode($AddressPostcode)
    {
        $this->AddressPostcode = $AddressPostcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressStartDate()
    {
        return $this->AddressStartDate;
    }

    /**
     * @param mixed $AddressStartDate
     * @return ApplicantDisclosureData
     */
    public function setAddressStartDate($AddressStartDate)
    {
        $this->AddressStartDate = $AddressStartDate;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getHasConvictions()
    {
        return (bool) $this->HasConvictions;
    }

    /**
     * @param int HasConvictions
     * @return ApplicantDisclosureData
     */
    public function setHasConvictions($HasConvictions)
    {
        $this->HasConvictions = $HasConvictions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNINumber()
    {
        return $this->NINumber;
    }

    /**
     * @param mixed NINumber
     * @return ApplicantDisclosureData
     */
    public function setNINumber($NINumber)
    {
        $this->NINumber = $NINumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDLNumber()
    {
        return $this->DLNumber;
    }

    /**
     * @param mixed DLNumber
     * @return ApplicantDisclosureData
     */
    public function setDLNumber($DLNumber)
    {
        $this->DLNumber = $DLNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDLCountry()
    {
        return $this->DLCountry;
    }

    /**
     * @param mixed DLCountry
     * @return ApplicantDisclosureData
     */
    public function setDLCountry($DLCountry)
    {
        $this->DLCountry = $DLCountry;
        return $this;
    }

	/**
     * @return mixed
     */
    public function getPassportNumber()
    {
        return $this->PassportNumber;
    }

    /**
     * @param mixed PassportNumber
     * @return ApplicantDisclosureData
     */
    public function setPassportNumber($PassportNumber)
    {
        $this->PassportNumber = $PassportNumber;
        return $this;
    }
	
    /**
     * @return mixed
     */
    public function getPassportCountry()
    {
        return $this->PassportCountry;
    }

    /**
     * @param mixed PassportCountry
     * @return ApplicantDisclosureData
     */
    public function setPassportCountry($PassportCountry)
    {
        $this->PassportCountry = $PassportCountry;
        return $this;
    }
	
    /**
     * @return mixed
     */
    public function getIDCardNumber()
    {
        return $this->IDCardNumber;
    }

    /**
     * @param mixed getIDCardNumber
     * @return ApplicantDisclosureData
     */
    public function setIDCardNumber($IDCardNumber)
    {
        $this->IDCardNumber = $IDCardNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIDCardCountry()
    {
        return $this->IDCardCountry;
    }

    /**
     * @param mixed getIDCardCountry
     * @return ApplicantDisclosureData
     */
    public function setIDCardCountry($IDCardCountry)
    {
        $this->IDCardCountry = $IDCardCountry;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getApplicantDeclaration()
    {
        return (bool) $this->ApplicantDeclaration;
    }

    /**
     * @param int ApplicantDeclaration
     * @return ApplicantDisclosureData
     */
    public function setApplicantDeclaration($ApplicantDeclaration)
    {
        $this->ApplicantDeclaration = $ApplicantDeclaration;
        return $this;
    }
	
    /**
     * @param string code
     * @return array
     */
	public function getDataForSubmission($code, $position)
    {
        $now = new \DateTime('now');
		$title = $this->getTitle();
		$male_titles = array('Mr','Duke','Father','Lord','Sir','Baron');
		$gender = (in_array($title, $male_titles)) ? 'Male':'Female';
		$HasNINumber = empty($this->NINumber) ? 'False':'True';
		$HasDLNumber = empty($this->DLNumber) ? 'False':'True';
		$HasPassport = empty($this->PassportNumber) ? 'False':'True';
		$HasNationalIDCard = empty($this->IDCardNumber) ? 'False':'True';
		
		$data = [
            'ClientReference' => $code,
            'Gender' => $gender,
            'Title' => $title,
            'FirstName' => $this->getFirstName(),
            'LastName' => $this->getLastName(),
            'BirthTown' => $this->getBirthTown(),
            'BirthCounty' => (is_null($this->getBirthCounty()) ? '' : $this->getBirthCounty()->getCounty()),
            'BirthCountry' => $this->getBirthCountry(),
            'BirthDate' => $this->getBirthDate()->modify('+12 hours')->format('c'),
            'BirthNationality' => $this->getNationality(),
            'MothersMaidenName' => $this->getMothersMaidenName(),
            'CurrentAddressLine1' => $this->getAddressLine1(),
            'CurrentAddressLine2' => $this->getAddressLine2(),
            'CurrentAddressTownCity' => $this->getAddressTownCity(),
            'CurrentAddressCounty' => (is_null($this->getAddressCounty()) ? '' : $this->getAddressCounty()->getCounty()),
            'CurrentAddressCountry' => $this->getAddressCountry(),
            'CurrentAddressPostcode' => $this->getAddressPostcode(),
			'CurrentAddressStartDate' => $this->getAddressStartDate()->format('d/m/Y'),
			'HasNINumber' => $HasNINumber,
			'NINumber' => strtoupper($this->getNINumber()),
			'HasDL' => $HasDLNumber,
			'DLNumber' => $this->getDLNumber(),
			'DLCountry' => $this->getDLCountry(),
			'HasPassport' => $HasPassport,
			'PassportNumber' => $this->getPassportNumber(),
			'PassportCountry' => $this->getPassportCountry(),
			'HasNationalIDCard' => $HasNationalIDCard,
			'IDCardNumber' => $this->getIDCardNumber(),
			'IDCardCountry' => $this->getIDCardCountry(),
			'Position'	=> $position,
			'HasConvictions' => $this->getHasConvictions(),
			'ApplicantDeclaration' => $this->getApplicantDeclaration(),
			'DeclarationOn' => $now->format('c'),
		];

		if($gender=='Female' and $title<>'Miss')
		{
			$data['BirthSurname'] = $this->getBirthSurname();
			$data['BirthSurnameUntil'] = $this->getBirthSurnameUntil();
		}
		
		$aa = $this->getAddresses();
		if(!empty($aa))
		{
			//$data['AdditionalAddresses'] = [];
            /**
             * @var $addr ApplicantPrevAddress
             */
			foreach($aa as $addr)
			{
				unset($a);
				$a['AdditionalAddressID'] = $addr->getId();
				$a['Line1'] = $addr->getLine1();
				$a['Line2'] = $addr->getLine2();
				$a['TownCity'] = $addr->getTownCity();
				$a['County'] = (is_null($addr->getCounty()) ? '' : $addr->getCounty()->getCounty());
				$a['Country'] = $addr->getCountry();
				$a['Postcode'] = $addr->getPostcode();
				$a['StartDate'] = $addr->getStartOn()->format('d/m/Y');
				$a['EndDate'] = $addr->getEndOn()->format('d/m/Y');
				$data['AdditionalAddresses'][] = $a;
			}
		}

		$na = $this->getNames();
		if(!empty($na))
		{
			foreach($na as $name)
			{
				unset($n);
				$n['PreviousNameID'] = $name->getId();
				$n['Name'] = $name->getName();
				$n['Type'] = $name->getType();
				$n['StartDate'] = $name->getStartDate();
				$n['EndDate'] = $name->getEndDate();
				$data['PreviousNames'][] = $n;
			}
		}
		return $data;
	}
}
