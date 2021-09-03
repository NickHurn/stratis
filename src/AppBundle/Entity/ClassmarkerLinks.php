<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassmarkerLinks
 *
 * @ORM\Table(name="classmarker_links", uniqueConstraints={@ORM\UniqueConstraint(name="link_id", columns={"link_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ClassmarkerLinksRepository")
 */
class ClassmarkerLinks
{
    /**
     * @var string
     *
     * @ORM\Column(name="link_name", type="string", length=100, nullable=false)
     */
    private $linkName;

    /**
     * @var string
     *
     * @ORM\Column(name="link_url", type="string", length=45, nullable=true)
     */
    private $linkUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="test_id", type="integer", nullable=true)
     */
    private $testId;

    /**
     * @var integer
     *
     * @ORM\Column(name="link_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $linkId;



    /**
     * Set linkName
     *
     * @param string $linkName
     *
     * @return ClassmarkerLinks
     */
    public function setLinkName($linkName)
    {
        $this->linkName = $linkName;

        return $this;
    }

    /**
     * Get linkName
     *
     * @return string
     */
    public function getLinkName()
    {
        return $this->linkName;
    }

    /**
     * Set linkUrl
     *
     * @param string $linkUrl
     *
     * @return ClassmarkerLinks
     */
    public function setLinkUrl($linkUrl)
    {
        $this->linkUrl = $linkUrl;

        return $this;
    }

    /**
     * Get linkUrl
     *
     * @return string
     */
    public function getLinkUrl()
    {
        return $this->linkUrl;
    }

    /**
     * Set testId
     *
     * @param integer $testId
     *
     * @return ClassmarkerLinks
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
     * Get linkId
     *
     * @return integer
     */
    public function getLinkId()
    {
        return $this->linkId;
    }
}
