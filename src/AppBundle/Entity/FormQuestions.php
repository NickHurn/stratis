<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormQuestions
 *
 * @ORM\Table(name="form_questions")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FormQuestionsRepository")
 */
class FormQuestions
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
     * @ORM\Column(name="form_id", type="integer", nullable=false)
     */
    private $formId;

	/**
     * @var integer
     *
     * @ORM\Column(name="seq", type="integer", nullable=false)
     */
    private $seq;
	
	/**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=false)
     */
    private $question;

	/**
     * @var string
     *
     * @ORM\Column(name="question_type", type="string", length=20, nullable=false)
     */
    private $questionType;

	/**
     * @var integer
     *
     * @ORM\Column(name="pool_id", type="integer", nullable=true, options={"default" = 0} )
     */
    private $poolId;

	/**
     * @var integer
     *
     * @ORM\Column(name="pool_questions", type="integer", nullable=true, options={"default" = 0} )
     */
    private $poolQuestions;
	
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="required", type="boolean", nullable=true)
     */
    private $required;

	
	/**
     * @var integer
     *
     * @ORM\Column(name="secs", type="integer", nullable=false, options={"default" = 0} )
     */
    private $secs;

	
	/**
     * @var string
     *
     * @ORM\Column(name="data_values", type="text", length=65535, nullable=true)
     */
    private $dataValues;




	/**
     * @return integer
     */
	public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return FormQuestions
     */
    public function setId($id)
    {
        $this->id = $id;
		return $this;
    }


	/**
     * @return integer
     */
	public function getFormId()
    {
        return $this->formId;
    }

    /**
     * @param integer $formId
     * @return FormQuestions
     */
    public function setFormId($formId)
    {
		$this->formId = $formId;
        return $this;
	}


	/**
     * @return integer
     */
	public function getSeq()
    {
        return $this->seq;
    }

    /**
     * @param integer $seq
     * @return FormQuestions
     */
    public function setSeq($seq)
    {
        $this->seq = $seq;
        return $this;
    }


	/**
     * @return string
     */
	public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     * @return FormQuestions
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }


	/**
     * @return string
     */
	public function getQuestionType()
    {
        return $this->questionType;
    }

    /**
     * @param string $questionType
     * @return FormQuestions
     */
    public function setQuestionType($questionType)
    {
        $this->questionType = $questionType;
        return $this;
    }


	/**
     * @return integer
     */
	public function getPoolId()
    {
        return $this->poolId;
    }

    /**
     * @param integer $poolId
     * @return FormQuestions
     */
    public function setPoolId($poolId)
    {
        $this->poolId = $poolId;
        return $this;
    }


	/**
     * @return integer
     */
	public function getPoolQuestions()
    {
        return $this->poolQuestions;
    }

    /**
     * @param integer $poolQuestions
     * @return FormQuestions
     */
    public function setPoolQuestions($poolQuestions)
    {
        $this->poolQuestions = $poolQuestions;
        return $this;
    }


	/**
     * @return boolean
     */
	public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     * @return FormQuestions
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }


	/**
     * @return integer
     */
	public function getSecs()
    {
        return $this->secs;
    }

    /**
     * @param integer $secs
     * @return FormQuestions
     */
    public function setSecs($secs)
    {
        $this->secs = $secs;
        return $this;
    }


	/**
     * @return string
     */
	public function getDataValues()
    {
        return $this->dataValues;
    }

    /**
     * @param string $dataValues
     * @return FormQuestions
     */
    Public function setDataValues($dataValues)
    {
        $this->dataValues = $dataValues;
        return $this;
    }
}
