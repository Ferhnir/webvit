<?php

namespace App\Validations\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class CapLettersException extends ValidationException
{

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Must have minimum {{numOfCapitals}} capital letter(s)',
        ],
    ];

}