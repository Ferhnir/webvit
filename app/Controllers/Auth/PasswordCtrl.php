<?php

namespace App\Controllers\Auth;

use Slim\Views\Twig as View;
use App\Controllers\Controller;

use App\Models\CharityAdmin;
use App\Controllers\Auth\JwtCtrl as JWT;

use App\Controllers\MailCtrl as Mail;

use Respect\Validation\Validator as v;

class PasswordCtrl extends Controller
{

    public function index($request, $response)
    {

        return $this->view->render($response, './auth/password_recover.twig'); 
        
    }

    public function sendChangePasswordEmail($request, $response)
    {

        $validation = $this->validator->validate($request, [

            'email' => v::noWhitespace()->notEmpty()->length(5)->regex('/[@]/'),

        ]);

        if($validation->failed()) {

            return $response->withRedirect($this->router->pathFor('email.forgot.password', ['tet' => 3])); 

        }

        $email = $request->getParam('email');

        $admin = CharityAdmin::where('email',$email)->first();

        if(!$admin)
        {

            $this->flash->addMessage('error', 'Email not found');

            return $response->withRedirect($this->router->pathFor('auth.password.recover')); 

        }

        $token = Jwt::generateToken($email, $this->ci['token']['secret']);

        $admin->password_token = $token;
        
        $admin->save();

        // $sendemail = Mail::sendEmail($email, $token);

        return $this->view->render($response, './auth/token_sent.twig', [
            'token' => $token
        ]); 
        // return $this->view->render($response, './auth/token_sent.twig');
    }

    public function getChangePassword($request, $response)
    {

        $data = Jwt::decodeToken($_SESSION['token'], $this->ci['token']['secret']);
        
        $admin = CharityAdmin::where('email',$data->email)->first();
        
        
        if($admin->password_token !== $_SESSION['token'])
        {

            $this->flash->addMessage('error', 'Password change token is not valid');     
            
            return $response->withRedirect($this->router->pathFor('auth.password.change'));

        }
        
        if(!$admin)
        {
            
            $this->flash->addMessage('error', 'Email not found');
            
            return $response->withRedirect($this->router->pathFor('auth.password.change')); 
            
        } else {
            
            return $this->view->render($response, './auth/password_change.twig', [
                'email' => $data->email
                ]);
                
        }

    }

    public function postChangePassword($request, $response)
    {
        
        $validation = $this->validator->validate($request, [
    
            'new_password' => v::noWhitespace()
                                    ->notEmpty()
                                    ->length(8)
                                    ->capLetters(1)
                                    ->specSigns(1)
    
        ]);
    
        if($validation->failed()) {
    
            return $response->withRedirect($this->router->pathFor('auth.password.change')); 
    
        }
    
        $update = $this->auth->updatePassword($request->getParam('email'),$request->getParam('new_password'));
            
        if($update)
        {
            
            unset($_SESSION['token']);
    
            $this->flash->addMessage('info', 'Password has been changed successfully');
            
            return $response->withRedirect($this->router->pathFor('auth.signin'));
            
        }

    }

    public function passwordChanged($request, $response)
    {
        
        $this->flash->addMessage('info', 'Password has been changed successfully');
        
        return $response->withRedirect($this->router->pathFor('auth.signin'));

    }

}