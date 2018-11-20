<?php

namespace App\Middlewares;

use App\Middlewares\Middleware;

class TokenCheckMiddleware extends Middleware
{

    public function __invoke($request, $response, $next)
    {

        if($request->getParam('token') == null)
        {

            $this->ci->flash->addMessage('error','Token is missing...');

            return $response->withRedirect($this->ci->router->pathFor('email.forgot.password'));

        }

        $response = $next($request, $response);

        return $response;

    }

}