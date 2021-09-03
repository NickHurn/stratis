<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class EmployersRepository extends EntityRepository
{

	//----------------------------------------------------------------------------------
	//  Fetch a list of Employers and their basic details
	//----------------------------------------------------------------------------------

	public function getList()
	{
        $result = $this->getEntityManager()->createQuery(
			'SELECT e.id, e.company, c.employerId AS cvcheck, s.checkabl, s.testabl, s.personabl, e.gbgOrganisationId AS dbs, css.domain, css.headerBackground
                FROM AppBundle:Employers e
                LEFT JOIN AppBundle:SectionDefaults s WITH e.id = s.employerId
				LEFT JOIN AppBundle:CvCheck c WITH e.id = c.employerId
				LEFT JOIN AppBundle:CssSchemes css WITH e.id = css.employer_id
				ORDER BY e.company'
                )
            ->getResult();
        return $result;
    }

	
	//----------------------------------------------------------------------------------
	//  Get Client Skills data
	//----------------------------------------------------------------------------------
	
    public function getSkillsData($id)
    {
		$skills = $this->getEntityManager()->getRepository('AppBundle\Entity\SkillsEmployer')->findBy(array('employerId' => $id));
		$ids = '';
		foreach($skills as $skill) $ids .= $skill->getSkillId() . ',';
		$ids .= '0';
		return $ids;
	}
	

	//----------------------------------------------------------------------------------
	//  Save Client Skills data
	//----------------------------------------------------------------------------------
	
    public function saveSkillsData($id,$data)
    {	
		$em= $this->getEntityManager();
		$em->createQuery("DELETE FROM AppBundle:SkillsEmployer se WHERE se.employerId = :id")
			->setParameters(array("id" => $id))->execute();


		foreach($data['skills'] as $skill) {
            $skillemp = new SkillsEmployer();
			$skillemp->setSkillId($skill->getId());
			$skillemp->setEmployerId($id);
			$skillemp->setCreatedOn(new \DateTime('now'));
			$em->persist($skillemp);
			$em->flush();
		} 
	}
	
	
	//----------------------------------------------------------------------------------
	//  Get Client Classmarker Tests data
	//----------------------------------------------------------------------------------
	
    public function getClassmarkerTestsData($id)
    {
		$classmmarkertests = $this->getEntityManager()->getRepository('AppBundle\Entity\TestAllocation')->findBy(array('employerId' => $id));
		$ids = '';
		foreach($classmmarkertests as $classmmarkertest) $ids .= $classmmarkertest->getLinkId() . ',';
		if($ids) $ids=substr($ids,0,-1);
		return $ids;
	}
	

	//----------------------------------------------------------------------------------
	//  Get Client Excel Tests data
	//----------------------------------------------------------------------------------
	
    public function getExcelTestsData($id)
    {
		$exceltests = $this->getEntityManager()->getRepository('AppBundle\Entity\ExcelTestAllocation')->findBy(array('employerId' => $id));
		$ids = '';
		foreach($exceltests as $exceltest) $ids .= $exceltest->getTestId() . ',';
		if($ids) $ids=substr($ids,0,-1);
		return $ids;
	}

	
	//----------------------------------------------------------------------------------
	//  Save Client Tests data
	//----------------------------------------------------------------------------------
	
    public function saveTestsData($id,$data)
    {	
		$em= $this->getEntityManager();
		$em->createQuery("DELETE FROM AppBundle:TestAllocation ta WHERE ta.employerId = :id")
			->setParameters(array("id" => $id))->execute();
		$em->createQuery("DELETE FROM AppBundle:ExcelTestAllocation eta WHERE eta.employerId = :id")
			->setParameters(array("id" => $id))->execute();

		foreach($data['tests'] as $test) {
            $ta = new TestAllocation();
			$ta->setLinkId($test->getLinkId());
			$ta->setEmployerId($id);
			$em->persist($ta);
			$em->flush();
		} 
		
		foreach($data['exceltests'] as $test) {
            $eta = new ExcelTestAllocation();
			$eta->setTestId($test->getTestId()-1);	// Why does THIS one start numbering from 0?
			$eta->setEmployerId($id);
			$em->persist($eta);
			$em->flush();
		} 
	}
	
					
	//----------------------------------------------------------------------------------
	//  Get client credits data
	//----------------------------------------------------------------------------------
	
    public function getCreditsData($id)
    {	
		$credit = $this->getEntityManager()->createQuery(
			'SELECT c.credits, (select count(1) from AppBundle\Entity\Jobs j where j.employerId = :id) as consumed
				FROM AppBundle\Entity\Credit c where c.employerId = :id')
			->setParameters(array("id"=>$id))
            ->getResult();
		$credit = $credit[0];
		$credit['remaining'] = $credit['credits'] - $credit['consumed'];
		return $credit;
	}


	//----------------------------------------------------------------------------------
	//  Save Client credits data
	//----------------------------------------------------------------------------------
	
    public function saveCreditsData($id,$data)
    {	
		$credit = $this->getEntityManager()->getRepository('AppBundle\Entity\Credit')->findOneBy(array('employerId' => $id));
		//$credit = $credits[0];
		
		$amount = $credit->getCredits();
		if($data['addremove']=='Remove') $data['numcredits'] = -$data['numcredits'];
		$amount += $data['numcredits'];

		$credit->setCredits($amount);
		$credit->setModifiedOn(new \DateTime('now'));
		$em = $this->getEntityManager();
		$em->persist($credit);
		$em->flush();
	}


	//----------------------------------------------------------------------------------
	//  Fetch client options data
	//----------------------------------------------------------------------------------
	
    public function getOptionsData($id)
    {
		$id = floor($id);
		$result = array();
		$ret1 = $this->getEntityManager()->getRepository('AppBundle\Entity\SectionDefaults')->findOneBy(array('employerId' => $id));
		$result['checkabl'] = (is_object($ret1) and $ret1->getCheckabl()) ? true:false;
		$result['testabl'] = (is_object($ret1) and $ret1->getTestabl()) ? true:false;
		$result['personabl'] = (is_object($ret1) and $ret1->getPersonabl()) ? true:false;

		$ret2 = $this->getEntityManager()->getRepository('AppBundle\Entity\Employers')->findOneBy(array('id' => $id));
		$result['dbs'] = (is_object($ret2) and $ret2->getGbgOrganisationId()) ? true:false;
		
		$ret3 = $this->getEntityManager()->getRepository('AppBundle\Entity\CvCheck')->findOneBy(array('employerId' => $id));
		$result['cv'] = (is_object($ret3) and $ret3->getId()) ? true:false;
		return $result;
	}

	
	//----------------------------------------------------------------------------------
	//  Save client options data
	//----------------------------------------------------------------------------------
	
    public function saveOptionsData($id,$data)
    {
		foreach($data as $fld=>$val) {
			$data[$fld] = ($val==true) ? 1:0;
		}
		if($data['dbs']==1) $data['dbs']=123;

		$sql = "update section_defaults set checkabl=?, testabl=?, personabl=? where employer_id=$id";
		$this->execute($sql, array(
			$data['checkabl'],
			$data['testabl'],
			$data['personabl']
		));

		$sql = "update employers set gbg_organisation_id = {$data['dbs']} where id=$id";
		$this->execute($sql);
		
		if($data['cv']==0)
			$this->execute("delete from cv_check where employer_id=$id");
		else
			$this->execute("insert ignore into cv_check (employer_id) values($id)");
	}	

	
	
	//----------------------------------------------------------------------------------
	//  Determine if employer has been activated
	//----------------------------------------------------------------------------------
	
    public function activatedStatus($id)
    {	
		$wl = $this->getEntityManager()->getRepository('AppBundle\Entity\CssSchemes')->findOneBy(array('employer_id' => $id));
		$whitelabel = (!empty($wl) and !empty($wl->getDomain())) ? 'Yes':'No';

		$op = $this->getOptionsData($id);
		$options = ($op['checkabl']==true or $op['checkabl']==true or $op['checkabl']==true) ? 'Yes':'No';
		
		$sk = $this->getEntityManager()->getRepository('AppBundle\Entity\SkillsEmployer')->findOneBy(array('employerId' => $id));
		$skills = (is_object($sk) and $sk->getId()) ? 'Yes':'No';

//		$te = $this->getEntityManager()->getRepository('AppBundle\Entity\SkillsEmployer')->findOneBy(array('employerId' => $id));
//		$skills = (is_object($sk) and $sk->getId()) ? 'Yes':'No';

		$tests = 'No';
		$activated = 'No';
		$loggedon = 'No';
	
		$em = $this->getEntityManager();
//		$user_id = $this->getUser()->getId();
//        $result = $em->createQuery("SELECT mu.userId FROM MasterUser WHERE mu.UserId=:uid")
//			->setParameters(array("uid" => $user_id))
//          ->getResult();
//        return $result;
//		var_dump($result); die;
		
		return array(
			'whitelabel'	=> $whitelabel,
			'options'		=> $options,
			'skills'		=> $skills,
			'tests'			=> $tests,
			'activated'		=> $activated,
			'loggedon'		=> $loggedon,
		);
	}

	
}
