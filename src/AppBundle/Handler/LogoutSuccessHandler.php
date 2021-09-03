<?php

namespace AppBundle\Handler;

use AppBundle\Model\Whitelabel;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{

    private $whiteLabel;

    public function __construct(Whitelabel $whitelabel)
    {
        $this->whiteLabel = $whitelabel;
    }

    public function onLogoutSuccess(Request $request)
    {
        return new RedirectResponse('/');
    }
}