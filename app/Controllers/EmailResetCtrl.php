<?php

namespace App\Controllers;

use Slim\Views\Twig as View;
use App\Controllers\Controller;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailResetCtrl extends Controller
{
    
    public function forgotPassword($request, $response)
    {

        return $this->view->render($response, './email/forgot_password.twig'); 

    }

    public function sentResetPasswordEmail($request, $response, $app)
    {
        

    }

    public function resetPasswordEmailSent($request, $response)
    {

        return $this->view->render($response, './email/reset_password_email_sent.twig');

    }

}