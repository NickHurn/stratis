<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class ApplicantShareRepository extends EntityRepository
{

    public function addNewShare ($applicantId, $email, $employerId,$jobId)
    {
            $currentDateTime = time();
            $uniqueId = md5($applicantId.$email.$jobId.$currentDateTime);
            $em = $this->getEntityManager();
            $newShare = new ApplicantShare();
            $newShare->setApplicantId($applicantId);
            $newShare->setEmail($email);
            $newShare->setEmployerId($employerId);
            $newShare->setJobId($jobId);
            $newShare->setUniqueId($uniqueId);
            $em->persist($newShare);
            $em->flush();

            return $uniqueId;
    }

    public function getApplicationSharesByEmployerId ($employerId)
    {
        $em= $this->getEntityManager();
        $result = $em
            ->createQuery(
                'SELECT ap.email, ar.rating, ar.notes,ar.id as ratingId, ap.applicantId, ap.createdOn, j.id as jobId, j.uniqueid as uniqueJobId, j.title, u.firstname, u.surname
                FROM AppBundle:ApplicantShare ap
                JOIN AppBundle:Jobs j WITH ap.jobId = j.uniqueid
                JOIN AppBundle:Users u WITH ap.applicantId = u.id 
                LEFT JOIN AppBundle:ApplicantRating ar with ap.uniqueId  = ar.uniqueId
                WHERE ap.employerId = :employerId
                ORDER BY ap.applicantId ASC '
                )->setParameters(array("employerId" => $employerId))
            ->getResult();
        return $result;
    }

    public function getAllSharesByEmployerId ($employerId)
    {
        $em= $this->getEntityManager();
        $result = $em
            ->createQuery(
                'SELECT ap.email, ar.rating, ar.notes, ar.id as ratingId, ap.applicantId, ap.createdOn, j.id as jobId, j.title, u.firstname, u.surname, ap.uniqueId
                FROM AppBundle:ApplicantShare ap
                JOIN AppBundle:Jobs j WITH ap.jobId = j.uniqueid
                JOIN AppBundle:Users u WITH ap.applicantId = u.id 
                LEFT JOIN AppBundle:ApplicantRating ar with ap.uniqueId  = ar.uniqueId
                where ap.employerId =:employerId'
            )->setParameters(array("employerId" => $employerId['employer']))
            ->getResult();
        return $result;
    }





        public function getSharedApplicantsDetails ($employerId)
    {
        $data = $this->getApplicationSharesByEmployerId($employerId);

        $id =0;
        $jobId = NULL;

        $sharedData =[];
        foreach ($data as $key=>$d) {
            $sharedData[$d['applicantId']][$d['jobId']]['header']['id'] = $id++;
            $sharedData[$d['applicantId']][$d['jobId']]['header']['applicantId'] =$d['applicantId'];
            $sharedData[$d['applicantId']][$d['jobId']]['header']['applicant'] = $d['firstname'].' '.$d['surname'];
            $sharedData[$d['applicantId']][$d['jobId']]['header']['title'] = $d['title'];
            $sharedData[$d['applicantId']][$d['jobId']]['header']['jobId'] = $d['uniqueJobId'];

            $sharedData[$d['applicantId']][$d['jobId']]['data'][] = [
                'createdOn'=>$d['createdOn'],
                'email'=>$d['email'],
                'rating'=>$d['rating'],
                'notes'=>$d['notes'],
                'ratingId'=>$d['ratingId']
            ];

            if (!is_null( $d['rating'])) {

                if (isset($sharedData[$d['applicantId']][$d['jobId']]['header']['ratingCount'])) {

                    $sharedData[$d['applicantId']][$d['jobId']]['header']['ratingCount'] = $sharedData[$d['applicantId']][$d['jobId']]['header']['ratingCount'] + 1;
                    $sharedData[$d['applicantId']][$d['jobId']]['header']['ratingSum'] = $sharedData[$d['applicantId']][$d['jobId']]['header']['ratingSum'] + $d['rating'];

                } else {

                    $sharedData[$d['applicantId']][$d['jobId']]['header']['ratingCount'] = 1;
                    $sharedData[$d['applicantId']][$d['jobId']]['header']['ratingSum'] = $d['rating'];

                }
                $sharedData[$d['applicantId']][$d['jobId']]['header']['avgRating'] = $sharedData[$d['applicantId']][$d['jobId']]['header']['ratingSum'] / $sharedData[$d['applicantId']][$d['jobId']]['header']['ratingCount'];
            }
        }

        return $sharedData;
    }

    public function getSharedApplicantsRatingsAndNotes ($userId, $uniqueJobId,$employerId)
    {
        $rating = [];
        $ratingCount = 0;
        $ratingTotal = 0;
        $notes = [];
        $avgRating=0;
        $em= $this->getEntityManager();
        $usersRating = $em->getRepository('AppBundle:ApplicantRating')->findBy(['applicantId'=>$userId,'employerId'=>$employerId, 'jobId'=>$uniqueJobId ]);
        if (!is_null($usersRating)) {
            foreach ($usersRating as $us) {
                $shareDetails = $em->getRepository('AppBundle:ApplicantShare')->findOneBy(['uniqueId'=>$us->getUniqueId()]);
                $ratingTotal = $ratingTotal + $us->getRating();
                if (!is_null($us->getRating())) {
                    $ratingCount++;
                }
                if (!is_null($us->getNotes())) {
                    $notes[] = [
                        'email' => $shareDetails->getEmail(),
                        'note' => $us->getNotes()
                    ];
                }
            }
            if ($ratingCount >0) {

                $ratingDescription='';

                $avgRating=$ratingTotal / $ratingCount;

                if ($avgRating >= 1 && $avgRating <2){
                    $ratingDescription = 'Unsatisfactory';
                }
                if ($avgRating >=2 && $avgRating <3){
                    $ratingDescription = 'Improvement Needed';
                }
                if ($avgRating >=3 && $avgRating <4){
                    $ratingDescription = 'Good';
                }
                if ($avgRating >= 4 && $avgRating <5){
                    $ratingDescription = 'Very Good';
                }
                if ($avgRating >= 5){
                    $ratingDescription = 'Outstanding';
                }


                $rating['rating'] = [
                    'sharedCount' => count($usersRating),
                    'ratingCount' => $ratingCount,
                    'ratingTotal' => $ratingTotal,
                    'avgRating' => $avgRating,
                    'ratingDescription'=>$ratingDescription,
                    'notes' => $notes
                ];
            }

        }

        return $rating;
    }

}