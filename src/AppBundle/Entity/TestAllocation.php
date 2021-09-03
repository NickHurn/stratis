<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TestAllocation
 *
 * @ORM\Table(name="test_allocation")
 * @ORM\Entity
 */
class TestAllocation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="link_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $linkId;

    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $employerId;



    /**
     * Set linkId
     *
     * @param integer $linkId
     *
     * @return TestAllocation
     */
    public function setLinkId($linkId)
    {
        $this->linkId = $linkId;

        return $this;
    }

    /**
     * Get linkId
     *
     * @return integer
     */
    public function getLinkId()
    {
        return $this->linkId;
    }

    /**
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return TestAllocation
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
}
