<?php

namespace App\Middlewares;

use App\Middlewares\Middleware;

class AuthMiddleware extends Middleware
{

    public function __invoke($request, $response, $next)
    {

        if(!$this->ci->auth->check())
        {

            $this->ci->flash->addMessage('error','You are not loged in to get to that section');

            return $response->withRedirect($this->ci->router->pathFor('auth.signin'));

        }

        $response = $next($request, $response);

        return $response;

    }

}