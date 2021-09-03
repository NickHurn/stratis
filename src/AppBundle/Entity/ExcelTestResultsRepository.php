<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class ExcelTestResultsRepository extends EntityRepository
{
    public function completedExcelResults ($jobId, $userId)
    {
        $em= $this->getEntityManager();
        $result = $em
            ->createQuery(
                'SELECT etr
                FROM AppBundle:ExcelTestResults etr
                JOIN AppBundle:ExcelTestsJobs etj WITH etj.testId = etr.testId
                WHERE etj.jobId = :jobId AND etr.userId = :userId'
            )->setParameters(array("jobId" => $jobId, "userId"=> $userId))
            ->getResult();

        return $result;




    }


}