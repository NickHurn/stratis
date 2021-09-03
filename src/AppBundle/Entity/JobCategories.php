<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobCategories
 *
 * @ORM\Table(name="job_categories")
 * @ORM\Entity
 */
class JobCategories
{
    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=155, nullable=false)
     */
    private $category;

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;



    /**
     * Set category
     *
     * @param string $category
     *
     * @return JobCategories
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
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
