<?php
/**
 * Created by PhpStorm.
 * User: sbaverstock
 * Date: 12/01/2017
 * Time: 09:54
 */

namespace FormBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FilterOn extends Constraint
{

    public $message = 'Filter On must be an integer greater than 0 if Filterable is set to \'Yes\'';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}