<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employers
 *
 * @ORM\Table(name="employers")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\EmployersRepository")
 */
class Employers
{

	/**
	 * @var string
	 *
	 * @ORM\Column(name="company", type="string", length=150, nullable=false)
	 */
	private $company;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="cameratag_app_id", type="string", length=45, nullable=true)
	 */
	private $cameratagAppId;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="gbg_organisation_id", type="string", length=30, nullable=true)
	 */
	private $gbgOrganisationId;

	/**
	 * @var string
	 * @ORM\Column(name="web_hook_url", type="string", length=255, nullable=true)
	 */
	private $webHookUrl;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * Set company
	 *
	 * @param string $company
	 *
	 * @return Employers
	 */
	public function setCompany($company) {
		$this->company = $company;

		return $this;
	}

	/**
	 * Get company
	 *
	 * @return string
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Set cameratagAppId
	 *
	 * @param string $cameratagAppId
	 *
	 * @return Employers
	 */
	public function setCameratagAppId($cameratagAppId) {
		$this->cameratagAppId = $cameratagAppId;

		return $this;
	}

	/**
	 * Get cameratagAppId
	 *
	 * @return integer
	 */
	public function getCameratagAppId() {
		return $this->cameratagAppId;
	}

	/**
	 * Set gbgOrganisationId
	 *
	 * @param integer $cameratagAppId
	 *
	 * @return Employers
	 */
	public function setGbgOrganisationId($gbgOrganisationId) {
		$this->gbgOrganisationId = $gbgOrganisationId;
		return $this;
	}

	/**
	 * Get gbgOrganisationId
	 *
	 * @return integer
	 */
	public function getGbgOrganisationId() {
		return $this->gbgOrganisationId;
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getWebHookUrl() {
		return $this->webHookUrl;
	}

	/**
	 * @param string $webHookUrl
	 * @return Employers
	 */
	public function setWebHookUrl($webHookUrl) {
		$this->webHookUrl = $webHookUrl;
		return $this;
	}
}
