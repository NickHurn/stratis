<?php

namespace FormBundle\Entity\Fields;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Text
 *
 * @ORM\Table(name="url_field")
 * @ORM\Entity
 */
class UrlField
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
     * @return UrlField
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
     * @return UrlField
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
     * @return UrlField
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
     * @return UrlField
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
     * @return UrlField
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
            'type' => 'url',
            'heading' => $this->getHeading(),
            'required' => (bool) $this->getRequired()
        ];
    }

}