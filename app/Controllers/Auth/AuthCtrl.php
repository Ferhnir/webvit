<?php

namespace App\Controllers\Auth;

use Slim\Views\Twig as View;
use App\Controllers\Controller;
use App\Models\CharityAdmin;


class AuthCtrl extends Controller
{

    public function getSignIn($request, $response)
    {

        return $this->view->render($response, 'auth/signin.twig');
    
    }
    
    public function postSignIn($request, $response)
    {

        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if(!$auth)
        {
            $this->flash->addMessage('error', 'Login or password doesnt match');
            return $response->withRedirect($this->router->pathFor('auth.signin'));     
        }

        $this->flash->addMessage('info', 'Loged in successfuly');
        return $response->withRedirect($this->router->pathFor('home'));

    }

    public function getSignOut($request, $response)
    {

        $this->auth->logout();

        return $response->withRedirect($this->router->pathFor('auth.signin')); 

    }

}