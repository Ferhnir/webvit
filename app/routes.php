<?php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
  return $this->response->withJson('Test vit page');
});

$app->get('/home', 'HomeCtrl:index')->setName('home');


//Auth
$app->group('/auth', function(){

  $this->get('/signup', 'AuthCtrl:getSignUp')->setName('auth.signup');;
  $this->post('/signup', 'AuthCtrl:postSignUp');

});


// $app->get('/hello/{name}', function ($request, $response, $args) {
//   return $this->view->render($response, 'home.twig', [
//       'name' => $args['name']
//   ]);
// })->setName('profile');
//Auth 
// $app->post('/auth', \AuthCtrl::class . ':auth')->setName('auth.generate.token');

//Insect data
// $app->group('/insect', function(){
  
  //specific category
//   $this->get('/families', \FamiliesCtrl::class)->setName('api.data.families.index');


// });

?>