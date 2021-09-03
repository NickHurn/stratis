<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class ReferenceRepository extends EntityRepository
{

    public function getReferenceStatusByUser ($applicantId, $jobUniqueId)
    {
        /**
         * @var ApplicantShare $applicantShare
         */
        $em= $this->getEntityManager();
        $ref = $em->getRepository('AppBundle:ReferenceRequest')->findOneBy(['applicantId'=>$applicantId, 'jobId'=>$jobUniqueId]);
        if (is_null($ref)){
            return  'Not Requested';
        }else{
            $refRcvd = $em->getRepository('AppBundle:Reference')->findBy(['referenceRequestId' => $ref->getId()]);
            if (empty($refRcvd)){
                return   'Requested';
            }else{
                if(count($refRcvd) == $ref->getNoOfReferences()){
                    return   'Received';
                }elseif (count($refRcvd) < $ref->getNoOfReferences()){
                    return   'Part Received';
                }
            }
        }
    }


}