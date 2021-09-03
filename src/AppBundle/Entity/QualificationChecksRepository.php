<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class QualificationChecksRepository extends EntityRepository
{



    public function getQualStatusByUser ($applicantId, $jobUniqueId)
    {
        /**
         * @var ApplicantShare $applicantShare
         */
        $em= $this->getEntityManager();
        $user = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$applicantId]);
        $job =$em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid'=>$jobUniqueId]);
        $qualificationCheck = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['jobCode'=>$jobUniqueId, 'userId'=>$applicantId, 'checkType'=>'Qualifications']);

        return $qualificationCheck;

    }

    public function saveQualificationCheck ($qualUniqueCode, $shortUrl, $userId, $jobId, $employerId, $user)
    {
        $em = $this->getEntityManager();
        $result = $em->getRepository('AppBundle:QualificationChecks')->findOneBy(['userId'=>$userId,'jobId'=>$jobId]);
        $userEntity = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$userId]);
        $jobEntity = $em->getRepository('AppBundle:Jobs')->findOneBy(['id'=>$jobId]);

        if(isset($result)){
            return $result->getShortUrl();
        } else {

            $qc = new QualificationChecks();
            $qc->setUserId($userEntity);
            $qc->setJobId($jobEntity);
            $qc->setEmployerId($employerId);
            $qc->setCreatedBy($user);
            $qc->setShortUrl($shortUrl);
            $qc->setToken($qualUniqueCode);
            $em->persist($qc);

            $em->flush();
        }
        return $shortUrl;

    }
}
