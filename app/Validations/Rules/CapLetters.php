<?php

namespace App\Validations\Rules;

use Respect\Validation\Rules\AbstractRule;
use Respect\Validation\Exceptions\ComponentException;

class CapLetters extends AbstractRule
{

    public $numOfCapitals;
    public $field_name;

    public function __construct($numOfCapitals, $field_name)
    {
        $this->numOfCapitals = $numOfCapitals;
        $this->field_name = ucfirst($field_name);
    }

    public function validate($input)
    {
        preg_match_all('/[A-Z]/', $input, $count);
        $numOfCapitals = count($count[0]);
        return $numOfCapitals >= $this->numOfCapitals;
    }

}