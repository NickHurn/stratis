<?php

namespace FormBundle\Entity;

use AppBundle\Form\Jobs;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Form
 *
 * @ORM\Table(name="form")
 * @ORM\Entity
 */
class Form
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
     * @var string
     * @ORM\Column(name="name", length=255, nullable=false)
     */
    private $name;

    /**
     * Many Forms have One Type.
     * @ORM\ManyToOne(targetEntity="FormBundle\Entity\FormType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $formType;

    /**
     * Many Users have One Address.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employers")
     * @ORM\JoinColumn(name="employer_id", referencedColumnName="id")
     */
    private $employer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Jobs")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
    private $job;

    /**
     * Many Users have One Address.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="FormBundle\Entity\Field", mappedBy="form")
     */
    private $fields;


    public function __construct()
    {
        $this->createdOn = new \DateTime();
        $this->fields = new ArrayCollection();
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
     * @return Form
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Form
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @return mixed
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * @param mixed $formType
     * @return Form
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
        return $this;
    }

    /**
     * @param mixed $employer
     * @return Form
     */
    public function setEmployer($employer)
    {
        $this->employer = $employer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     * @return Form
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
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
     * @param \DateTime $createdOn
     * @return Form
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param Field $field
     * @return Form
     */
    public function setFields($field)
    {
        $this->fields->add($field);
        return $this;
    }

    /**
     * @return Jobs
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param mixed $job
     * @return Form
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }


    public function getFieldParameters()
    {
       $fields = [];
        foreach($this->getFields() as $key => $field){
           $fields[$key] = $field->getParamsAsArray();
            $fields[$key]['fieldId'] = $field->getId();
        }

        return $fields;
    }

}
