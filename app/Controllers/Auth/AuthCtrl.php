<?php

namespace App\Controllers\Auth;

use Slim\Views\Twig as View;
use App\Controllers\Controller;
use App\Models\CharityAdmin;


class AuthCtrl extends Controller
{

    public function getSignUp($request, $response)
    {
        
        return $this->view->render($response, 'auth/signup.twig');
    }
    
    public function postSignUp($request, $response)
    {
        $auth = CharityAdmin::where([
                            'email'    => $request->getParam('email'),
                            'password' => $request->getParam('password')
                ])->first();

        if($auth)
        {
            return $response->withRedirect($this->router->pathFor('home')); 
        } else {
            var_dump('Wrong login or password'); 
        } 


    }

}