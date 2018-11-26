<?php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use App\Middlewares\AuthMiddleware;
use App\Middlewares\TokenCheckMiddleware;



$app->get('/', 'AuthCtrl:getSignIn')->setName('index');

$app->group('', function() {

  $this->get('/reportform', 'ReportFormCtrl:index')->setName('report.form');
  $this->post('/reportform', 'ReportFormCtrl:downloadCsvAction')->setName('report.download.csv');

})->add(new AuthMiddleware($container));


//Auth
$app->group('/auth', function(){

  //Sign in
  $this->get('/signin', 'AuthCtrl:getSignIn')->setName('auth.signin');
  $this->post('/signin', 'AuthCtrl:postSignIn');
  
  //Sign out
  $this->get('/signout', 'AuthCtrl:getSignOut')->setName('auth.signout');
  
  //password recover
  $this->get('/password/recover', 'PasswordCtrl:index')->setName('auth.password.recover');
  $this->post('/password/recover', 'PasswordCtrl:sendChangePasswordEmail');

  //email sent confirmation
  // $this->get('/password/recover/sent', 'PasswordCtrl:resetPasswordEmailSent')->setName('auth.password.recover.sent');

});

//Password reset form
$app->get('/auth/password/change', 'PasswordCtrl:getChangePassword')->setName('auth.password.change')->add(new TokenCheckMiddleware($container));
$app->post('/auth/password/change','PasswordCtrl:postChangePassword');

?>