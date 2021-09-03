<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * combined_user
 *
 * @ORM\Table(name="combined_user")
 * @ORM\Entity(readOnly=true)
 */
class CombinedUser
{

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=254, nullable=true)
     */
    private $username;
    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=254, nullable=true)
     */
    private $password;
    /**
     * @var string
     * @ORM\Column(name="firstname", type="string", length=254, nullable=true)
     */
    private $firstname;
    /**
     * @var string
     * @ORM\Column(name="surname", type="string", length=254, nullable=true)
     */
    private $surname;
    /**
     * @var string
     * @ORM\Column(name="emailaddress", type="string", length=254, nullable=true)
     */
    private $emailaddress;
    /**
     * @var string
     * @ORM\Column(name="mobiletel", type="string", length=254, nullable=true)
     */
    private $mobiletel;
    /**
     * @var string
     * @ORM\Column(name="hometel", type="string", length=254, nullable=true)
     */
    private $hometel;
    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=254, nullable=true)
     */
    private $token;
    /**
     * @var string
     * @ORM\Column(name="expiry", type="string", length=254, nullable=true)
     */
    private $expiry;
    /**
     * @var string
     * @ORM\Column(name="temp_password", type="string", length=254, nullable=true)
     */
    private $tempPassword;
    /**
     * @var string
     * @ORM\Column(name="company", type="string", length=254, nullable=true)
     */
    private $company;
    /**
     * @var integer
     * @ORM\Column(name="employer_id", type="integer", nullable=true)
     */
    private $employerId;
    /**
     * @var integer
     * @ORM\Column(name="master_user_id", type="integer", nullable=true)
     */
    private $masterUserId;
    /**
     * @var integer
     * @ORM\Column(name="admin_id", type="integer", nullable=true)
     */
    private $adminId;
    /**
     * @var integer
     * @ORM\Column(name="userid", type="integer", nullable=true)
     */
    private $userid;
    /**
     * @var string
     * @ORM\Column(name="line1", type="string", length=254, nullable=true)
     */
    private $line1;
    /**
     * @var string
     * @ORM\Column(name="line2", type="string", length=254, nullable=true)
     */
    private $line2;
    /**
     * @var string
     * @ORM\Column(name="line3", type="string", length=254, nullable=true)
     */
    private $line3;
    /**
     * @var string
     * @ORM\Column(name="town", type="string", length=254, nullable=true)
     */
    private $town;
    /**
     * @var string
     * @ORM\Column(name="county", type="string", length=254, nullable=true)
     */
    private $county;
    /**
     * @var string
     * @ORM\Column(name="postcode", type="string", length=254, nullable=true)
     */
    private $postcode;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return CombinedUser
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return CombinedUser
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return CombinedUser
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
     * @return CombinedUser
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
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
     * @return CombinedUser
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailaddress()
    {
        return $this->emailaddress;
    }

    /**
     * @param string $emailaddress
     * @return CombinedUser
     */
    public function setEmailaddress($emailaddress)
    {
        $this->emailaddress = $emailaddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getMobiletel()
    {
        return $this->mobiletel;
    }

    /**
     * @param string $mobiletel
     * @return CombinedUser
     */
    public function setMobiletel($mobiletel)
    {
        $this->mobiletel = $mobiletel;
        return $this;
    }

    /**
     * @return string
     */
    public function getHometel()
    {
        return $this->hometel;
    }

    /**
     * @param string $hometel
     * @return CombinedUser
     */
    public function setHometel($hometel)
    {
        $this->hometel = $hometel;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return CombinedUser
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * @param string $expiry
     * @return CombinedUser
     */
    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;
        return $this;
    }

    /**
     * @return string
     */
    public function getTempPassword()
    {
        return $this->tempPassword;
    }

    /**
     * @param string $tempPassword
     * @return CombinedUser
     */
    public function setTempPassword($tempPassword)
    {
        $this->tempPassword = $tempPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return CombinedUser
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return int
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * @param int $employerId
     * @return CombinedUser
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;
        return $this;
    }

    /**
     * @return int
     */
    public function getMasterUserId()
    {
        return $this->masterUserId;
    }

    /**
     * @param int $masterUserId
     * @return CombinedUser
     */
    public function setMasterUserId($masterUserId)
    {
        $this->masterUserId = $masterUserId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * @param int $adminId
     * @return CombinedUser
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param int $userid
     * @return CombinedUser
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
        return $this;
    }

    /**
     * @return string
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * @param string $line1
     * @return CombinedUser
     */
    public function setLine1($line1)
    {
        $this->line1 = $line1;
        return $this;
    }

    /**
     * @return string
     */
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * @param string $line2
     * @return CombinedUser
     */
    public function setLine2($line2)
    {
        $this->line2 = $line2;
        return $this;
    }

    /**
     * @return string
     */
    public function getLine3()
    {
        return $this->line3;
    }

    /**
     * @param string $line3
     * @return CombinedUser
     */
    public function setLine3($line3)
    {
        $this->line3 = $line3;
        return $this;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     * @return CombinedUser
     */
    public function setTown($town)
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @param string $county
     * @return CombinedUser
     */
    public function setCounty($county)
    {
        $this->county = $county;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     * @return CombinedUser
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    public function toArray()
    {
        return [
            'firstname' => $this->getFirstname(),
            'surname' => $this->getSurname(),
            'emailaddress' => $this->getEmailaddress(),
            'mobile' => $this->getMobiletel(),
            'hometel' => $this->getHometel(),
            'line1' => $this->getLine1(),
            'line2' => $this->getLine2(),
            'line3' => $this->getLine3(),
            'town' => $this->getTown(),
            'county' => $this->getCounty(),
            'postcode' => $this->getPostcode(),
            ];
    }

    public function getName()
    {
        return $this->getFirstname().' '.$this->getSurname();
    }


}
