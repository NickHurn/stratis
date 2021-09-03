<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExcelTestAllocation
 *
 * @ORM\Table(name="excel_test_allocation")
 * @ORM\Entity
 */
class ExcelTestAllocation
{
    /**
     * @var integer
     * @ORM\Column(name="employer_id", type="integer", nullable=true)
     */
    private $employerId;

    /**
     * @var integer
     * @ORM\Column(name="test_id", type="integer")
     */
    private $testId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return ExcelTestAllocation
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;

        return $this;
    }

    /**
     * Get employerId
     *
     * @return integer
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * @return int
     */
    public function getTestId()
    {
        return $this->testId;
    }

    /**
     * @param int $testId
     * @return ExcelTestAllocation
     */
    public function setTestId($testId)
    {
        $this->testId = $testId;
        return $this;
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
     * @return ExcelTestAllocation
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}
