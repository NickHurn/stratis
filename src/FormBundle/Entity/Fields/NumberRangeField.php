<?php

namespace FormBundle\Entity\Fields;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FormBundle\Validator\Constraints as FormAssert;

/**
 * IntegerField
 *
 * @ORM\Table(name="number_range_field")
 * @ORM\Entity
 * @FormAssert\FilterOn()
 */
class NumberRangeField
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
     *      minMessage = "The field heading must be at least {{ limit }} characters long",
     *      maxMessage = "Your field heading cannot be longer than {{ limit }} characters"
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
     *      minMessage = "The field name must be at least {{ limit }} characters long",
     *      maxMessage = "Your field name cannot be longer than {{ limit }} characters"
     * )
     */
    private $heading;

    /**
     * @var integer
     * @Assert\NotNull()
     * @ORM\Column(name="min", type="integer")
     */
    private $min;

    /**
     * @var integer
     * @Assert\NotNull()
     * @ORM\Column(name="max", type="integer")
     */
    private $max;

    /**
     * @var int
     * @Assert\NotNull()
     * @ORM\Column(name="required", type="integer" )
     *
     */
    private $required;

    /**
     * @var int
     * @Assert\NotNull()
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

    private $formId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return NumberRangeField
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
     * @return NumberRangeField
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param int $min
     * @return NumberRangeField
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param int $max
     * @return NumberRangeField
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @return int
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param int $required
     * @return NumberRangeField
     */
    public function setRequired($required)
    {
        $this->required = $required;
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
     * @return NumberRangeField
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
     * @return NumberRangeField
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
        return $this;
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
     * @return NumberRangeField
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
     * @return NumberRangeField
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
     * @return NumberRangeField
     */
    public function setFilterOperator($filterOperator)
    {
        $this->filterOperator = $filterOperator;
        return $this;
    }


    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'min' => $this->getMin(),
            'max' => $this->getMax(),
            'heading' => $this->getHeading(),
            'type' => 'numberRange',
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