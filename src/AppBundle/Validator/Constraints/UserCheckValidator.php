<?php
/**
 * Created by PhpStorm.
 * User: sbaverstock
 * Date: 12/01/2017
 * Time: 09:57
 */

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Users;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UserCheckValidator extends ConstraintValidator
{

    /**
     * @var $em EntityManager
     */
    private $em;

    /**
     * @var $User Users
     */
    private $cUser;

    /**
     * UserCheckValidator constructor.
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     */

    public function __construct(EntityManager $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->cUser = $tokenStorage->getToken()->getUser();
    }

    /**
     * @param $username string
     * @param Constraint $constraint
     */
    public function validate($username, Constraint $constraint)
    {
        $user = $this->em->getRepository('AppBundle:Users')->findOneBy(['emailaddress' => $username]);

        if (!is_null($user) && $user->getEmailaddress() != $this->cUser->getEmailaddress()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $username)
                ->addViolation();
        }
    }

}