<?php

namespace App\Controllers;

use Slim\Views\Twig as View;
use App\Controllers\Controller;

use App\Models\CharityAdmin;
use App\Controllers\Auth\JwtCtrl as JWT;

use App\Controllers\MailCtrl as Mail;

use Respect\Validation\Validator as v;

class PasswordResetCtrl extends Controller
{
    
    public function forgotPassword($request, $response)
    {

        return $this->view->render($response, './email/forgot_password.twig'); 

    }

    public function sendPasswordResetEmail($request, $response)
    {

        $validation = $this->validator->validate($request, [

            'email' => v::noWhitespace()->notEmpty()->length(5)

        ]);

        if($validation->failed()) {

            return $response->withRedirect($this->router->pathFor('email.forgot.password', ['tet' => 3])); 

        }

        $email = $request->getParam('email');

        $admin = CharityAdmin::where('email',$email)->first();

        if(!$admin)
        {

            $this->flash->addMessage('error', 'Email not found');

            return $response->withRedirect($this->router->pathFor('email.error.msg')); 

        }

        $token = Jwt::generateToken($email, $this->ci['token']['secret']);

        $admin->password_token = $token;
        
        $admin->save();

        // $sendemail = Mail::sendEmail($email, $token);

        return $this->view->render($response, './email/reset_password_email_sent.twig', [
            'token' => $token
        ]); 
        return $this->view->render($response, './email/reset_password_email_sent.twig');
    }
    
    public function passwordResetForm($request, $response)
    {

        $data = Jwt::decodeToken($request->getParam('token'),$this->ci['token']['secret']);
        
        $admin = CharityAdmin::where('email',$data->email)->first();
        
        
        if($admin->password_token !== $request->getParam('token'))
        {

            $this->flash->addMessage('error', 'Password change token is not valid');     
            
            return $response->withRedirect($this->router->pathFor('email.forgot.password'));

        }
        
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
        
    public function passwordReset($request, $response)
    {
    
        $validation = $this->validator->validate($request, [

            'new_password' => v::noWhitespace()->notEmpty()->length(8),
            're_new_password' => v::noWhitespace()->notEmpty()->length(8)

        ]);

        if($validation->failed()) {

            return $response->withRedirect($this->router->pathFor('password.reset.form')); 

        }

        die();

        $update = $this->auth->updatePassword($request->getParam('email'),$request->getParam('new_password'));
        
        if($update)
        {
        
            $this->flash->addMessage('info', 'Password has been changed successfully');
        
            return $response->withRedirect($this->router->pathFor('password.changed'));
        
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