<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormAnswers
 *
 * @ORM\Table(name="form_answers")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FormAnswersRepository")
 */
class FormAnswers
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
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

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
     * @var string
     *
     * @ORM\Column(name="answer", type="text", length=65535, nullable=true)
     */
    private $answer;

	/**
     * @var integer
     *
     * @ORM\Column(name="answer_idx", type="integer", nullable=true)
     */
    private $answerIdx;

	/**
     * @var integer
     *
     * @ORM\Column(name="pool_id", type="integer", nullable=true, options={"default" = 0} )
     */
    private $poolId;

	/**
     * @var integer
     *
     * @ORM\Column(name="pool_question_id", type="integer", nullable=true, options={"default" = 0} )
     */
    private $poolQuestionId;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="secs", type="integer", nullable=true, options={"default" = 0} )
     */
    private $secs;

	
	/**
     * @var string
     *
     * @ORM\Column(name="data_values", type="text", length=65535, nullable=true)
     */
    private $dataValues;

	/**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true, options={"default" = 0} )
     */
    private $score;

	/**
     * @var integer
     *
     * @ORM\Column(name="max_score", type="integer", nullable=true, options={"default" = 0} )
     */
    private $maxScore;




	/**
     * @return integer
     */
	public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return FormAnswers
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
     * @return FormAnswers
     */
	public function setFormId($formId)
    {
        $this->formId = $formId;
        return $this;
    }


	/**
     * @return integer
     */
	public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param integer $userId
     * @return FormAnswers
     */
	public function setUserId($userId)
    {
        $this->userId = $userId;
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
     * @return FormAnswers
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
     * @return FormAnswers
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
     * @return FormAnswers
     */
	public function setQuestionType($questionType)
    {
        $this->questionType = $questionType;
        return $this;
    }


	/**
     * @return string
     */
	public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     * @return FormAnswers
     */
	public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $this;
    }


	/**
     * @return integer
     */
	public function getAnswerIdx()
    {
        return $this->answerIdx;
    }

    /**
     * @param integer $answerIdx
     * @return FormAnswers
     */
	public function setAnswerIdx($answerIdx)
    {
        $this->answerIdx = $answerIdx;
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
     * @return FormAnswers
     */
	public function setPoolId($poolId)
    {
        $this->poolId = $poolId;
        return $this;
    }


	/**
     * @return integer
     */
	public function getPoolQuestionId()
    {
        return $this->poolQuestionId;
    }

    /**
     * @param integer $poolQuestionId
     * @return FormAnswers
     */
	public function setPoolQuestionId($poolQuestionId)
    {
        $this->poolQuestionId = $poolQuestionId;
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
     * @return FormAnswers
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
     * @return FormAnswers
     */
	public function setDataValues($dataValues)
    {
        $this->dataValues = $dataValues;
        return $this;
    }


	/**
     * @return integer
     */
	public function getScore()
    {
        return $this->score;
    }

    /**
     * @param integer $score
     * @return FormAnswers
     */
	public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }


	/**
     * @return integer
     */
	public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     * @param integer $maxScore
     * @return FormAnswers
     */
	public function setMaxScore($maxScore)
    {
        $this->maxScore = $maxScore;
        return $this;
    }
}
