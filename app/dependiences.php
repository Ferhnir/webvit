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

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/resources/views', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $view->addExtension(new Slim\Views\TwigExtension(
        $container->get('router'), 
        $container->request->getUri()
        // \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER))
    ));

    return $view;
};

$container['AuthCtrl'] = function ($container) {
    return new \App\Controllers\Auth\AuthCtrl($container);
};

$container['HomeCtrl'] = function ($container) {
    return new \App\Controllers\HomeCtrl($container);
};