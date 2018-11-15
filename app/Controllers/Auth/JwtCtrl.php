<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;

use Carbon\Carbon;
use \Firebase\JWT\JWT;

class JwtCtrl extends Controller
{

    public function generateToken($user, $secret)
    {

        $now = Carbon::now()->timezone('Europe/London');
        $future = Carbon::now()->timezone('Europe/London')->addHour();

        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "email"=> $user
        ];

        $token = JWT::encode($payload, $secret, 'HS256');
        return $token;
    }

    public function decodeToken($token, $secret)
    {

        $token = JWT::decode($token, $secret, ['HS256']);
        return $token;

    }

}