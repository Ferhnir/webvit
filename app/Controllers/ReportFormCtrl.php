<?php

namespace App\Controllers;

use Slim\Views\Twig as View;

class ReportFormCtrl extends Controller
{

    public function index($request, $response)
    {
    
        return $this->view->render($response, 'reportForm.twig');
    
    }

}