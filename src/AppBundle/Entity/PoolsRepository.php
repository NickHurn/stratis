<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class PoolsRepository extends EntityRepository
{
	//----------------------------------------------------------------------------------
	//  Retrieve list of pools for employer
	//----------------------------------------------------------------------------------

	public function getList($employer_id)
	{
		//  Get the list of pools 
        $result = $this->getEntityManager()
			->createQuery('SELECT p.id, p.poolName, p.numQuestions FROM AppBundle:Pools p WHERE p.employerId=:eid ORDER BY p.poolName')
            ->setParameters(array("eid"=>$employer_id))
			->getResult();
        return $result;
    }


	//----------------------------------------------------------------------------------
	//  Create pool (if it does not exist already)
	//  Returns an instance of the (new or existing) pool
	//----------------------------------------------------------------------------------
	
	public function createOrFetchPool($name, $employer_id)
	{
		$pool = $this->findOneBy(['poolName'=>$name,'employerId'=>$employer_id]);
		if(!$pool)
		{
			$em = $this->getEntityManager();
			$pool = new Pools();
			$pool->setPoolName($name);
			$pool->setEmployerId($employer_id);
			$pool->setNumQuestions(0);
			$em->persist($pool);
			$em->flush();
		}
		return $pool;
	}

}
