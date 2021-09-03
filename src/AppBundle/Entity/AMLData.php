<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="aml_data")
 * @ORM\Entity
 */
class AMLData
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
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;
    
	/**
     * @ORM\Column(name="job_code", type="string", nullable=false)
     */
    private $jobCode;

	/**
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    private $address;

	/**
     * @ORM\Column(name="authenticity", type="string", nullable=true)
     */
    private $authenticity;

	/**
     * @ORM\Column(name="data_sent", type="text", nullable=true)
     */
    private $dataSent;

	/**
     * @ORM\Column(name="testinfo", type="text", nullable=true)
     */
    private $testinfo;

	/**
     * @ORM\Column(name="response", type="text", nullable=true)
     */
    private $response;
	
    /**
     * @ORM\Column(name="date_scanned", type="datetime", nullable=false)
     */
    private $dateScanned;


	
	/**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AMLData
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


	/**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $id
     * @return AMLData
     */
    public function setUserId($id)
    {
        $this->userId = $id;
        return $this;
    }


	/**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return AMLData
     */
    public function setAddress($a)
    {
        $this->address = $a;
        return $this;
    }

	
	/**
     * @return string
     */
    public function getJobCode()
    {
        return $this->jobCode;
    }

    /**
     * @param string $jobCode
     * @return AMLData
     */
    public function setJobCode($jobCode)
    {
        $this->jobCode = $jobCode;
        return $this;
    }


	/**
     * @return string
     */
    public function getAuthenticity()
    {
        return $this->authenticity;
    }

    /**
     * @param string $country
     * @return AMLData
     */
    public function setAuthenticity($a)
    {
        $this->authenticity = $a;
        return $this;
    }


	/**
     * @return string
     */
    public function getDataSent()
    {
        return $this->dataSent;
    }

    /**
     * @param string $dateSent
     * @return AMLData
     */
    public function setDataSent($d)
    {
        $this->dataSent = $d;
        return $this;
    }
	
	
	/**
     * @return string
     */
    public function getTestinfo()
    {
        return $this->testinfo;
    }

    /**
     * @param string $country
     * @return AMLData
     */
    public function setTestinfo($t)
    {
        $this->testinfo = $t;
        return $this;
    }


	/**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param string $response
     * @return AMLData
     */
    public function setResponse($r)
    {
        $this->response = $r;
        return $this;
    }


	/**
     * @return string
     */
    public function getDateScanned()
    {
        return $this->dateScanned;
    }

    /**
     * @param string $dateScanned
     * @return AMLData
     */
    public function setDateScanned($dt)
    {
        $this->dateScanned = $dt;
        return $this;
    }
}
