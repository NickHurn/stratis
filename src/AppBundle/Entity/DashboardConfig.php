<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DashboardConfig
 *
 * @ORM\Table(name="dashboard_config")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DashboardConfigRepository")
 */
class DashboardConfig
{

	/**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var integer
	 * @ORM\Column(name="user_id", type="integer")
     */
	private $userId;
				
    
    /**
     * @var string
	 * @ORM\Column(name="overview_config", type="string")
     */
	private $overviewConfig;
				
    
    /**
     * @var string
	 * @ORM\Column(name="detail_config", type="string")
     */
	private $detailConfig;
				

	
    /**
     * Set id
	 * @param integer $id
	 * @return DashboardConfig
     */
	public function setId($value)
    {
		$this->id = $value;
        return $this;
    }

    /**
     * Get id
	 * @return integer
     */
    public function getId()
    {
		return $this->id;
    }


	
    /**
     * Set user_id
	 * @param integer $user_id
	 * @return DashboardConfig
     */
	public function setUserId($value)
    {
		$this->userId = $value;
        return $this;
    }

    /**
     * Get user_id
	 * @return integer
     */
    public function getUserId()
    {
		return $this->userId;
	}


    /**
     * Set overview_config
	 * @param string $overview_config
	 * @return DashboardConfig
     */
	public function setOverviewConfig($value)
    {
		$this->overviewConfig = $value;
        return $this;
    }

    /**
     * Get overview_config
	 * @return string
     */
    public function getOverviewConfig()
    {
		return $this->overviewConfig;
    }


	
    /**
     * Set detail_config
	 * @param string $detail_config
	 * @return DashboardConfig
     */
	public function setDetailConfig($value)
    {
		$this->detailConfig = $value;
        return $this;
    }

    /**
     * Get detail_config
	 * @return string
     */
    public function getDetailConfig()
    {
		return $this->detailConfig;
    }
}
