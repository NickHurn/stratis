<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassmarkerGroups
 *
 * @ORM\Table(name="classmarker_groups", uniqueConstraints={@ORM\UniqueConstraint(name="group_id", columns={"group_id"})})
 * @ORM\Entity
 */
class ClassmarkerGroups
{
    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=100, nullable=false)
     */
    private $groupName;

    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $groupId;



    /**
     * Set groupName
     *
     * @param string $groupName
     *
     * @return ClassmarkerGroups
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get groupName
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Get groupId
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->groupId;
    }
}
