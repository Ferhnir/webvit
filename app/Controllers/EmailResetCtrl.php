<?php

namespace App\Controllers;

use Slim\Views\Twig as View;
use App\Controllers\Controller;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Models\CharityAdmin;
use App\Controllers\Auth\JwtCtrl;

class EmailResetCtrl extends Controller
{
    
    public function forgotPassword($request, $response)
    {

        return $this->view->render($response, './email/forgot_password.twig'); 

    }

    public function sentResetPasswordEmail($request, $response)
    {

        $email = $request->getParam('email');

        $admin = CharityAdmin::where('email',$email)->first();

        if(!$admin)
        {

            $this->flash->addMessage('error', 'Email not found');

            return $response->withRedirect($this->router->pathFor('email.error.msg')); 

        }

        $token = JwtCtrl::generateToken($email, $this->ci['token']['secret']);

        return $this->view->render($response, './email/reset_password_email_sent.twig', [
            'token' => $token
        ]); 

    }

    public function resetPassword($request, $response)
    {

        $update = $this->auth->updatePassword($request->getParam('email'),$request->getParam('new_password'));

        if($update)
        {

            $this->flash->addMessage('info', 'Password has been changed successfully');

            return $response->withRedirect($this->router->pathFor('password.changed'));

        }

    }

    public function resetPasswordForm($request, $response)
    {

        $data = JwtCtrl::decodeToken($request->getParam('token'),$this->ci['token']['secret']);

        $admin = CharityAdmin::where('email',$data->email)->first();

        if(!$admin)
        {

            $this->flash->addMessage('error', 'Email not found');

            return $response->withRedirect($this->router->pathFor('email.error.msg')); 
        
        } else {

            return $this->view->render($response, './email/reset_password_email_form.twig', [
                'email' => $data->email
            ]);

        }


    }

    public function passwordChanged($request, $response)
    {

        return $this->view->render($response, './email/password_changed.twig');

    }

    public function emailErrorMsg($request, $response)
    {

        return $this->view->render($response, './email/error_msg.twig');

    }

}