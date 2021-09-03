<?php

namespace AppBundle\Model;

use AppBundle\Entity\CssSchemes;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;

class Whitelabel
{
    /**
     * @var $em ObjectManager
     */
    private $em;

    /**
     * @var string
     */
    private $host;

    /**
     * @var $requestStack RequestStack
     */
    private $requestStack;
    private $root;
	private $logopath;
	

    public function __construct(ObjectManager $em, RequestStack $requestStack, $root, $logopath)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
		if(!empty($_SERVER['HTTP_HOST'])) { $this->domain = $_SERVER['HTTP_HOST']; }
        $this->root = $root;
        $this->host = null;
		$this->logopath = $logopath;
    }

	
    public function getHost()
    {
        if (is_null($this->host)) {
            $this->setHost();
        }

        return $this->host;
    }

    public function setHost($host = null)
    {
        if (is_null($host)) {
            $request = $this->requestStack->getCurrentRequest();
            $this->host = $request->server->get('HTTP_HOST');
        } else {
            $css = null;
            $employer = $this->em->getRepository('AppBundle:Employers')->find($host);
            if (!is_null($employer)) {
                $css = $this->em->getRepository('AppBundle:CssSchemes')->findOneBy(['employer_id' => $host]);
            }
            if(is_null($css)) {
				$domain = $request->server->get('HTTP_HOST'); // $domain = substr($this->altDomain, 8);
                $this->host = $domain;
            } else {
                $this->host = $css->getDomain();
            }
        }
    }

    /**
     * @return \AppBundle\Entity\CssSchemes
     */
    public function getWhiteLabel()
    {

        $whitelabel = $this->em->getRepository('AppBundle:CssSchemes')->findOneBy(['domain' => $this->getHost()]);

        if(is_null($whitelabel)){
            $whitelabel = new CssSchemes();
            $whitelabel->setCompanyName('Hireabl');
            $whitelabel->setContactNumber('01234 567890');
            $whitelabel->setFooterCoName('Copyright. Hireabl.com');
            $whitelabel->setDomain($this->domain);
            $whitelabel->setHeaderBackground('#f3c412');
            $whitelabel->setHeaderBackgroundAdmin('#3c8dbc');
            $whitelabel->setFooterBackground('#f3c412');
            $whitelabel->setFooterBackgroundAdmin('#3c8dbc');
            $whitelabel->setHeaderLogo('default_logo.png');
            $whitelabel->setHeaderLogoAdmin('default_logo.png');
        }
        return $whitelabel;
    }


	public function getDomain()
	{
		$request = $this->requestStack->getCurrentRequest();
		$domain = $request->server->get('HTTP_HOST');
		$filename = $this->logopath . $domain . '_logo.png';
		if(!file_exists($filename)) $domain='default';
		return $domain;
	}


	public function getCompanyName()
	{
		$whitelabel = $this->em->getRepository('AppBundle:CssSchemes')->findOneBy(['domain' => $this->getHost()]);
		if(!$whitelabel) return '';
		return $whitelabel->getCompanyName();
	}

	
	/**
     * @param $whitelabel CssSchemes
     */
    public function checkCSS($whitelabel)
    {
		print "<pre>checkCSS() called";
		debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		die();
	}
}
