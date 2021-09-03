<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class IdChecksRepository extends EntityRepository
{
    public function getIdCheckStatusByUser ($applicantId, $jobUniqueId){

        /**
         * @var ApplicantShare $applicantShare
         */
        $em = $this->getEntityManager();
        $checkStatus = 'Not Requested';

        $extraChecks = $em->getRepository('AppBundle:ExtraChecks')->findBy(['userId' => $applicantId, 'jobCode'=>$jobUniqueId]);
        foreach ($extraChecks as $ec) {
            $type = explode("/", $ec->getCheckType());
            if ($type[0] == 'IDENTITY'){
                if ($ec->getStatus() == 'Completed') {
                    if ($checkStatus != 'Waiting for Candidate') {
                        $checkStatus = $ec->getResult();
                    }
                } else {
                    $checkStatus = 'Waiting for Candidate';
                }
            }
        }
        return $checkStatus;
    }

    public function getKycCheckStatusByUser ($applicantId, $jobUniqueId){

        /**
         * @var ApplicantShare $applicantShare
         */
        $em = $this->getEntityManager();
        $sql = "SELECT ec FROM AppBundle:ExtraChecks ec 
            WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'KYC/%'
        ";

        $result = $em->createQuery($sql)->setParameters(array("jcode" => $jobUniqueId,"uid" => $applicantId))->getResult();
        return $result;
    }

	
    public function saveIdCheck ($idUniqueCode, $shortUrl, $userId, $jobId, $employerId, $gbgProfile)
    {

        $em = $this->getEntityManager();
        $idc = new idChecks;
        $idc->setUserId($userId);
        $idc->setJobId($jobId);
        $idc->setUniqueId($idUniqueCode);
        $idc->setShortUrl($shortUrl);
        $idc->setCreatedBy($employerId);
        $idc->setProfile($gbgProfile);
		$idc->setDirectorStatus('PENDING');
        $em->persist($idc);
        $em->flush();
        return $shortUrl;
    }

	
	public function getDirectorChecksByEmployer ($employer_id)
	{
		$em= $this->getEntityManager();
        $result = $em
            ->createQuery(
                'SELECT idc.userId, idc.jobId, j.title, u.firstname, u.surname, idc.director_status, idc.directorships, idc.director_links
                FROM AppBundle:IdChecks idc
                JOIN AppBundle:Jobs j WITH idc.jobId = j.uniqueid 
				JOIN AppBundle:Users u WITH  idc.userId = u.id 
                WHERE idc.director_status IS NOT NULL AND j.employerId = ?1
				ORDER BY j.title, u.firstname, u.surname')
            ->setParameters(array(1 => $employer_id))
            ->getResult();

        return $result;
	}

    public function getPreviousExtraChecks ($user, $job_code)
    {
        $em = $this->getEntityManager();
        $sql = "SELECT ec FROM AppBundle:ExtraChecks ec 
            WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'DBS/%'
        ";
        $dbs = $em->createQuery($sql)->setParameters(array("jcode" => $job_code,"uid" => $user))->getResult();
        if ($dbs){
            $dbs = $dbs[0];
        }
        $sql = "SELECT ec FROM AppBundle:ExtraChecks ec 
            WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'KYC/%'
        ";
        $kyc = $em->createQuery($sql)->setParameters(array("jcode" => $job_code,"uid" => $user))->getResult();
        if ($kyc){
            $kyc = $kyc[0];
        }
        $sql = "SELECT ec FROM AppBundle:ExtraChecks ec 
            WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'IDENTITY/%'
        ";
        $identity = $em->createQuery($sql)->setParameters(array("jcode" => $job_code,"uid" => $user))->getResult();
        $passport = false;
        $driving = false;
        foreach ($identity  as $i ){
            if ($i->getCheckType() == "IDENTITY/Passport"){
                $passport = true;
            }
            if ($i->getCheckType() == "IDENTITY/Driving"){
                $driving = true;
            }
        }

        $sql = "SELECT ec FROM AppBundle:ExtraChecks ec 
            WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'Finance/%'
        ";
        $finance = $em->createQuery($sql)->setParameters(array("jcode" => $job_code,"uid" => $user))->getResult();
        $personal=false;
        $credit = false;
        foreach ($finance  as $f ){
            if ($f->getCheckType() == "Finance/Personal"){
                $personal = true;
            }
            if ($f->getCheckType() == "Finance/Credit"){
                $credit = true;
            }
        }
        $qualifications = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['jobCode'=>$job_code, 'userId'=>$user, 'checkType'=>'Qualifications']);
        $memberships = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['jobCode'=>$job_code, 'userId'=>$user, 'checkType'=>'Memberships']);
        $director = $em->getRepository('AppBundle:ExtraChecks')->findOneBy(['jobCode'=>$job_code, 'userId'=>$user, 'checkType'=>'Director']);



        $result =[
            'DBS'=>$dbs,
            'IDENTITY'=>['passport'=>$passport,'driving'=>$driving ],
            'KYC'=>$kyc,
            'Finance'=>['personal'=>$personal,'credit'=>$credit],
            'Qualifications'=>['qualifications'=>$qualifications,'membership'=>$memberships],
            'Director'=>$director,
        ];

        return $result;
    }
}

