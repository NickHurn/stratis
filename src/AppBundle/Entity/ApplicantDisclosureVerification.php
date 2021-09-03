<?php

namespace AppBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Address
 *
 * @ORM\Table(name="applicant_disclosure_verification")
 * @ORM\Entity
 */
class ApplicantDisclosureVerification
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ApplicantDisclosures", inversedBy="verification")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     */
    private $application;

    /**
     * @var string
     * @ORM\Column(name="driving_Licence_number", type="string", length=35, nullable=true)
     */
    private $drivingLicenceNumber;

    /**
     * @var \DateTime
     * @ORM\Column(name="driving_Licence_dob", type="datetime", nullable=true)
     */
    private $drivingLicenceDob;

    /**
     * @var string
     * @ORM\Column(name="driving_Licence_country", type="string", length=3, nullable=true)
     */
    private $drivingLicenceCountry;

    /**
     * @var \DateTime
     * @ORM\Column(name="driving_Licence_issue", type="datetime", nullable=true)
     */
    private $drivingLicenceIssue;

    /**
     * @var \DateTime
     * @ORM\Column(name="driving_Licence_start", type="datetime", nullable=true)
     */
    private $drivingLicenceStart;

    /**
     * @var string
     * @ORM\Column(name="passport_number", type="string", length=35, nullable=true)
     * @Assert\Length(
     *      min = 5,
     *      max = 11,
     *      minMessage = "Your passport number must be at least {{ limit }} characters long",
     *      maxMessage = "Your passport number cannot be longer than {{ limit }} characters"
     * )
     */
    private $passportNumber;

    /**
     * @var \DateTime
     * @ORM\Column(name="passport_dob", type="datetime", nullable=true)
     */
    private $passportDob;

    /**
     * @var \DateTime
     * @ORM\Column(name="passport_issue", type="datetime", nullable=true)
     */
    private $passportIssue;

    /**
     * @var string
     * @ORM\Column(name="passport_nationality", type="string", length=33, nullable=true)
     */
    private $passportNationality;

    /**
     * @var \DateTime
     * @ORM\Column(name="birth_certificate_issue", type="datetime", nullable=true)
     */
    private $birthCertificateIssue;
    /**
     * @var \DateTime
     * @ORM\Column(name="birth_dob", type="datetime", nullable=true)
     */
    private $birthDob;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @var integer
     * @ORM\Column(name="created_by", type="integer", nullable=true)
     */
    private $createdBy;

    /**
     * @var integer
     * @ORM\Column(name="agree_address", type="integer", nullable=true)
     */
    private $agreeAddress;

    /**
     * @var integer
     * @ORM\Column(name="agree_dob", type="integer", nullable=true)
     */
    private $agreeDob;

    /**
     * @var integer
     * @ORM\Column(name="agree_names", type="integer", nullable=true)
     */
    private $agreeName;

    public function __construct()
    {
        $this->createdOn = new \DateTime('now');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ApplicantDisclosureVerification
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ApplicantDisclosures
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param mixed $application
     * @return ApplicantDisclosureVerification
     */
    public function setApplication($application)
    {
        $this->application = $application;
        return $this;
    }



    /**
     * @return string
     */
    public function getDrivingLicenceNumber()
    {
        return $this->drivingLicenceNumber;
    }

    /**
     * @param string $drivingLicenceNumber
     * @return ApplicantDisclosureVerification
     */
    public function setDrivingLicenceNumber($drivingLicenceNumber)
    {
        $this->drivingLicenceNumber = $drivingLicenceNumber;
        return $this;
    }

    /**
     * @return \DateTime|string
     * @param $formatted Boolean
     */
    public function getDrivingLicenceDob($formatted = false)
    {
        if($formatted === true){
            if($this->drivingLicenceDob instanceof \DateTime){
                return $this->drivingLicenceDob->format('c');
            }
        }
        return $this->drivingLicenceDob;
    }

    /**
     * @param \DateTime $drivingLicenceDob
     * @return ApplicantDisclosureVerification
     */
    public function setDrivingLicenceDob($drivingLicenceDob)
    {
        $this->drivingLicenceDob = $drivingLicenceDob;
        return $this;
    }

    /**
     * @return string
     */
    public function getDrivingLicenceCountry()
    {
        return $this->drivingLicenceCountry;
    }

    /**
     * @param string $drivingLicenceCountry
     * @return ApplicantDisclosureVerification
     */
    public function setDrivingLicenceCountry($drivingLicenceCountry)
    {
        $this->drivingLicenceCountry = $drivingLicenceCountry;
        return $this;
    }

    /**
     * @return \DateTime|string
     * @param $formatted boolean
     */
    public function getDrivingLicenceIssue($formatted = false)
    {
        if($formatted === true){
            if($this->drivingLicenceIssue instanceof \DateTime){
                return $this->drivingLicenceIssue->format('c');
            }
        }
        return $this->drivingLicenceIssue;
    }

    /**
     * @param \DateTime $drivingLicenceIssue
     * @return ApplicantDisclosureVerification
     */
    public function setDrivingLicenceIssue($drivingLicenceIssue)
    {
        $this->drivingLicenceIssue = $drivingLicenceIssue;
        return $this;
    }

    /**
     * @return \DateTime|string
     * @param $formatted boolean
     */
    public function getDrivingLicenceStart($formatted = false)
    {
        if($formatted === true){
            if($this->drivingLicenceStart instanceof \DateTime){
                return $this->drivingLicenceStart->format('c');
            }
        }
        return $this->drivingLicenceStart;
    }

    /**
     * @param \DateTime $drivingLicenceStart
     * @return ApplicantDisclosureVerification
     */
    public function setDrivingLicenceStart($drivingLicenceStart)
    {
        $this->drivingLicenceStart = $drivingLicenceStart;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassportNumber()
    {
        return $this->passportNumber;
    }

    /**
     * @param string $passportNumber
     * @return ApplicantDisclosureVerification
     */
    public function setPassportNumber($passportNumber)
    {
        $this->passportNumber = $passportNumber;
        return $this;
    }

    /**
     * @return \DateTime|string
     * @param $formatted Boolean
     */
    public function getPassportDob($formatted = false)
    {
        if($formatted === true){
            if($this->passportDob instanceof \DateTime){
                return $this->passportDob->format('c');
            }
        }
        return $this->passportDob;
    }

    /**
     * @param \DateTime $passportDob
     * @return ApplicantDisclosureVerification
     */
    public function setPassportDob($passportDob)
    {
        $this->passportDob = $passportDob;
        return $this;
    }

    /**
     * @return \DateTime|string
     * @param $formatted Boolean
     */
    public function getPassportIssue($formatted = false)
    {
        if($formatted === true){
            if($this->passportIssue instanceof \DateTime){
                return $this->passportIssue->format('c');
            }
        }
        return $this->passportIssue;
    }

    /**
     * @param \DateTime $passportIssue
     * @return ApplicantDisclosureVerification
     */
    public function setPassportIssue($passportIssue)
    {
        $this->passportIssue = $passportIssue;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassportNationality()
    {
        return $this->passportNationality;
    }

    /**
     * @param string $passportNationality
     * @return ApplicantDisclosureVerification
     */
    public function setPassportNationality($passportNationality)
    {
        $this->passportNationality = $passportNationality;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param string $createdOn
     * @return ApplicantDisclosureVerification
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy
     * @return ApplicantDisclosureVerification
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAgreeAddress()
    {
        return (bool) $this->agreeAddress;
    }

    /**
     * @param int $agreeAddress
     * @return ApplicantDisclosureVerification
     */
    public function setAgreeAddress($agreeAddress)
    {
        $this->agreeAddress = $agreeAddress;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAgreeDob()
    {
        return (bool) $this->agreeDob;
    }

    /**
     * @param int $agreeDob
     * @return ApplicantDisclosureVerification
     */
    public function setAgreeDob($agreeDob)
    {
        $this->agreeDob = $agreeDob;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAgreeName()
    {
        return (bool) $this->agreeName;
    }

    /**
     * @param int $agreeName
     * @return ApplicantDisclosureVerification
     */
    public function setAgreeName($agreeName)
    {
        $this->agreeName = $agreeName;
        return $this;
    }

    /**
     * @return \DateTime|string
     * @param $formatted Boolean
     */
    public function getBirthCertificateIssue($formatted = false)
    {
        if($formatted === true){
            if($this->birthCertificateIssue instanceof \DateTime){
                return $this->birthCertificateIssue->format('c');
            }
        }
        return $this->birthCertificateIssue;
    }

    /**
     * @param \DateTime $birthCertificateIssue
     * @return ApplicantDisclosureVerification
     */
    public function setBirthCertificateIssue($birthCertificateIssue)
    {
        $this->birthCertificateIssue = $birthCertificateIssue;
        return $this;
    }

    /**
     * @return \DateTime|string
     * @param $formatted Boolean
     */
    public function getBirthDob($formatted = false)
    {
        if($formatted === true){
            if($this->birthDob instanceof \DateTime){
                return $this->birthDob->format('c');
            }
        }
        return $this->birthDob;
    }

    /**
     * @param \DateTime $birthDob
     * @return ApplicantDisclosureVerification
     */
    public function setBirthDob($birthDob)
    {
        $this->birthDob = $birthDob;
        return $this;
    }

    public function getChecker(ObjectManager $em)
    {
		return $em->getRepository('AppBundle:Users')->findOneBy(['id'=>1]);
		// TODO
		//   return $em->getRepository('AppBundle:CombinedUser')->find($this->getApplication()->getEmployeeId());

    }

    public function getDataForSubmission(ObjectManager $em, $position, $product, $user)
    {

        $dl = [];
        $ps = [];
        $bc = [];

        $baseData = [
            'ClientId' => $this->getApplication()->getCode(),
            'IdentityVerified' => true,
            'EvidenceCheckedBy' => str_replace('-', '', $this->getChecker($em)->getName()),
            'EvidenceCheckedDateTime' => $this->getCreatedOn()->format('c'),
            'Position' => $position,
            'Product' => $product,
            'DBSChildrensBarredList' => false,
            'DBSAdultsBarredList' => false,
            'DBSAdultFirst' => false,
            'Volunteer' => false,
            'Payment' => 'Invoiced'
        ];

        if($product == 'Enhanced'){
            $baseData['workforce'] = 'Adult';
        }

        if(strlen($this->getDrivingLicenceNumber()) > 0){
            $dl = [
                'DrivingLicenceNumber' => $this->getDrivingLicenceNumber(),
                'DrivingLicenceDOB' => $this->getDrivingLicenceDob(true),
                'DrivingLicenceValidFromDate' => $this->getDrivingLicenceIssue(true),
                'DrivingLicenceCountry' => $this->getDrivingLicenceCountry(),
                'DrivingLicenceType' => 'Photo',
            ];
        }

        if(strlen($this->getPassportNumber()) > 0){
            $ps = [
                'PassportDateOfIssue' => $this->getPassportIssue(true),
                'PassportNumber' => $this->getPassportNumber(),
                'PassportDOB' => $this->getPassportDob(true),
                'PassportNationality' => $this->getPassportNationality(),
                ];
        }

        if(!is_null($this->getBirthDob())){
            $bc = [
                'BirthCertificateDateOfIssue' => $this->getBirthCertificateIssue(true),
                'BirthCertificateDOB' => $this->getBirthDob(true),
            ];
        }

        $dec = [
            'VerifierDeclaration1' => $this->getAgreeAddress(),
            'VerifierDeclaration2' => $this->getAgreeDob(),
            'VerifierDeclaration3' => $this->getAgreeName(),
        ];

        return $baseData+$dl+$ps+$bc+$dec;

    }



}
