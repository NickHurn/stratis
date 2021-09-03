<?php

namespace FormBundle\Entity\Values;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Text
 *
 * @ORM\Table(name="date_value")
 * @ORM\Entity
 */
class DateValue
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
     * @var int
     * @ORM\Column(name="form_id", type="integer", nullable=false)
     */
    private $formId;

    /**
     * @var int
     * @ORM\Column(name="field_id", type="integer", nullable=false)
     */
    private $fieldId;

    /**
     * @var string
     * @ORM\Column(name="value", type="datetime", nullable=false)
     */
    private $value;

    /**
     * @var int
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return dateValue
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getFormId()
    {
        return $this->formId;
    }

    /**
     * @param int $formId
     * @return dateValue
     */
    public function setFormId($formId)
    {
        $this->formId = $formId;
        return $this;
    }

    /**
     * @return int
     */
    public function getFieldId()
    {
        return $this->fieldId;
    }

    /**
     * @param int $fieldId
     * @return dateValue
     */
    public function setFieldId($fieldId)
    {
        $this->fieldId = $fieldId;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value->format('d/m/Y');
    }

    /**
     * @param string $value
     * @return dateValue
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return dateValue
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

}