<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class HistoryEmploymentRepository extends EntityRepository
{
    public function getEmploymentHistory($user_id, $employer_id)
    {
        $em = $this->getEntityManager();
        $params = [];
        $params[] = $employer_id;
        $dql = 'select uj.id, u.firstname, u.surname,j.title, he.title as old_title, he.description, he.startdate, he.enddate
        from AppBundle:HistoryEmployment he 
        join AppBundle:UsersJob uj with uj.jobId = he.jobId and uj.userId = he.userId
        join AppBundle:Jobs j with j.uniqueid = uj.jobId
        join AppBundle:Users u with u.id = uj.userId
        where j.employerId =:employerId';
        if ($user_id > 0) {
            $dql .= ' and he.userId =:userId';
        }
        $result = $em
            ->createQuery($dql)
            ->setParameters(array("employerId" => $employer_id, "userId" => $user_id))
            ->getResult();
        return $result;


    }


}
