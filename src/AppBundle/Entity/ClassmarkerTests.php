<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassmarkerTests
 *
 * @ORM\Table(name="classmarker_tests", uniqueConstraints={@ORM\UniqueConstraint(name="test_id", columns={"test_id"})})
 * @ORM\Entity
 */
class ClassmarkerTests
{
    /**
     * @var string
     *
     * @ORM\Column(name="test_name", type="string", length=255, nullable=false)
     */
    private $testName;

    /**
     * @var integer
     *
     * @ORM\Column(name="test_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $testId;



    /**
     * Set testName
     *
     * @param string $testName
     *
     * @return ClassmarkerTests
     */
    public function setTestName($testName)
    {
        $this->testName = $testName;

        return $this;
    }

    /**
     * Get testName
     *
     * @return string
     */
    public function getTestName()
    {
        return $this->testName;
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
}
