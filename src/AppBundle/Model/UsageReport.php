<?php
namespace AppBundle\Model;

use AppBundle\Entity\EmployersRepository;

class UsageReport
{
    public function __construct($em, $employerId, $startDate, $endDate)
    {
		$empRepository = $em->getRepository('AppBundle:Employers');
		$employer = $em->getRepository('AppBundle\Entity\Employers')->findOneBy(array('id' => $employerId));
		$clientName = $employer->getCompany();
		
		// Checkabl 
		//	- how many candidates pre-screened (OK)

		// Testabl (classmarker)
		//	- which tests used 
		//	- how many candidates tested for each test

		// Personabl (videos)
		//	- how many candidates (total)
		//	- How many questions (total)

		// Qualifications checks (OK)
		//	- how many checks
		//	- how many candidates


		ob_clean();
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=ClientUsageReport.txt');
		print "USAGE REPORT FOR CLIENT {$clientName} FROM {$startDate} TO {$endDate}\n";
		print "-----------------------------------------------------------------------------------\n\n";


		die;
	}
}