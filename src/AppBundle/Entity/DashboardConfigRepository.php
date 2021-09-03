<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DashboardConfigRepository extends EntityRepository
{

	//---------------------------------------------------------------------------
	//  Retrieve dashboard widget size/positions
	//  (this will create an entry if none exists)
	//---------------------------------------------------------------------------
	
	public function getDashboardLayout($user_id, $overview=true)
	{
		$user_id = floor($user_id);
		$em = $this->getEntityManager();
		$dash = $em->getRepository('AppBundle:DashboardConfig')->findOneBy(array('userId' => $user_id));
		
		//  If record not found, create default one
		if(!$dash)
		{
			$overview = '["",["1","7","0","3","2"],["1","4","2","3","3"],["1","4","0","3","2"],["1","0","2","2","2"],["1","0","0","2","2"],["1","0","4","4","1"],["1","7","2","3","1"],["1","2","2","2","2"],["1","7","4","3","1"],["1","2","0","2","2"],["1","7","3","3","1"]]';
			$detail = '["",["1","3","0","3","2"],["1","0","0","3","4"],["1","8","3","2","1"],["1","6","0","2","2"],["1","3","2","3","2"],["1","6","2","2","2"],["1","8","2","2","1"],["1","8","0","2","2"],["1","3","4","4","1"],["1","0","4","3","1"],["1","7","4","3","1"]]';
			$dash = new DashboardConfig();
			$dash->setUserId($user_id);
			$dash->setOverviewConfig($overview);
			$dash->setDetailConfig($detail);
			$em->persist($dash);
			$em->flush();
		}
		
		if($overview==true) $data = $dash->getOverviewConfig(); else $data = $dash->getDetailConfig();
		return json_decode($data,true);
		// Data is stored in an array of the format: widgetId=[enabled,x,y,width,height]
	}


	//---------------------------------------------------------------------------
	//  Save dashboard widget info
	//---------------------------------------------------------------------------

	public function saveDashboardLayout($user_id, $overview=true, $data)
	{
		$data = json_encode($data);
		$user_id = floor($user_id);
		
		$em = $this->getEntityManager();
		$dash = $em->getRepository('AppBundle:DashboardConfig')->findOneBy(array('userId' => $user_id));
		if(!$dash)
		{
			$dash = new DashboardConfig();
			$dash->setUserId($user_id);
		}
		if($overview==true) $dash->setOverviewConfig($data); else $dash->setDetailConfig($data);
		$em->persist($dash);
		$em->flush();
	}
}