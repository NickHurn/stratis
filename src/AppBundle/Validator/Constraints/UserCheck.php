<?php
/**
 * Created by PhpStorm.
 * User: sbaverstock
 * Date: 12/01/2017
 * Time: 09:54
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserCheck extends Constraint
{

    public $message = 'This email address "%string%" already exists in the system.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}