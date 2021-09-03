<?php

namespace FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Field
 *
 * @ORM\Table(name="choice_option")
 * @ORM\Entity
 */
class ChoiceOption
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="value", type="string", length=50, nullable=false)
     */
    private $value;

    /**
     * @var int
     * @ORM\Column(name="filter_on", type="integer", nullable=true)
     */
    private $filterOn;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
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
     * @return ChoiceOption
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    function getFilterable()
    {
        return $this->getFilterOn();
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
     * @return ChoiceOption
     */
    public function setFilterOn($filterOn)
    {
        $this->filterOn = $filterOn;
        return $this;
    }



}
