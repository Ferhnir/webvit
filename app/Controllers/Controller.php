<?php

namespace App\Controllers;

class Controller 
{

    protected $ci;  

    public function __construct($ci) 
    {
        $this->ci = $ci;  
    }

    public function __get($property)
    {
        if($this->ci->{$property}){
            return $this->ci->{$property};
        }
    }

    protected function getPathFor($pathName){
        return $this->ci->get("router")->pathFor($pathName);
    }

}
?>
