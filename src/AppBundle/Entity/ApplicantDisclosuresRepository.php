<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class ApplicantDisclosuresRepository extends EntityRepository
{
    public function getDisclosuresByUser ($applicantId, $jobUniqueId)
    {
        $em= $this->getEntityManager();
        $checkStatus = 'Not Requested';
        $extraChecks = $em->getRepository('AppBundle:ExtraChecks')->findBy(['userId' => $applicantId, 'jobCode'=>$jobUniqueId]);
        foreach ($extraChecks as $ec) {
            $type = explode("/", $ec->getCheckType());
            if ($type[0] == 'DBS'){
                return $ec;
            }
        }
        return null;
    }


	public function saveDbsCheck($applicantId, $jobId, $employerId, $userId, $shortUrl, $dbsCode)
    {
        $em= $this->getEntityManager();
        $result = $em->getRepository('AppBundle:ApplicantDisclosures')->findOneBy(['applicant_id'=>$applicantId, 'job_id'=>$jobId]);
        if(isset($result)){
            return $result->getShortUrl();
        }else{
            $dbs = new ApplicantDisclosures();
            $dbs->setApplicantId($applicantId);
            $dbs->setJobId($jobId);
            $dbs->setEmployerId($employerId);
            $dbs->setEmployeeId($userId);
            $dbs->setApplicantStatus('Not Started');
            $dbs->setHireablStatus('N/A');
            $dbs->setGbgStatus('N/A');
            $dbs->setCode($dbsCode);
            $dbs->setShortUrl($shortUrl);
            $em->persist($dbs);
            $ec = $em->createQuery(
                "SELECT ec.id FROM AppBundle:ExtraChecks ec WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'DBS/%' "
            )->setParameters(array('uid'=>$userId, 'jcode'=>$jobId))
                ->getResult();
            $extracheck = (!empty($ec[0]['id'])) ? true:false;
            if(!$extracheck)
            {
                $ec = new \AppBundle\Entity\ExtraChecks();
                $ec->setEmployerId($employerId);
                $ec->setUserId($applicantId);
                $ec->setJobCode($jobId);
                $ec->setCheckType('DBS/Basic');
                $ec->setDateRequested(new \DateTime("now"));
                $ec->setStatus('Waiting for Candidate');
                $em->persist($ec);
            }
            $em->flush();

        }
        return $shortUrl;
    }

	
	public function getDisclosuresByEmployer($employerId)
    {
        $em= $this->getEntityManager();
		$sql = "SELECT ad.applicant_status, ad.hireabl_status, ad.gbg_status, ad.gbg_outcome, u.firstname, u.surname, 
			ad.gbg_disclosure_number, ad.code, ad.status_date, j.title
			FROM AppBundle:ApplicantDisclosures ad
			LEFT JOIN AppBundle:Users u WITH ad.employeeId = u.id
			LEFT JOIN AppBundle:Jobs j WITH ad.job_id = j.uniqueid
			WHERE ad.employer_id = :eid";

		$result = $em->createQuery($sql)->setParameters(array("eid" => $employerId))->getResult();
        return $result;
	}

    public function getExtraCheck($user_id,$job_code)
    {
        $em= $this->getEntityManager();

        $sql = "SELECT ec.id FROM AppBundle:ExtraChecks ec 
            WHERE ec.jobCode = :jcode AND ec.userId = :uid AND ec.checkType LIKE 'DBS/%'
        ";

        $result = $em->createQuery($sql)->setParameters(array("jcode" => $job_code,"uid" => $user_id))->getResult();
        return $result;
    }






}
