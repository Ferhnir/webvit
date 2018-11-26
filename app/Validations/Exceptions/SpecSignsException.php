<?php

namespace App\Validations\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class SpecSignsException extends ValidationException
{

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Must have minimum {{numOfSpec}} special character(s)',
        ],
    ];

}