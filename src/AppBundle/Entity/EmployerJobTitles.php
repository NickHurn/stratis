<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmployerJobTitles
 *
 * @ORM\Table(name="employer_job_titles")
 * @ORM\Entity
 */
class EmployerJobTitles
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
     * @ORM\Column(name="employer_id", type="integer")
     */
    private $employerId;

    /**
     * @var string
     *
     * @ORM\Column(name="job_title", type="string", length=60)
     */
    private $jobTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="searchType", type="string", length=20)
     */
    private $searchType;

	
	
    /**
     * Set jobTitle
     *
     * @param \string $jobTitle
     *
     * @return EmployersJobTitles
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return \string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Set searchType
     *
     * @param \string $searchType
     *
     * @return EmployersJobTitles
     */
    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;
        return $this;
    }

    /**
     * Get searchType
     *
     * @return \string
     */
    public function getSearchType()
    {
        return $this->searchType;
    }

	/**
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return EmployersTests
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

}
