<?php

namespace App\Validations\Rules;

use Respect\Validation\Rules\AbstractRule;
use Respect\Validation\Exceptions\ComponentException;

class CapLetters extends AbstractRule
{

    public $numOfCapitals;

    public function __construct($numOfCapitals)
    {
        $this->numOfCapitals = $numOfCapitals;
    }

    public function validate($input)
    {
        preg_match_all('/[A-Z]/', $input, $count);
        $numOfCapitals = count($count[0]);
        return $numOfCapitals >= $this->numOfCapitals;
    }

}