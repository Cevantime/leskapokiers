<?php

namespace App\Validator;

use App\Entity\Artist;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ArtistNameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\ArtistName */

        if (null === $value || '' === $value) {
            return;
        }

        /** @var Artist $value */
        // TODO: implement the validation here
        if( ! $value->getPseudonym() && ( ! $value->getFirstname() || $value->getLastname())) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();

        }
    }
}
