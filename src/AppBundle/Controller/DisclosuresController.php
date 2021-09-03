<?php

namespace AppBundle\Controller;
use AppBundle\Command\DBSUpdateCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Entity;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Repository;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\BufferedOutput;


class DisclosuresController extends Controller
{
	/**
	 * @Security("has_role('ROLE_CLIENT')")
     * @Route("/disclosures", name="disclosures_list")
	 * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
		$user = $this->getUser();
		$employer_id = $user->getEmployerId();
		$em = $this->getDoctrine()->getManager();

		$recs = $em->getRepository('AppBundle:ApplicantDisclosures')->getDisclosuresByEmployer($employer_id);
		//print "<pre>"; var_dump($recs); die;
		return $this->render('@App/disclosures/list.html.twig', array(
			'recs' => $recs,
		));
	}

    /**
     * @Security("has_role('ROLE_CLIENT')")
     * @Route("/applicantDisclosures/refreshStatus", name="disclosures_refresh_status")
     */
    public function disclosureRefreshStatusAction()
    {

        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array(
            'command' => 'app:dbs-update',
        ));

        $output = new BufferedOutput();
        $application->run($input, $output);

        // return the output, don't use if you used NullOutput()
        $content = $output->fetch();

        // return new Response(""), if you used NullOutput()
        return new Response($content);
    }


}
