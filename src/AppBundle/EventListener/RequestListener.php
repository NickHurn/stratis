<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Role;
use AppBundle\Entity\Users;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class RequestListener
{

    public function __construct($em, TokenStorage $tokenStorage, Router $router, Container $container)
    {
        $this->em = $em;
        $this->tokenstorage = $tokenStorage;
        $this->router = $router;
        $this->container = $container;
    }


    public function onKernelRequest(GetResponseEvent $event )
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        if(!is_null($this->tokenstorage->getToken())){
            $user = $this->tokenstorage->getToken()->getUser();
            if($user instanceof Users){
				
				$allowed_urls = array(
					'/newpassword',
					'/css/custom.css',
					'/devphone/clear',
					'/devphone/check',
				);
				
                if($user->getTempPassword() == 1 && !in_array($this->router->getContext()->getPathInfo(), $allowed_urls)) {
                    $url = $this->router->generate('home_change_password');
                    $response = new RedirectResponse($url);
                    $event->setResponse($response);
                }

                /**
                 * @var $role Role
                 */
                //$roles = $user->getRoles();
                //foreach($roles as $role){
                //    if($role == 'ROLE_ADMIN'){
                //        if($this->router->getContext()->getPathInfo() == '/'){
                //            $url = $this->router->generate('admin');
                //            $response = new RedirectResponse($url);
                //            $event->setResponse($response);
                //        }
                //    }
                //}
            }
        }




        // ...
    }
}