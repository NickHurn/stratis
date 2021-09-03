<?php

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;


class UsersRepository extends EntityRepository
{
    public function getUsersByEmployerId($employerId)
    {
        $em= $this->getEntityManager();
        $result = $em
            ->createQuery(
                'select u from AppBundle:Jobs j
                      INNER join AppBundle:UsersJob uj with j.uniqueid = uj.jobId
                      INNER JOIN AppBundle:Users u with u.id = uj.userId
                      WHERE j.employerId = :employerId'
            )->setParameters(array("employerId" => $employerId))
            ->getResult();
        return $result;

    }

    public function getUsersByemployersIdandUserId ($applicantIds, $employerId)
    {
        $em= $this->getEntityManager();
        $result = $em
            ->createQuery(
                'SELECT uj.userId as applicantId, j.id as jobId,j.title, uj.preScreenPass, uj.accepted, uj.offered, uj.rejected, u.firstname, u.surname, j.uniqueid as jobUniqueId, j.employerId
                FROM AppBundle:UsersJob uj
                Join AppBundle:Jobs j with uj.jobId = j.uniqueid
                join AppBundle:Users u with uj.userId = u.id
                WHERE j.employerId = :employerId and u.id in ('.$applicantIds.')'
            )->setParameters(array('employerId'=>$employerId))
            ->getResult();

        return $result;
    }

	
	//-----------------------------------------------------------
	//  Check email address is not already in use
	//-----------------------------------------------------------
	
	public function checkEmailIsUnique($email, $userid=0)
    {
        $em= $this->getEntityManager();
        $result = $em
            ->createQuery('SELECT COUNT(1) AS c FROM AppBundle:Users u WHERE u.emailaddress = :email AND u.id <> :id')
            ->setParameters(array('email'=>$email, 'id'=>$userid))
            ->getResult();
		return ($result[0]['c']==0) ? true : false;
	}


	//-----------------------------------------------------------
	//  Get staff list
	//-----------------------------------------------------------
	
	public function getStaffList($employer_id)
    {
        $em= $this->getEntityManager();
		$staff = $em->getRepository('AppBundle:Users')->findBy(['employerId'=>$employer_id], array('firstname'=>'ASC', 'surname'=>'ASC'));
		return $staff;
	}


	//-----------------------------------------------------------
	//  Delete User (providing is for same emplloyer and is not self)
	//-----------------------------------------------------------
	
	public function deleteUser($id, $employer_id, $myid)
    {
        $em= $this->getEntityManager();
		$staff = $em->getRepository('AppBundle:Users')->findBy(['employerId'=>$employer_id], array('firstname'=>'ASC', 'surname'=>'ASC'));


		$obj->fetchItSomehow();
		$em->remove($obj);
		$em->flush();

		return $staff;
	}


	//-----------------------------------------------------------
	//  Set the reset url password (returns it)
	//-----------------------------------------------------------
	
	public function setResetUrl($id, $clear=false)
    {
        $em= $this->getEntityManager();
		$user = $em->getRepository('AppBundle:Users')->findOneBy(['id'=>$id]);

		$reset = ($clear) ? null : substr(md5($id.time(),0,25));
		$user->setReset($reset);
		$em->persist($user);
		$em->flush();
		return $reset;
	}

	
	//-----------------------------------------------------------
	//  Clear the reset url password
	//-----------------------------------------------------------
	
	public function clearResetUrl($id)
    {
		$this->setResetUrl($id, true);
	}

	
	//-----------------------------------------------------------
	//  Log on a user using their reset code
	//-----------------------------------------------------------
	
	public function loginViaUrl($resetcode)
    {
        $em= $this->getEntityManager();
		$user = $em->getRepository('AppBundle:Users')->findOneBy(['reset'=>$resetcode]);
		if(!$user) return false;
		
		$user->setReset(null);
		$user->setTempPassword(1);
		$em->persist($user);
		$em->flush();
		return $user;
	}

    public function getAllUserData($employer_id, $user_id){
        $em= $this->getEntityManager();
            $dql = 'select u.id, u.firstname, u.surname, u.hometel, u.mobiletel, u.emailaddress, ad.line1, ad.line2, ad.line3, ad.town, ad.county, ad.postcode   
                FROM AppBundle:Users u 
                join AppBundle:Address ad with ad.userid = u.id
                join AppBundle:UsersJob uj with uj.userId = u.id
                join AppBundle:Jobs j with j.uniqueid = uj.jobId
                where j.employerId =:employerId';
            if($user_id > 0) {
                $dql .= ' and uj.userId =:userId';
            }
            $dql.=' GROUP BY u.id, u.firstname, u.surname, u.hometel, u.mobiletel, u.emailaddress, ad.line1, ad.line2, ad.line3, ad.town, ad.county, ad.postcode';
            $result = $em
                ->createQuery($dql)
                ->setParameters(array("employerId" => $employer_id, "userId"=>$user_id))
                ->getResult();
        return $result;
    }
    public function getUsersTestResults($user_id, $employer_id)
    {
        $em= $this->getEntityManager();
        $params = [];
        $params[] = $employer_id;

        $dql = 'select clr.pointsScored, clr.pointsAvailable, clr.pointsScored, clr.pointsAvailable, clr.timeStarted, clr.timeFinished, clr.duration,  cl.linkName
                from AppBundle:ClassmarkerLinkResults clr
                inner join AppBundle:ClassmarkerLinks cl with cl.linkId = clr.linkId
                inner join AppBundle:Users u with u.id = clr.cmUserId
                inner join AppBundle:UsersJob uj with uj.userId = clr.cmUserId
                inner join AppBundle:Jobs j with j.uniqueid = uj.jobId
                where j.employerId =:employerId
                ';
        if($user_id > 0)
        {
            $dql .=' and clr.cmUserId =:userId';
        }
        $dql .=' GROUP BY cl.linkName, clr.pointsScored, clr.pointsAvailable, clr.timeStarted,clr.timeFinished, clr.duration';
        $result = $em
            ->createQuery($dql
            )->setParameters(array("employerId" => $employer_id, "userId"=>$user_id))
            ->getResult();
        return $result;
    }


}
