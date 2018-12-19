<?php

namespace App\Controllers\Auth;

use Slim\Views\Twig as View;
use App\Controllers\Controller;
use App\Models\CharityAdmin;

use Respect\Validation\Validator as v;


class AuthCtrl extends Controller
{

    public function getSignIn($request, $response)
    {
        if(!$this->ci->auth->check()){

            return $this->view->render($response, './auth/signin.twig');
        
        } else {

            return $response->withRedirect($this->router->pathFor('report.form'));
        
        }
    
    }
    
    public function postSignIn($request, $response)
    {

        $validation = $this->validator->validate($request, [

            'email' => v::noWhitespace()->notEmpty()->length(5)->regex('/[@]/')
            
        ]);

        if($validation->failed()) {

            return $response->withRedirect($this->router->pathFor('auth.signin')); 

        }

        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if(!$auth)
        {
            $this->flash->addMessage("error", "Login or password doesn't match");
            return $response->withRedirect($this->router->pathFor('auth.signin'));     
        }

        $this->flash->addMessage('info', 'Loged in successfuly');
        return $response->withRedirect($this->router->pathFor('report.form'));

    }

    public function getSignOut($request, $response)
    {

        $this->auth->logout();

        return $response->withRedirect($this->router->pathFor('auth.signin')); 

    }

    public function forgottenPassword($request, $response)
    {

        return $this->view->render($response, './auth/forgotten_password.twig'); 

    }

    public function updatePassword($user, $new_password)
    {

            $this->auth->updatePassword($new_password);
 
    }

}