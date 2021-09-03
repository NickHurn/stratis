<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class ReferenceRequestsRepository extends EntityRepository
{
    public function getReferences($user_id, $employer_id)
    {
        $em = $this->getEntityManager();
        $params = [];
        $params[] = $employer_id;
        $dql = 'select  uj.id, u.firstname, u.surname, j.title, r.company, r.name, r.email
        from AppBundle:ReferenceRequest rr
        join AppBundle:Reference r with r.referenceRequestId = rr.uniqueRef
        join AppBundle:UsersJob uj with uj.jobId = rr.jobId and uj.userId = rr.applicantId
        join AppBundle:Jobs j with j.uniqueid = uj.jobId
        join AppBundle:Users u with u.id = uj.userId
        where j.employerId =:employerId';
        if ($user_id > 0) {
            $dql .= ' and rr.applicantId =:userId';
        }
        $result = $em
            ->createQuery($dql)
            ->setParameters(array("employerId" => $employer_id, "userId" => $user_id))
            ->getResult();
        return $result;
    }
}
