<?php
/**
 * Created by PhpStorm.
 * User: sbaverstock
 * Date: 12/01/2017
 * Time: 09:57
 */

namespace FormBundle\Validator\Constraints;

use AppBundle\Entity\Users;
use Doctrine\ORM\EntityManager;
use FormBundle\Entity\Fields\IntegerField;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FilterOnValidator extends ConstraintValidator
{

    /**
     * @param $field
     * @param Constraint $constraint
     */
    public function validate($field, Constraint $constraint)
    {

        if ($field->getFilterable() === 1 && ($field->getFilterOn() <= 0 || is_null($field->getFilterOn()))) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }


        if(get_class($field) == 'FormBundle\Entity\Fields\NumberRangeField') {

            if ($field->getMax() <= $field->getMin()) {
                $this->context->buildViolation('The maximum must be higher than the minimum')
                    ->addViolation();
            }

            if ($field->getFilterable() === 1 && $field->getFilterOperator() == 'lt' && ($field->getFilterOn() <= $field->getMin())) {
                $this->context->buildViolation('The filter on must be higher than the minimum value')
                    ->addViolation();
            }

            if ($field->getFilterable() === 1 && $field->getFilterOperator() == 'lt' && ($field->getFilterOn() > $field->getMax())) {
                $this->context->buildViolation('The filter on must be lower than the maximum value')
                    ->addViolation();
            }

            if ($field->getFilterable() === 1 && $field->getFilterOperator() == 'gt' && ($field->getFilterOn() >= $field->getMax())) {
                $this->context->buildViolation('The filter on must be lower than the maximum value')
                    ->addViolation();
            }

            if ($field->getFilterable() === 1 && $field->getFilterOperator() == 'gt' && ($field->getFilterOn() < $field->getMin())) {
                $this->context->buildViolation('The filter on must be higher than the minimum value')
                    ->addViolation();
            }

            if ($field->getFilterable() === 1 && $field->getFilterOperator() == 'eq' && ($field->getFilterOn() < $field->getMin() || $field->getFilterOn() > $field->getMax())) {
                $this->context->buildViolation('The filter on must be between the maximum and minimum values')
                    ->addViolation();
            }
        }
    }

}