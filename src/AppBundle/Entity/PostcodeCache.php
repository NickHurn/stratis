<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postcode_Cache
 *
 * @ORM\Table(name="postcode_cache")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PostcodeCacheRepository")
 */
class PostcodeCache
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="postcode", type="string", nullable=false)
     */
    private $postcode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cached", type="datetime", nullable=false)
     */
    private $dateCached = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="response", type="text", nullable=false)
     */
    private $response;

    /**
     * @var integer
     *
     * @ORM\Column(name="keep_cached", type="integer", nullable=false)
     */
    private $keepCached;



    
    /**
     * Set postcode
     * @param string $postcode
     * @return PostcodeCache
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * Get postcode
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }



    
    /**
     * Set dateCached
     * @param string $dateCached
     * @return PostcodeCache
     */
    public function setDateCached($dateCached)
    {
        $this->dateCached = $dateCached;
        return $this;
    }

    /**
     * Get dateCached
     * @return \DateTime
     */
    public function getDateCached()
    {
        return $this->dateCached;
    }

    
    /**
     * Get response
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set response
     * @param string $response
     * @return PostcodeCache
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }


    /**
     * Get keepCached
     * @return integer
     */
    public function getKeepCached()
    {
        return $this->keepCached;
    }

    /**
     * Set keepCached
     * @param string $keepCached
     * @return PostcodeCache
     */
    public function setKeepCached($keepCached)
    {
        $this->keepCached = $keepCached;
        return $this;
    }
}
