<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\FormAnswers;
use AppBundle\Entity\FormAnswersRepository;



class PoolQuestionsRepository extends EntityRepository
{
	//----------------------------------------------------------------------------------
	//  Update question count (called after add/delete of form questions)
	//----------------------------------------------------------------------------------

	public function updateQuestionCount($pool_id)
	{
		$em= $this->getEntityManager();

		$rec = $em->createQuery('SELECT COUNT(1) AS c FROM AppBundle:PoolQuestions f WHERE f.poolId=:poolId')
			->setParameters(array("poolId"=>$pool_id))
			->getResult();
		$count = $rec[0]['c'];
		
		$em->createQuery("UPDATE AppBundle:Pools p SET p.numQuestions = :c WHERE p.id = :id")
			->setParameters(array('c'=>$count, 'id'=>$pool_id))
			->getResult();

	}
	
	
	//----------------------------------------------------------------------------------
	//  Sort questions (according to how they were dragged)
	//----------------------------------------------------------------------------------
	
	public function sortQuestions($pool_id, $positions)
	{
		$pos=1;
		$arr_pos = explode(",",$positions);
		
		// TODO: Verify user is a client (employer)
		// TODO: Verify that this pool belongs to this employer

		foreach($arr_pos as $p)
		{
			$id = substr($p,1);
			if($id==0) continue;
			$this->getEntityManager()->createQuery("UPDATE AppBundle:PoolQuestions pq SET pq.seq=$pos WHERE pq.poolId=$pool_id AND pq.id=$id")->execute();
			$pos++;
		}
	}
}

	