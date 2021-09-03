<?php

namespace FormBundle\Entity\Fields;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Text
 *
 * @ORM\Table(name="yes_no_field")
 * @ORM\Entity
 */
class YesNoField
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
     * @ORM\Column(name="required", type="integer" )
     */
    private $required;

    /**
     * @var int
     * @ORM\Column(name="filter_on", type="integer", nullable=true)
     */
    private $filterOn;

    private $formId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return YesNoField
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return YesNoField
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
     * @return YesNoField
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
     * @return YesNoField
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
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
     * @return YesNoField
     */
    public function setFilterOn($filterOn)
    {
        $this->filterOn = $filterOn;
        return $this;
    }

    public function getFilterable()
    {
        if($this->getFilterOn() === 0){
            return 0;
        }
        return 1;
    }

    public function filtered($value)
    {
        if($value == 1 && $this->getFilterOn() === 1){
            return 1;
        } elseif($value == 0 && $this->getFilterOn() === 2){
            return 1;
        } else {
            return 0;
        }
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => 'yesno',
            'heading' => $this->getHeading(),
            'required' => (bool) $this->getRequired()
        ];
    }

}