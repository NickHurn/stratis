<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExcelTestResults
 *
 * @ORM\Table(name="excel_test_results")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ExcelTestResultsRepository")
 */
class ExcelTestResults
{
    /**
     * @var integer
     *
     * @ORM\Column(name="test_id", type="integer", nullable=true)
     */
    private $testId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="time_elapsed", type="string", length=45, nullable=true)
     */
    private $timeElapsed;

    /**
     * @var integer
     *
     * @ORM\Column(name="correct_words", type="integer", nullable=true)
     */
    private $correctWords;

    /**
     * @var integer
     *
     * @ORM\Column(name="incorrect_words", type="integer", nullable=true)
     */
    private $incorrectWords;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct() {
        $this->createdOn = new \DateTime('now');
    }

    /**
     * Set testId
     *
     * @param integer $testId
     *
     * @return ExcelTestResults
     */
    public function setTestId($testId)
    {
        $this->testId = $testId;

        return $this;
    }

    /**
     * Get testId
     *
     * @return integer
     */
    public function getTestId()
    {
        return $this->testId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return ExcelTestResults
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set timeElapsed
     *
     * @param string $timeElapsed
     *
     * @return ExcelTestResults
     */
    public function setTimeElapsed($timeElapsed)
    {
        $this->timeElapsed = $timeElapsed;

        return $this;
    }

    /**
     * Get timeElapsed
     *
     * @return string
     */
    public function getTimeElapsed()
    {
        return $this->timeElapsed;
    }

    /**
     * Set correctWords
     *
     * @param integer $correctWords
     *
     * @return ExcelTestResults
     */
    public function setCorrectWords($correctWords)
    {
        $this->correctWords = $correctWords;

        return $this;
    }

    /**
     * Get correctWords
     *
     * @return integer
     */
    public function getCorrectWords()
    {
        return $this->correctWords;
    }

    /**
     * Set incorrectWords
     *
     * @param integer $incorrectWords
     *
     * @return ExcelTestResults
     */
    public function setIncorrectWords($incorrectWords)
    {
        $this->incorrectWords = $incorrectWords;

        return $this;
    }

    /**
     * Get incorrectWords
     *
     * @return integer
     */
    public function getIncorrectWords()
    {
        return $this->incorrectWords;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return ExcelTestResults
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
