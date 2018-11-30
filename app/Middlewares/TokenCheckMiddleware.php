<?php

namespace App\Middlewares;

use App\Middlewares\Middleware;

class TokenCheckMiddleware extends Middleware
{

    public function __invoke($request, $response, $next)
    {

        $request->getParam('token') !== null ? $_SESSION['token'] = $request->getParam('token') : $_SESSION['token'] == null;

        if($_SESSION['token'] == null)
        {
            $this->ci->flash->addMessage('error','Token is missing...');

            return $response->withRedirect($this->ci->router->pathFor('auth.password.recover'));

        }

        $response = $next($request, $response);

        return $response;

    }

}