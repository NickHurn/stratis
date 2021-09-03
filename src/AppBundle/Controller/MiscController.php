<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Repository;
use Doctrine\ORM\Entity;


class MiscController extends Controller
{
    /**
     * @Route("/misc", name="misc")
     */
    public function miscAction(Request $request)
    {
		print "<a href='/misc/fixurls'>Fix Short Urls</a><br/>";
		die;
	}
	
	
	/**
     * @Route("/misc/fixurls", name="misc_fixurls")
     */
    public function fixurlsAction(Request $request)
    {
		$domain = $_SERVER['HTTP_HOST'];
		$em = $this->getDoctrine()->getManager();
		$jobs = $em->getRepository('AppBundle:Jobs')->findAll();
		foreach($jobs as $job)
		{
			print $job->getId() . " -- " . $job->getUniqueId() . ' -- bitly '. $job->getShortUrl();
			$url = "https://".$domain."/jobs/apply/id/".$job->getUniqueId();
			$tmp = 'https://api-ssl.bitly.com/v3/shorten?access_token=f2fbe310594e4e296fd89de2de630143e5db2c48&format=txt&longUrl='.urlencode($url);
			print "$tmp";
			/*
			$short_url = file_get_contents($tmp);
			print "changed to $short_url <br/>";
			$job->setShortUrl($short_url);
			$em->persist($job);
			$em->flush();
it wasit			 */
		}
		die("DONE");
	}
	
	/**
     * @Route("/misc/test", name="misc_test")
     */
    public function testAction(Request $request)
    {
		return $this->render('@App/misc/test.html.twig', array(
		));
	}

}
