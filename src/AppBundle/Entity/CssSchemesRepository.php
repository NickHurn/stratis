<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class CssSchemesRepository extends EntityRepository
{
	public function getEmployerIdFromDomain()
    {
		$em= $this->getEntityManager();
		$stmt = $em->getConnection()->prepare("SELECT employer_id, company_name,domain FROM css_schemes WHERE domain=:d");
		$stmt->execute(array("d" => $_SERVER['HTTP_HOST']));
	    return $stmt->fetch();
    }
	
	
	public function getEmployerFromDomain()
    {
		$em = $this->getEntityManager();
		$css = $em->getRepository('AppBundle\Entity\CssSchemes')->findOneBy(['domain' => $_SERVER['HTTP_HOST']]);
	    return $css;
    }

}
