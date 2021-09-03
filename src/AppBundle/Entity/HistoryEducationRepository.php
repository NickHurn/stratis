<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class HistoryEducationRepository extends EntityRepository
{
    public function getEducationHistory($user_id, $employer_id)
    {
        $em = $this->getEntityManager();
        $params = [];
        $params[] = $employer_id;
        $dql = 'select  he.establishment,  he.courseTitle, he.startdate, he.enddate, uj.id, j.title, u.firstname, u.surname
        from AppBundle:HistoryEducation he 
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
