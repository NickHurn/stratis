<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class ClassmarkerLinksRepository extends EntityRepository
{
    public Function completedTests($jobId, $userId)
    {

        $em= $this->getEntityManager();
        $result = $em
            ->createQuery(
                'SELECT cl.linkId, cl.linkName, cl.linkUrl, cl.testId,  clr.pointsScored, clr.pointsAvailable, clr.percentage
                FROM AppBundle:ClassmarkerLinks cl
                LEFT JOIN AppBundle:EmployersTests et WITH et.linkId = cl.linkId
                LEFT JOIN AppBundle:ClassmarkerLinkResults clr WITH clr.linkId = cl.linkId
                WHERE et.jobId = :jobId AND clr.cmUserId = :userId'
            )->setParameters(array("jobId" => $jobId, "userId"=> $userId))
            ->getResult();

        return $result;

    }
}
