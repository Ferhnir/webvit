<?php

session_start();

require './vendor/autoload.php';

//Settings
$settings = require_once './app/config/settings.php';

$app = new \Slim\App($settings);

//Dependencies
require_once './app/dependiences.php';

//Routes
require_once './app/routes.php';

$app->run();

// if(defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
//     echo "CRYPT_BLOWFISH is enabled!";
//     echo crypt('123');
//   } else {
//     echo "CRYPT_BLOWFISH is NOT enabled!";
//   }