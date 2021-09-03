<?php

namespace FormBundle\Entity\Fields;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FormBundle\Validator\Constraints as FormAssert;

/**
 * IntegerField
 *
 * @ORM\Table(name="integer_field")
 * @ORM\Entity
 * @FormAssert\FilterOn()
 */
class IntegerField
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
     * @ORM\Column(name="name", type="string", length=255 )
     * @Assert\NotNull()
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "The field name must be at least {{ limit }} characters long",
     *      maxMessage = "Your field name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="heading", type="string", length=15 )
     * @Assert\NotNull()
     * @Assert\Length(
     *      min = 2,
     *      max = 15,
     *      minMessage = "The field heading must be at least {{ limit }} characters long",
     *      maxMessage = "Your field heading cannot be longer than {{ limit }} characters"
     * )
     */
    private $heading;

    /**
     * @var int
     * @Assert\NotNull()
     * @ORM\Column(name="required", type="integer" )
     *
     */
    private $required;

    private $formId;

    /**
     * @var int
     * @ORM\Column(name="filterable", type="integer", nullable=true)
     */
    private $filterable;

    /**
     * @var int
     * @ORM\Column(name="filter_on", type="integer", nullable=true)
     */
    private $filterOn;

    /**
     * @var string
     * @ORM\Column(name="filter_operator", type="string", length=2, nullable=true)
     */
    private $filterOperator;

    /**
     * @return int
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @return int
     */
    public function getFilterable()
    {
        return $this->filterable;
    }

    /**
     * @param int $filterable
     * @return IntegerField
     */
    public function setFilterable($filterable)
    {
        $this->filterable = $filterable;
        return $this;
    }

    /**
     * @return int
     */
    public function getFilterOn()
    {
        return $this->filterOn;
    }

    /**
     * @param int $filterOn
     * @return IntegerField
     */
    public function setFilterOn($filterOn)
    {
        $this->filterOn = $filterOn;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilterOperator()
    {
        return $this->filterOperator;
    }

    /**
     * @param string $filterOperator
     * @return IntegerField
     */
    public function setFilterOperator($filterOperator)
    {
        $this->filterOperator = $filterOperator;
        return $this;
    }

    /**
     * @param int $required
     * @return IntegerField
     */
    public function setRequired($required)
    {
        $this->required = (int) $required;
        return $this;
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
     * @return IntegerField
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return IntegerField
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormId()
    {
        return $this->formId;
    }

    /**
     * @param mixed $formId
     * @return IntegerField
     */
    public function setFormId($formId)
    {
        $this->formId = $formId;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     * @return IntegerField
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
        return $this;
    }


    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => 'integer',
            'heading' => $this->getHeading(),
            'required' => (bool) $this->getRequired()
        ];
    }

    public function filtered($value)
    {
        if($this->getFilterable() === 1)
        {
            if($this->getFilterOperator() == 'eq'){
                return (int) ($value === $this->getFilterOn());
            }
            if($this->getFilterOperator() == 'gt'){
                return (int) ($value > $this->getFilterOn());
            }
            if($this->getFilterOperator() == 'lt'){
                return (int) ($value < $this->getFilterOn());
            }

        }   else {
            return 0;
        }
    }



}