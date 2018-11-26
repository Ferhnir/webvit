<?php

use Respect\Validation\Validator as v;

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


unset($app->getContainer()['notFoundHandler']);

//404 Error Handler
$container['notFoundHandler'] = function($container) {
    return function($request, $response) use ($container) {
        $container->view->render($response, 'errors/404.twig');
        return $response->withStatus(404);
    };
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
$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));
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
    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'admin' => $container->auth->admin()
    ]);

    $view->getEnvironment()->addGlobal("session", $_SESSION);

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};

//Validator
$container['validator'] = function ($container) {
    return new \App\Validations\Validator;
};

v::with('\\App\\Validations\\Rules');

$container['AuthCtrl'] = function ($container) {
    return new \App\Controllers\Auth\AuthCtrl($container);
};

$container['ReportFormCtrl'] = function ($container) {
    return new \App\Controllers\ReportFormCtrl($container);
};

$container['PasswordResetCtrl'] = function ($container) {
    return new \App\Controllers\PasswordResetCtrl($container);
};

$container['PasswordCtrl'] = function ($container) {
    return new \App\Controllers\Auth\PasswordCtrl($container);
};