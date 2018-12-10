<?php

namespace App\Controllers;

class IncomeCalculatorCtrl
{
    // private $total;
    private $toyFee = 0.025;
    private $provFee = 0.20;
    private $type, $total;
    public $toyFeeVal, $provFeeVal, $balVal;
    
    function __construct($type, $total)
    {

        $this->type = $type;
        $this->total = $total;

    }

    public function calToyFee()
    {

        return $this->total * $this->toyFee;

    }

    public function calProvFee()
    {

        return $this->type =='paypal' ? (0.034 *$this->total) + $this->provFee : (0.014 *$this->total) + $this->provFee;

    }

    public function calBalance()
    {

        return $this->total - $this->calToyFee() - $this->calProvFee();

    }

    function __destruct()
    {

        $this->type = '';
        $this->total = 0;

    }

}