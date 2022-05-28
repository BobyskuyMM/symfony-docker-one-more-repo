<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SymbolExisting extends Constraint
{
    public $message = 'The "{{ string }}" it is not valid company symbol!';
    public $mode = 'strict';

    public function validatedBy()
    {
        return static::class.'Validator';
    }


}
