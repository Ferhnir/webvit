<?php

namespace App\Middlewares;

use App\Middlewares\Middleware;

class CsrfViewMiddleware extends Middleware
{

    public function __invoke($request, $response, $next)
    {

        $this->ci->view->getEnvironment()->addGlobal('csrf', [
            'field' => 
                '<input 
                    type="hidden" 
                    name="' . $this->ci->csrf->getTokenNameKey() . '"
                    value="' . $this->ci->csrf->getTokenName() . '">
                <input 
                    type="hidden"
                    name="' . $this->ci->csrf->getTokenValueKey() . '"
                    value="' . $this->ci->csrf->getTokenValue() . '">
                '
        ]);

        $response = $next($request, $response);

        return $response;

    }

}