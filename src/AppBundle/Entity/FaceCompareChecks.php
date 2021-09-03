<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="facecompare_checks")
 * @ORM\Entity
 */
class FaceCompareChecks
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
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", nullable=true)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="job_code", type="string", nullable=true)
     */
    private $jobCode;

	/**
     * @var string
     *
     * @ORM\Column(name="response", type="text", length=65535, nullable=true)
     */
    private $response;

	/**
     * @var string
     *
     * @ORM\Column(name="result", type="text", length=65535, nullable=true)
     */
    private $result;


	
    /**
     * Set Id
     *
     * @param integer $id
     *
     * @return FaceCompareChecks
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


	/**
     * Set source
     *
     * @param string $source
     *
     * @return FaceCompareChecks
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

	
	/**
     * Set jobCode
     *
     * @param string $jobCode
     *
     * @return FaceCompareChecks
     */
    public function setJobCode($jobCode)
    {
        $this->jobCode = $jobCode;
        return $this;
    }

    /**
     * Get jobCode
     *
     * @return string
     */
    public function getJobCode()
    {
        return $this->jobCode;
    }


	/**
     * Set userId
     *
     * @param integer $userId
     *
     * @return FaceCompareChecks
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
     * Set response
     *
     * @param string $companies
     *
     * @return FaceCompareChecks
     */
    public function setResponse($s)
    {
        $this->response = $s;
        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }


	/**
     * Set result
     *
     * @param string $result
     *
     * @return FaceCompareChecks
     */
    public function setResult($s)
    {
		$data = json_decode($s);
		$conf = sprintf("%.1f",$data->comp->confidence);
		$this->result = $conf;
        return $this;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }
	
}
