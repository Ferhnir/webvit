<?php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use App\Middlewares\AuthMiddleware;



$app->get('/', 'AuthCtrl:getSignIn')->setName('index');

$app->group('', function() {
  
  $this->get('/dashboard', 'DashboardCtrl:index')->setName('dashboard');

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


});

//Email reset
$app->group('/email', function() use ($app) {

  $this->get('/forgot_password', 'EmailResetCtrl:forgotPassword')->setName('email.forgot.password');
  $this->post('/forgot_password', 'EmailResetCtrl:sentResetPasswordEmail');

  $this->get('/sent', 'EmailResetCtrl:resetPasswordEmailSent')->setName('email.password.sent');

  $this->get('/password_reset_form', 'EmailResetCtrl:resetPasswordForm')->setName('password.reset.form');
  $this->post('/password_reset_form','EmailResetCtrl:resetPassword');

  $this->get('/password_changed', 'EmailResetCtrl:passwordChanged')->setName('password.changed');

  $this->get('/error', 'EmailResetCtrl:emailErrorMsg')->setName('email.error.msg');
});

?>