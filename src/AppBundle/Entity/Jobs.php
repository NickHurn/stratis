<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobs
 *
 * @ORM\Table(name="jobs")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\JobsRepository")
 */
class Jobs
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
     * @ORM\Column(name="created_by", type="integer", nullable=false)
     */
    private $createdBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="employer_id", type="integer", nullable=false)
     */
    private $employerId;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=150, nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=15, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="standfirst", type="string", length=255, nullable=true)
     */
    private $standfirst;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="county", type="string", length=255, nullable=true)
     */
    private $county;

    /**
     * @var string
     *
     * @ORM\Column(name="salary", type="string", length=255, nullable=true)
     */
    private $salary;

    /**
     * @var integer
     *
     * @ORM\Column(name="positions", type="integer", nullable=true, options={"default" = 1})
     */
    private $positions = '1';

	/**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer", nullable=true)
     */
    private $active;

	/**
     * @var string
     *
     * @ORM\Column(name="uniqueid", type="string", length=32, nullable=true)
     */
    private $uniqueid;

    /**
     * @var integer
     *
     * @ORM\Column(name="archived", type="integer", nullable=true)
     */
    private $archived;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="archived_date", type="datetime", nullable=true)
     */
    private $archivedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="short_url", type="string", length=45, nullable=true)
     */
    private $shortUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="checkabl", type="boolean", nullable=true, options={"default" = false})
     */
    private $checkabl = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="testabl", type="boolean", nullable=true, options={"default" = false})
     */
    private $testabl = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="personabl", type="boolean", nullable=true, options={"default" = false})
     */
    private $personabl = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="pre_screen", type="boolean", nullable=true, options={"default" = false})
     */
    private $prescreen = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="history", type="boolean", nullable=true, options={"default" = false})
     */
    private $history = '0';

	/**
     * @var integer
     *
     * @ORM\Column(name="disclosures", type="boolean", nullable=true, options={"default" = false})
     */
    private $disclosures = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="identity", type="boolean", nullable=true, options={"default" = false})
     */
    private $identity = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="jb_indeed", type="boolean", nullable=true, options={"default" = false})
     */
    private $jb_indeed = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="employment_max", type="integer", nullable=false, options={"default" = 0})
     */
    private $employment_max;

    /**
     * @var integer
     *
     * @ORM\Column(name="education_max", type="integer", nullable=false, options={"default" = 0})
     */
    private $education_max;

    /**
     * @var string
     *
     * @ORM\Column(name="form_token", type="string", length=255, nullable=true)
     */
    private $formToken;

    public function __construct() {
        $this->createdOn = new \DateTime('now');
    }
    
	/**
     * Set createdBy
     *
     * @param integer $createdBy
     *
     * @return Jobs
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set employerId
     *
     * @param integer $employerId
     *
     * @return Jobs
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
     * Set category
     *
     * @param string $category
     *
     * @return Jobs
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
     * Set type
     *
     * @param string $type
     *
     * @return Jobs
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Jobs
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getStandfirst()
    {
        return $this->standfirst;
    }

    /**
     * @param string $standfirst
     * @return Jobs
     */
    public function setStandfirst($standfirst)
    {
        $this->standfirst = $standfirst;
        return $this;
    }



    /**
     * Set description
     *
     * @param string $description
     *
     * @return Jobs
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set county
     *
     * @param string $county
     *
     * @return Jobs
     */
    public function setCounty($county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set salary
     *
     * @param string $salary
     *
     * @return Jobs
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return string
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set positions
     *
     * @param integer $positions
     *
     * @return Jobs
     */
    public function setPositions($positions)
    {
        $this->positions = $positions;

        return $this;
    }

    /**
     * Get positions
     *
     * @return integer
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Jobs
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return Jobs
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

	
	/**
     * Set uniqueid
     *
     * @param string $uniqueid
     *
     * @return Jobs
     */
    public function setUniqueid($uniqueid)
    {
        $this->uniqueid = $uniqueid;

        return $this;
    }

    /**
     * Get uniqueid
     *
     * @return string
     */
    public function getUniqueid()
    {
        return $this->uniqueid;
    }

    /**
     * Set archived
     *
     * @param integer $archived
     *
     * @return Jobs
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return integer
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set archivedDate
     *
     * @param \DateTime $archivedDate
     *
     * @return Jobs
     */
    public function setArchivedDate($archivedDate)
    {
        $this->archivedDate = $archivedDate;

        return $this;
    }

    /**
     * Get archivedDate
     *
     * @return \DateTime
     */
    public function getArchivedDate()
    {
        return $this->archivedDate;
    }

    /**
     * Set shortUrl
     *
     * @param string $shortUrl
     *
     * @return Jobs
     */
    public function setShortUrl($shortUrl)
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    /**
     * Get shortUrl
     *
     * @return string
     */
    public function getShortUrl()
    {
        return $this->shortUrl;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Jobs
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
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

	
    /**
     * Set checkabl
     *
     * @param integer $checkabl
     *
     * @return Jobs
     */
    public function setCheckabl($checkabl)
    {
        $this->checkabl = $checkabl;

        return $this;
    }

    /**
     * Get checkabl
     *
     * @return boolean
     */
    public function getCheckabl()
    {
        return $this->checkabl;
    }


	/**
     * Set testabl
     *
     * @param boolean $testabl
     *
     * @return Jobs
     */
    public function setTestabl($testabl)
    {
        $this->testabl = $testabl;

        return $this;
    }

    /**
     * Get testabl
     *
     * @return boolean
     */
    public function getTestabl()
    {
        return $this->testabl;
    }

    
	/**
     * Set personabl
     *
     * @param boolean $personabl
     *
     * @return Jobs
     */
    public function setPersonabl($personabl)
    {
        $this->personabl = $personabl;

        return $this;
    }

    /**
     * Get personabl
     *
     * @return boolean
     */
    public function getPersonabl()
    {
        return $this->personabl;
    }


	/**
     * Set pre_screen
     *
     * @param boolean $prescreen
     *
     * @return Jobs
     */
    public function setPreScreen($prescreen)
    {
        $this->prescreen = $prescreen;

        return $this;
    }

    /**
     * Get pre_screen
     *
     * @return boolean
     */
    public function getPreScreen()
    {
        return $this->prescreen;
    }

	
	/**
     * Set history
     *
     * @param boolean $history
     *
     * @return Jobs
     */
    public function setHistory($history)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history
     *
     * @return boolean
     */
    public function getHistory()
    {
        return $this->history;
    }


	/**
     * Set disclosures
     *
     * @param boolean $disclosures
     *
     * @return Jobs
     */
    public function setDisclosures($disclosures)
    {
        $this->disclosures = $disclosures;

        return $this;
    }

    /**
     * Get disclosures
     *
     * @return boolean
     */
    public function getDisclosures()
    {
        return $this->disclosures;
    }

	
	/**
     * Set identity
     *
     * @param boolean $identity
     *
     * @return Jobs
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Get identity
     *
     * @return boolean
     */
    public function getIdentity()
    {
        return $this->identity;
    }

	
	/**
     * Set jb_indeed
     *
     * @param boolean $jb_indeed
     *
     * @return Jobs
     */
    public function setJbIndeed($jb_indeed)
    {
        $this->jb_indeed = $jb_indeed;

        return $this;
    }

    /**
     * Get jb_indeed
     *
     * @return boolean
     */
    public function getJbIndeed()
    {
		if(empty($this->jb_indeed)) return false;
		return true;
    }


	/**
     * Set employment_max
     *
     * @param integer $employment_max
     *
     * @return Jobs
     */
    public function setEmploymentMax($employment_max)
    {
		if(empty($employment_max)) $employment_max=0;
		$this->employment_max = $employment_max;
        return $this;
    }

    /**
     * Get employment_max
     *
     * @return integer
     */
    public function getEmploymentMax()
    {
		$x = !empty($this->employment_max) ? $this->employment_max:0;
        return $x;
    }

	
	/**
     * Set education_max
     *
     * @param integer $education_max
     *
     * @return Jobs
     */
    public function setEducationMax($education_max)
    {
	if(empty($education_max)) $education_max=0;
		$this->education_max = $education_max;
        return $this;
    }

    /**
     * Get education_max
     *
     * @return integer
     */
    public function getEducationMax()
    {
		$x = !empty($this->education_max) ? $this->education_max:0;
        return $x;
    }
	
	
	public function getFunctionality()
	{
		$chk = $this->getCheckabl();
		$test = $this->getTestabl();
		$pers = $this->getPersonabl();
		if($chk) $chk='CHK';
		if($test) $test='TEST';
		if($pers) $pers='PERS';
		return array(0=>$chk,$test,$pers);
	}

	public function setFunctionality($x)
	{
		$this->checkabl = false;
		$this->testabl = false;
		$this->personabl = false;
		if(count($x)>0)
		{
			foreach($x as $idx=>$i)
			{
				if($i=='CHK') $this->checkabl = true;
				if($i=='TEST') $this->testabl = true;
				if($i=='PERS') $this->personabl = true;
			}
		}
	}
	
	
	public function getChkoptions()
	{
		$pre = $this->getPreScreen();
		$his = $this->getHistory();
		$dsc = $this->getDisclosures();
		$id = $this->getIdentity();
		if($pre) $pre='PRE';
		if($his) $his='HIS';
		if($dsc) $dsc='DSC';
		if($id) $id='ID';
		return array(0=>$pre,$his,$dsc,$id);
	}

	public function setChkoptions($x)
	{
		$this->prescreen = false;
		$this->history = false;
		$this->disclosures = false;
		$this->identity = false;
		if(count($x)>0)
		{
			foreach($x as $idx=>$i)
			{
				if($i=='PRE') $this->prescreen = true;
				if($i=='HIS') $this->history = true;
				if($i=='DSC') $this->disclosures = true;
				if($i=='ID') $this->identity = true;
			}
		}
	}

	
	public function getJobboards()
	{
		$indeed = $this->getJbIndeed();
		$monster = null;
		if($indeed) $indeed='INDEED';
		if($monster) $monster='MONSTER';
		return array(0=>$indeed,$monster);
	}

	public function setJobboards($x)
	{
		$fields = array('INDEED','MONSTER');
		foreach($fields as $f) $values[$f]=false;
		if(count($x)>0)
		{
			for($i=0; $i<count($x); $i++)
			{
				foreach($fields as $f) {
					if($x[$i]==$f) $values[$f]=true;
				}
			}
		}
		$this->setJbIndeed($values['INDEED']);
		//$this->setJbMonster($values['MONSTER']);
	}

    /**
     * @return string
     */
    public function getFormToken(): string
    {
        return $this->formToken;
    }

    /**
     * @param string $formToken
     * @return Jobs
     */
    public function setFormToken(string $formToken): Jobs
    {
        $this->formToken = $formToken;
        return $this;
    }


}
