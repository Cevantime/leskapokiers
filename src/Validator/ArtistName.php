<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ArtistName extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Vous devez fournir un pseudonym ou bien un couple nom/prénom.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
