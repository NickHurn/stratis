<?php
/**
 * Created by PhpStorm.
 * User: scottbaverstock
 * Date: 28/07/2017
 * Time: 14:21
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="applicant_prev_name")
 * @ORM\Entity
 */
class ApplicantPrevName
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $Name;

    /**
     * @ORM\Column(name="type", type="string", length=10)
     */
    private $Type;

    /**
     * @ORM\Column(name="start_date", type="integer")
     */
    private $StartDate;

    /**
     * @ORM\Column(name="end_date", type="integer")
     */
    private $EndDate;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     * @return ApplicantPrevName
     */
    public function setName($Name)
    {
        $this->Name = $Name;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     * @return ApplicantPrevName
     */
    public function setType($Type)
    {
        $this->Type = $Type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->StartDate;
    }

    /**
     * @param mixed $StartDate
     * @return ApplicantPrevName
     */
    public function setStartDate($StartDate)
    {
        $this->StartDate = $StartDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->EndDate;
    }

    /**
     * @param mixed $EndDate
     * @return ApplicantPrevName
     */
    public function setEndDate($EndDate)
    {
        $this->EndDate = $EndDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ApplicantPrevName
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}