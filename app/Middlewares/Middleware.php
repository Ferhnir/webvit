<?php

namespace App\Middlewares;

class Middleware 
{

    protected $ci;

    public function __construct($ci) 
    {
        $this->ci = $ci;
    }
}
?>