<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UsersRepository")
 */
class Users implements UserInterface, \Serializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=254, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=45, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=45, nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="hometel", type="string", length=45, nullable=true)
     */
    private $hometel;

    /**
     * @var string
     *
     * @ORM\Column(name="mobiletel", type="string", length=45, nullable=true)
     */
    private $mobiletel;

    /**
     * @var string
     *
     * @ORM\Column(name="emailaddress", type="string", length=150, nullable=true)
     */
    private $emailaddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_logged_in", type="datetime", nullable=true)
     */
    private $lastLoggedIn;

    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=true)
     */
    private $employerId;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="expiry", type="datetime", nullable=true)
     */
    private $expiry;

    /**
     * @var string
     * @ORM\Column(name="redirect", type="string", length=255, nullable=true)
     */
    private $redirect;

    /**
     * @ORM\ManyToMany (targetEntity="AppBundle\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles_join")
     */
    private $roles;

    /**
     * @ORM\Column(name="temp_password", type="integer", nullable=true)
     */
    private $tempPassword;

    /**
     * @ORM\Column(name="reset", type="string", length=30, nullable=true)
     */
    private $reset;

	/**
     * @var string
     */
    private $plainPassword;

    /**
     * @var integer
     *
     * @ORM\Column(name="retention", type="integer")
     */
    private $retention;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

	
    public function __construct() {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->retention = 0;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->emailaddress;
    }

    /**
     * Set password
     *
     * @param string $password
     * @param UserPasswordEncoder $encoder
     * @return Users
     */
    public function setPassword($password, UserPasswordEncoder $encoder)
    {
        $encoded = $encoder->encodePassword($this, $password);

        $this->password = $encoded;
        return $this;
    }


    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Users
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Users
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
     * Set hometel
     *
     * @param string $hometel
     *
     * @return Users
     */
    public function setHometel($hometel)
    {
        $this->hometel = $hometel;

        return $this;
    }

    /**
     * Get hometel
     *
     * @return string
     */
    public function getHometel()
    {
        return $this->hometel;
    }

    /**
     * Set mobiletel
     *
     * @param string $mobiletel
     *
     * @return Users
     */
    public function setMobiletel($mobiletel)
    {
        $this->mobiletel = $mobiletel;

        return $this;
    }

    /**
     * Get mobiletel
     *
     * @return string
     */
    public function getMobiletel()
    {
        return $this->mobiletel;
    }

    /**
     * Set emailaddress
     *
     * @param string $emailaddress
     *
     * @return Users
     */
    public function setEmailaddress($emailaddress)
    {
        $this->emailaddress = $emailaddress;

        return $this;
    }

    /**
     * Get emailaddress
     *
     * @return string
     */
    public function getEmailaddress()
    {
        return $this->emailaddress;
    }

    /**
     * Set lastLoggedIn
     *
     * @param \DateTime $lastLoggedIn
     *
     * @return Users
     */
    public function setLastLoggedIn($lastLoggedIn)
    {
        $this->lastLoggedIn = $lastLoggedIn;

        return $this;
    }

    /**
     * Get lastLoggedIn
     *
     * @return \DateTime
     */
    public function getLastLoggedIn()
    {
        return $this->lastLoggedIn;
    }

    /**
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return Users
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;

        return $this;
    }

    /**
     * Get employerId
     *
     * @return integer
     */
    public function getEmployerId()
    {
        return $this->employerId;
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
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getExpiry()
    {
        return $this->expiry;
    }


    public function getName()
    {
        return ucwords(strtolower($this->getFirstname().' '.$this->getSurname()));
    }


    /**
     * @param string $expiry
     */
    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;
    }

    /**
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @return mixed
     */
    public function getTempPassword()
    {
        return $this->tempPassword;
    }

    /**
     * @param mixed $tempPassword
     * @return Users
     */
    public function setTempPassword($tempPassword)
    {
        $this->tempPassword = $tempPassword;
        return $this;
    }

	/**
     * @return int
     */
    public function getRetention()
    {
        return $this->retention;
    }

    /**
     * @param int $retention
     * @return Users
     */
    public function setRetention($retention)
    {
        $this->retention = $retention;
        return $this;
    }

	
	
    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return Users
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }


    /**
     * @return string
     */
    public function getReset()
    {
        return $this->reset;
    }

    /**
     * @param string $reset
     * @return Users
     */
    public function setReset($reset)
    {
        $this->reset = $reset;
        return $this;
    }

	
	
    /**
     * @param string $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @param Role $role
     * @return Users
     */
    public function setRoles($role)
    {
        $this->roles->add($role);
        return $this;
    }

    /**
     * Get roles
     * @return array
     */
    public function getRoles()
    {
        $arole=array('ROLE_APPLICANT');
        foreach($this->roles as $r){
            $arole[] = $r->getName();
        }
        return $arole;
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

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->emailaddress,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->emailaddress,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
}
