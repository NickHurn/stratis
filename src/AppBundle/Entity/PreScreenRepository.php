<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class PreScreenRepository extends EntityRepository
{
	//------------------------------------------------------------------------------------
	//  Get PreScreen score
	//------------------------------------------------------------------------------------
	
	public function getPreScreenScore($user_id, $job_id)
	{
		//  Find the form relating to the prescreen test for this job
		$form_id = $this->getPreScreenFormId($job_id);

		//  Find the test result for this form by this user
		$result = $this->getEntityManager()->createQuery("SELECT fc.percentage, fc.formId FROM AppBundle:FormCompleted fc WHERE fc.formId = :formid AND fc.userId = :userid")
			->setParameters(array("formid"=>$form_id, 'userid'=>$user_id))
			->getResult();
		if(empty($result[0]['percentage'])) return null;
		return $result;
	}	
	

	//------------------------------------------------------------------------------------
	//  Get PreScreen formId
	//------------------------------------------------------------------------------------

	public function getPreScreenFormId($job_id)
	{
		//  Find the form relating to the prescreen test for this job
		$result = $this->getEntityManager()->createQuery("SELECT f.id FROM AppBundle:Forms f WHERE f.jobId = :jobid AND f.formType='PRESCREEN' ")
			->setParameters(array("jobid"=>$job_id))
			->getResult();
		if(empty($result[0]['id'])) return null;
		$form_id = $result[0]['id'];
		return $form_id;
	}
		
	
	public function getPreScreenStatus ($applicantId, $jobUniqueId)
    {

        $em= $this->getEntityManager();
        $isPreScreeneRequired = $em->getRepository('AppBundle:UsersJob')->findOneBy(['userId'=>$applicantId, 'jobId'=>$jobUniqueId]);


        return $isPreScreeneRequired->getPreScreenPass();

    }

    public function getResults($jobUniqueId, $applicantId,$junior, $senior ){
        $em= $this->getEntityManager();
        $preScreen = $em->getRepository('AppBundle:PreScreen')->findOneBy(['userId'=>$applicantId, 'jobId'=>$jobUniqueId]);

        $jde = NULL;

        if(!is_null($preScreen)){

            if($jobUniqueId == $senior ){
                if ($preScreen->getJavaDevelopmentExperience() >= 5){
                    $jde = 'Pass';
                }else{
                    $jde = 'Fail';
                }
            }elseif ($jobUniqueId == $junior ){
                if ($preScreen->getJavaDevelopmentExperience() >= 1){
                    $jde = 'Pass';
                }else{
                    $jde = 'Fail';
                }
            }else{
                if ($preScreen->getJavaDevelopmentExperience() >= 1){
                    $jde = 'Pass';
                }else{
                    $jde = 'Fail';
                }
            }

            return [
                ['preScreen'=>'Number of years of professional java development experience?','answer'=>$preScreen->getJavaDevelopmentExperience(), 'result' =>$jde],
                ['preScreen'=>'Experience developing low-latency algorithms and systems?','answer'=>$preScreen->getLowLatencyExperience(),'result' => 'N/A'],
                ['preScreen'=>'Experience developing on the network layer?','answer'=>$preScreen->getNetworkLayerExperience(),'result' => 'N/A'],
                ['preScreen'=>'Knowledge and experience building lock-free algorithms?','answer'=>$preScreen->getLockFreeAlgorithmsExperience(),'result' => 'N/A'],
                ['preScreen'=>'Knowledge of fundamental linear algebra?','answer'=>$preScreen->getLinearAlgebraExperience(),'result' => 'N/A'],
                ['preScreen'=>'Experience dealing with high frequency, real time data feeds such as Market Data or Telemetry systems?','answer'=>$preScreen->getTelemetrySystemsExperience(),'result' => 'N/A'],
                ['preScreen'=>'Experience with C/C++?','answer'=>$preScreen->getCExperience(),'result' => 'N/A'],
                ['preScreen'=>'Database Experience (preferably SQL)?','answer'=>$preScreen->getDatabaseExperience(),'result' => ($preScreen->getDatabaseExperience() >= 1 ? 'Pass' : 'Fail' )],

            ];
        }
        return [];
    }

    public function getPreScreenDetails($user_id, $employer_id)
    {
        $em = $this->getEntityManager();
        $params = [];
        $params[] = $employer_id;
        $dql = 'select u.id, u.firstname, u.surname, j.title, ps.javaDevelopmentExperience, ps.lowLatencyExperience, ps.networkLayerExperience, ps.lockFreeAlgorithmsExperience, ps.linearAlgebraExperience, ps.linearAlgebraExperience, ps.TelemetrySystemsExperience, ps.cExperience, ps.databaseExperience
                from AppBundle:PreScreen ps
                join AppBundle:UsersJob uj with uj.jobId = ps.jobId and uj.userId = ps.userId
                join AppBundle:Jobs j with j.uniqueid = uj.jobId
                join AppBundle:Users u with u.id = uj.userId
                where j.employerId =:employerId';
        if ($user_id > 0) {
            $dql .= ' and uj.userId =:userId';
        }
        $result = $em
            ->createQuery($dql)
            ->setParameters(array("employerId" => $employer_id, "userId" => $user_id))
            ->getResult();
        return $result;
    }


}
