<?php

namespace AppBundle\Command;

use AppBundle\Entity\ApplicantDisclosureData;
use AppBundle\Entity\Users;
use AppBundle\Model\Whitelabel;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Entity\ApplicantDisclosures;
use AppBundle\Model\Disclosures;




class DBSUpdateCommand extends ContainerAwareCommand
{
    /**
     * @var TwigEngine $template
     */
    private $template;

    /**
     * @var \Swift_Mailer $mailer
     */
    private $mailer;

    /**
     * @var Whitelabel $whitelabel
     */
    private $whitelabel;

    protected function configure()
    {
		$this
        ->setName('app:dbs-update')
        ->setDescription('Updates the status of pending DBS checks')
        ->setHelp('This command should be run hourly 09:00-17:00 and once between 23:00-04:00.')
		->addArgument('hour', InputArgument::OPTIONAL, 'Force run hour');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hour = $input->getArgument('hour');
		if(empty($hour)) $hour = date('G'); // 0-23

        $this->template = $this->getContainer()->get('templating');
        $this->mailer = $this->getContainer()->get('swiftmailer.mailer');
        $this->whitelabel = $this->getContainer()->get('app.whitelabel');

        $domain = $this->getContainer()->getParameter('disclosure_domain');
        $pin = $this->getContainer()->getParameter('disclosure_pin');
        $key = $this->getContainer()->getParameter('disclosure_sharedKey');


		$em = $this->getContainer()->get('doctrine')->getManager();
		$disclosure = new Disclosures($domain, $pin, $key);
		
		if($hour>=18 or $hour<8) {
			$recs = $em->getRepository('AppBundle:ApplicantDisclosures')->findBy(['gbg_status_code' => [7,10,11,12,14]]);
		} else {
			$recs = $em->getRepository('AppBundle:ApplicantDisclosures')->findBy(['gbg_status_code' => [0,1,2,3,4,5,6,8,9]]);
		}

		foreach($recs as $key=> $rec)
		{
            /**
             * @var ApplicantDisclosures $rec
             * @var Users $client
             * @var Users $applicant
             * @var ApplicantDisclosureData $applicantData
             */
		    $code = $rec->getCode();
			$result = $disclosure->getApplicationStatus($code);

            $this->whitelabel->setHost($rec->getEmployerId());
			$output->writeln(print_r($result));
            $result2 = null;

            $applicantData = $em->getRepository('AppBundle:ApplicantDisclosureData')->findOneBy(['applicant_id' => $rec->getApplicantId()]);
            $applicant = $em->getRepository('AppBundle:Users')->find($applicantData->getApplicantId());
            $client = $em->getRepository('AppBundle:Users')->find($rec->getEmployeeId());

            if(isset($result['ResultCode']) && $result['ResultCode'] === 110){
            	continue;
            }

            if($result['StatusId'] == 3){

                $htmlBody = $this->template->render(
                    '@App/Emails/dbs.application.failed.html.twig',
                    array('candidate' => $applicant->getName(), 'client' => $this->whitelabel->getWhiteLabel()->getCompanyName(), 'outcome' => $result2['DisclosureOutcome'], 'code' => $rec->getCode())
                );

                $output->writeln($applicant->getEmailaddress());

                $this->sendEmail('DBS Application Failed', $applicant->getEmailaddress(), $htmlBody);
                $rec->setHireablStatus('Started');
            }

            if($result['StatusId']==15) {
                $result2 = $disclosure->getApplicationDetails($code);
                $rec->setGbgOutcome($result2['DisclosureOutcome']);
                $rec->setGbgDisclosureNumber($result2['DisclosureNumber']);
                $htmlBody = $this->template->render(
                    '@App/Emails/dbs.outcome.html.twig',
                    array('candidate' => $applicant->getName(), 'client' => $client->getName(), 'outcome' => $result2['DisclosureOutcome'])
                );

                $output->writeln($client->getEmailaddress());

                $this->sendEmail('DBS Application Complete', $client->getEmailaddress(), $htmlBody);

            }

			// if the status code is 9 (Verify Failed), change agency_status = Started
			if($result['StatusId']==9) {
                $rec->setHireablStatus('Started');
                $htmlBody = $this->template->render(
                    '@App/Emails/dbs.verification.failed.html.twig',
                    array('candidate' => $applicant->getName(), 'client' => $client->getName())
                );

                $output->writeln($client->getEmailaddress());

                $this->sendEmail('DBS Verification Failed', $client->getEmailaddress(), $htmlBody);

			}
			// Update the gbg status field
			$rec->setGbgStatus($result['StatusName']);
            $rec->setGbgStatusCode($result['StatusId']);
			$rec->setStatusDate(new \DateTime('now'));
			$em->persist($rec);
			$em->flush();
		}

    }

    public function sendEmail($subject, $to, $htmlBody)
    {
        $bcc = $this->getContainer()->getParameter('bcc_to');

        $message = (new \Swift_Message($subject))
            ->setFrom('backgroundchecks@koine.com', 'Background Checks')
            ->setTo($to)
            ->setBcc($bcc)
            ->setBody($htmlBody, 'text/html');

        $this->mailer->send($message);
    }
}

