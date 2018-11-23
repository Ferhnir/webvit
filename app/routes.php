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


});

//Email
$app->group('/email', function() {

  //request
  $this->get('/forgot_password', 'PasswordResetCtrl:forgotPassword')->setName('email.forgot.password');
  $this->post('/forgot_password', 'PasswordResetCtrl:sendPasswordResetEmail');

  //confirmation email sent
  $this->get('/sent', 'PasswordResetCtrl:resetPasswordEmailSent')->setName('email.password.sent');
  
  
  //error handler
  $this->get('/error', 'PasswordResetCtrl:emailErrorMsg')->setName('email.error.msg');
});

//Password reset form
$app->get('/password_reset_form', 'PasswordResetCtrl:passwordResetForm')->setName('password.reset.form')->add(new TokenCheckMiddleware($container));
$app->post('/password_reset_form','PasswordResetCtrl:passwordReset');

//confrimation password changed
$app->get('/password_changed', 'PasswordResetCtrl:passwordChanged')->setName('password.changed');
?>