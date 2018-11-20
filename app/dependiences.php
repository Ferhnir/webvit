<?php

// Get container
$container = $app->getContainer();

// Database connection
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule){
  return $capsule;
};

//Auth Module
$container['auth'] = function($container) {
    return new App\Auth\Auth;
};

//Jwt Module
$container['token'] = function ($c) {
    $token = $c['settings']['token'];
    return $token;
};

//CSRF Module
$container['csrf'] = function ($container) {
    return new \Slim\Csrf\Guard;
};

//Middlewares setup
$app->add(new \App\Middlewares\CsrfViewMiddleware($container));
$app->add($container->csrf);



//Flash Module
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// TwigView setup
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/resources/views', [
        'cache' => false
    ]);

    $view->addExtension(new Slim\Views\TwigExtension(
        $container->get('router'), 
        $container->request->getUri()
        // \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER))
    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'admin' => $container->auth->admin()
    ]);

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};


$container['AuthCtrl'] = function ($container) {
    return new \App\Controllers\Auth\AuthCtrl($container);
};

$container['JwtCtrl'] = function ($container) {
    return new \App\Controllers\Auth\JwtCtrl($container);
};

$container['DashboardCtrl'] = function ($container) {
    return new \App\Controllers\DashboardCtrl($container);
};

$container['ReportFormCtrl'] = function ($container) {
    return new \App\Controllers\ReportFormCtrl($container);
};

$container['EmailResetCtrl'] = function ($container) {
    return new \App\Controllers\EmailResetCtrl($container);
};