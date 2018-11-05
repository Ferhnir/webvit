<?php
require 'vendor/autoload.php';

//Settings
$settings = require_once 'app/config/settings.php';

$app = new \Slim\App($settings);

//Dependencies
require_once 'app/dependiences.php';


//Routes
require_once 'app/routes.php';

$app->run();