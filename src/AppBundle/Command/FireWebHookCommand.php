<?php

namespace AppBundle\Command;

use AppBundle\Entity\UsersJob;
use AppBundle\Entity\WebHookLog;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FireWebHookCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:fire-webhooks')

            // the short description shown while running "php bin/console list"
            ->setDescription('Checks for new Webhooks and sends them')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This looks for new webhooks sends them and logs the response.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var $userJob UsersJob
         */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $usersJobs = $em->getRepository('AppBundle:UsersJob')->findBy(['accepted' => 1, 'webhookProcessed' => 0]);

        $output->writeln([
            'Processing '.count($usersJobs).' Users...',
        ]);

        foreach ($usersJobs as $userJob){
            $userId = $userJob->getUserId();
            $jobId = $userJob->getJobId();
            $user = $em->getRepository('AppBundle:CombinedUser')->find($userId);
            $job = $em->getRepository('AppBundle:Jobs')->findOneBy(['uniqueid' => $jobId]);
            $employer = $em->getRepository('AppBundle:Employers')->find($job->getEmployerId());
            $preScreen = $em->getRepository('AppBundle:PreScreen')->findOneBy(['jobId' => $job->getUniqueId()]);

            $data = [
                'user' => $user->toArray(),
                'prescreen' => $preScreen->getResults(),
                'job' => $job->getTitle()
            ];

            $ch = curl_init();

            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $employer->getWebHookUrl());
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CAINFO, 'C:\Sites\library\cacert.pem');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            if( ! $result = curl_exec($ch))
            {
                trigger_error(curl_error($ch));
            }

            $info = curl_getinfo($ch);

            $output->writeln([
                'Webhook returned status '.$info['http_code'],
            ]);

            $log = new WebHookLog();
            $log->setJob($job->getUniqueId());
            $log->setStatus($info['http_code']);
            $log->setUser($userId);
            $log->setEmployer($job->getEmployerId());
            $log->setUrl($employer->getWebHookUrl());
            $log->setResponse($result);

            $userJob->setWebhookProcessed(1);

            $em->persist($userJob);
            $em->persist($log);
            $em->flush();

            curl_close($ch);




        }

    }
}
