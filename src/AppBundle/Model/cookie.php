<?php

namespace AppBundle\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;


class cookie
{
    /**
     * @var $requestStack RequestStack
     */
    private $requestStack;

    public function __construct( RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    public function checkCookie ()
    {


        $cookies = $this->requestStack->getCurrentRequest()->cookies->get('cookies_policy');
        if ($cookies == 'accepted') {
            $activetab = 'true';
        }else{
            $activetab = 'false';
        }






        return $activetab;
    }


}
