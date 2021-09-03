<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CssSchemes
 *
 * @ORM\Table(name="css_schemes")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CssSchemesRepository")
 */
class CssSchemes
{
    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=45, nullable=false)
     */
    private $domain;

    /**
     * One Product has One Shipment.
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Employers")
     * @ORM\JoinColumn(name="employer_id", referencedColumnName="id")
     */
    private $employer_id;

    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=55, nullable=true)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="header_background", type="string", length=45, nullable=false)
     */
    private $headerBackground;

    /**
     * @var string
     *
     * @ORM\Column(name="header_logo", type="string", length=45, nullable=false)
     */
    private $headerLogo;

    /**
     * @var string
     *
     * @ORM\Column(name="footer_background", type="string", length=45, nullable=false)
     */
    private $footerBackground;

    /**
     * @var string
     *
     * @ORM\Column(name="footer_logo", type="string", length=45, nullable=false)
     */
    private $footerLogo;

    /**
     * @var string
     *
     * @ORM\Column(name="footer_co_name", type="string", length=45, nullable=false)
     */
    private $footerCoName;

    /**
     * @var string
     *
     * @ORM\Column(name="header_logo_admin", type="string", length=45, nullable=false)
     */
    private $headerLogoAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="header_background_admin", type="string", length=45, nullable=false)
     */
    private $headerBackgroundAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="footer_background_admin", type="string", length=45, nullable=false)
     */
    private $footerBackgroundAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="footer_logo_admin", type="string", length=45, nullable=false)
     */
    private $footerLogoAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_number", type="string", length=25, nullable=true)
     */
    private $contactNumber;

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
     * @ORM\Column(name="email_from", type="string", nullable=true)
     */
    private $emailFrom;

    /**
     * Set domain
     *
     * @param string $domain
     *
     * @return CssSchemes
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getUrlDomain()
    {
        return 'https://'.$_SERVER['HTTP_HOST'];
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return CssSchemes
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set headerBackground
     *
     * @param string $headerBackground
     *
     * @return CssSchemes
     */
    public function setHeaderBackground($headerBackground)
    {
        $this->headerBackground = $headerBackground;

        return $this;
    }

    /**
     * Get headerBackground
     *
     * @return string
     */
    public function getHeaderBackground()
    {
        return $this->headerBackground;
    }

    /**
     * Set headerLogo
     *
     * @param string $headerLogo
     *
     * @return CssSchemes
     */
    public function setHeaderLogo($headerLogo)
    {
        $this->headerLogo = $headerLogo;

        return $this;
    }

    /**
     * Get headerLogo
     *
     * @return string
     */
    public function getHeaderLogo()
    {
        return $this->headerLogo;
    }

    /**
     * Set footerBackground
     *
     * @param string $footerBackground
     *
     * @return CssSchemes
     */
    public function setFooterBackground($footerBackground)
    {
        $this->footerBackground = $footerBackground;

        return $this;
    }

    /**
     * Get footerBackground
     *
     * @return string
     */
    public function getFooterBackground()
    {
        return $this->footerBackground;
    }

    /**
     * Set footerLogo
     *
     * @param string $footerLogo
     *
     * @return CssSchemes
     */
    public function setFooterLogo($footerLogo)
    {
        $this->footerLogo = $footerLogo;

        return $this;
    }

    /**
     * Get footerLogo
     *
     * @return string
     */
    public function getFooterLogo()
    {
        return $this->footerLogo;
    }

    /**
     * Set footerCoName
     *
     * @param string $footerCoName
     *
     * @return CssSchemes
     */
    public function setFooterCoName($footerCoName)
    {
        $this->footerCoName = $footerCoName;

        return $this;
    }

    /**
     * Get footerCoName
     *
     * @return string
     */
    public function getFooterCoName()
    {
        return $this->footerCoName;
    }

    /**
     * Set headerLogoAdmin
     *
     * @param string $headerLogoAdmin
     *
     * @return CssSchemes
     */
    public function setHeaderLogoAdmin($headerLogoAdmin)
    {
        $this->headerLogoAdmin = $headerLogoAdmin;

        return $this;
    }

    /**
     * Get headerLogoAdmin
     *
     * @return string
     */
    public function getHeaderLogoAdmin()
    {
        return $this->headerLogoAdmin;
    }

    /**
     * Set headerBackgroundAdmin
     *
     * @param string $headerBackgroundAdmin
     *
     * @return CssSchemes
     */
    public function setHeaderBackgroundAdmin($headerBackgroundAdmin)
    {
        $this->headerBackgroundAdmin = $headerBackgroundAdmin;

        return $this;
    }

    /**
     * Get headerBackgroundAdmin
     *
     * @return string
     */
    public function getHeaderBackgroundAdmin()
    {
        return $this->headerBackgroundAdmin;
    }

    /**
     * Set footerBackgroundAdmin
     *
     * @param string $footerBackgroundAdmin
     *
     * @return CssSchemes
     */
    public function setFooterBackgroundAdmin($footerBackgroundAdmin)
    {
        $this->footerBackgroundAdmin = $footerBackgroundAdmin;

        return $this;
    }

    /**
     * Get footerBackgroundAdmin
     *
     * @return string
     */
    public function getFooterBackgroundAdmin()
    {
        return $this->footerBackgroundAdmin;
    }

    /**
     * Set footerLogoAdmin
     *
     * @param string $footerLogoAdmin
     *
     * @return CssSchemes
     */
    public function setFooterLogoAdmin($footerLogoAdmin)
    {
        $this->footerLogoAdmin = $footerLogoAdmin;

        return $this;
    }

    /**
     * Get footerLogoAdmin
     *
     * @return string
     */
    public function getFooterLogoAdmin()
    {
        return $this->footerLogoAdmin;
    }

    /**
     * Set contactNumber
     *
     * @param string $contactNumber
     *
     * @return CssSchemes
     */
    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * Get contactNumber
     *
     * @return string
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
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
     * @return mixed
     */
    public function getEmployerId()
    {
        return $this->employer_id;
    }

    /**
     * @param mixed $employer_id
     * @return CssSchemes
     */
    public function setEmployerId($employer_id)
    {
        $this->employer_id = $employer_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailFrom()
    {
        return $this->emailFrom;
    }

    /**
     * @param string $emailFrom
     * @return CssSchemes
     */
    public function setEmailFrom($emailFrom)
    {
        $this->emailFrom = $emailFrom;
        return $this;
    }



}
