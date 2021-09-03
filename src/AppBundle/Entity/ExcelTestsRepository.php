<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class ExcelTestsRepository extends EntityRepository
{

    public Function getExcelTestsByJob($jobId){

        $em= $this->getEntityManager();
        $result = $em
            ->createQuery(
                'SELECT et
                FROM AppBundle:ExcelTests et
                JOIN AppBundle:ExcelTestsJobs etj WITH et.testId = etj.testId
                WHERE etj.jobId = :jobId'
                )->setParameters(array("jobId" => $jobId))
            ->getResult();

        return $result;

    }


}