<?php

namespace FormBundle\Entity\Fields;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FormBundle\Entity\ChoiceOption;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * IntegerField
 *
 * @ORM\Table(name="choice_field")
 * @ORM\Entity
 */
class ChoicesField
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
     *
     */
    private $required;

    /**
     * @var string
     * @ORM\Column(name="field_type", type="string", length=10 )
     *
     */
    private $fieldType;

    /**
     * Many User have Many Names
     * @ORM\ManyToMany(targetEntity="FormBundle\Entity\ChoiceOption", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="choicefield_choiceoptions",
     *      joinColumns={@ORM\JoinColumn(name="field_id", onDelete="CASCADE", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="option_id", onDelete="CASCADE", referencedColumnName="id", unique=true)}
     *      )
     */
    private $options;

    private $formId;


    public function __construct()
    {
        $this->options = new ArrayCollection();
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
     * @return ChoicesField
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
     * @return ChoicesField
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
     * @return ChoicesField
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return string
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * @param string $fieldType
     * @return ChoicesField
     */
    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;
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
     * @return ChoicesField
     */
    public function setFormId($formId)
    {
        $this->formId = $formId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param ChoiceOption $options
     * @return ChoicesField
     */
    public function setOptions($options)
    {
        $this->options->add($options);
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
     * @return ChoicesField
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
            'fieldType' => $this->getFieldType(),
            'choiceOptions' => $this->getOptions(),
            'heading' => $this->getHeading(),
            'type' => 'choice',
            'required' => (bool) $this->getRequired()
        ];
    }
}