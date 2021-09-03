<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Pools
 *
 * @ORM\Table(name="pools")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PoolsRepository")
 */
class Pools
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
     *
     * @ORM\Column(name="pool_name", type="string", length=100, nullable=false)
     */
    private $poolName;


	/**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=true)
     */
    private $employerId;

	
	/**
     * @var integer
     *
     * @ORM\Column(name="num_questions", type="integer", nullable=false, options={"default" = 0} )
     */
    private $numQuestions;




	/**
     * @return integer
     */
	public function getId()
    {
        return $this->id;
    }

	
    /**
     * @param integer $id
     * @return Forms
     */
	public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


	
	/**
     * @return string
     */
	public function getPoolName()
    {
        return $this->poolName;
    }

	
    /**
     * @param string $poolName
     * @return Forms
     */
	public function setPoolName($poolName)
    {
        $this->poolName = $poolName;
        return $this;
    }


	/**
     * @return int
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * @param int $employerId
     * @return Forms
     */
    public function setEmployerId($employerId)
    {
        $this->employerId = $employerId;
        return $this;
    }

	
	/**
     * @return int
     */
    public function getNumQuestions()
    {
        return $this->numQuestions;
    }

    /**
     * @param int $numQuestions
     * @return Forms
     */
    public function setNumQuestions($numQuestions)
    {
        $this->numQuestions = $numQuestions;
        return $this;
    }
}
