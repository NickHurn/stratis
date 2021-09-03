<?php
// src/AppBundle/EventSubscriber/ExceptionSubscriber.php
namespace AppBundle\EventSubscriber;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Doctrine\ORM\EntityManager;

class LoginsuccessSubscriber implements EventSubscriberInterface
{
    public $domain;
    public $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->domain = $_SERVER['HTTP_HOST'];
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            SecurityEvents::INTERACTIVE_LOGIN => array(
                array('addCookie', 0),
            )
        );
    }

    public function addCookie(InteractiveLoginEvent $event)
    {
        $date = new \datetime('now +300 min');
        $user = $event->getAuthenticationToken()->getUser();
        $random = base64_encode(random_bytes(64));
        setcookie('UD2token', $random, $date->getTimestamp(), '/', '.'.$this->domain, true, true);

        $destination = $event->getRequest()->get('destination');
        try {
            $user->setRedirect($destination);
            $user->setToken($random);
            $user->setExpiry($date);
            $this->em->persist($user);
            $this->em->flush();
        } catch (\Exception $e) {
            die("user::flush/persist failed: " . $e->getMessage());
        }
    }


}