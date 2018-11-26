<?php

namespace App\Validations\Rules;

use Respect\Validation\Rules\AbstractRule;
use Respect\Validation\Exceptions\ComponentException;

class SpecSigns extends AbstractRule
{

    public $numOfSpec;

    public function __construct($numOfSpec)
    {
        $this->numOfSpec = $numOfSpec;
    }

    public function validate($input)
    {
        preg_match_all('/[\W]+/', $input, $count);
        $numOfSpec = count($count[0]);

        return $numOfSpec >= $this->numOfSpec;        
    }

}