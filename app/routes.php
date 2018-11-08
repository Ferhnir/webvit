<?php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use App\Middlewares\AuthMiddleware;

$app->get('/', 'AuthCtrl:getSignIn')->setName('index');

$app->group('', function() {
  
  $this->get('/dashboard', 'DashboardCtrl:index')->setName('dashboard');

  $this->get('/reportform', 'ReportFormCtrl:index')->setName('report.form');

})->add(new AuthMiddleware($container));


//Auth
$app->group('/auth', function(){

  //Sign in
  $this->get('/signin', 'AuthCtrl:getSignIn')->setName('auth.signin');
  $this->post('/signin', 'AuthCtrl:postSignIn');
  
  //Sign out
  $this->get('/signout', 'AuthCtrl:getSignOut')->setName('auth.signout');;

});

?>