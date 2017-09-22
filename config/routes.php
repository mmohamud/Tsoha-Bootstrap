<?php



  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/votelist', function() {
  	HelloWorldController::äänestyssivu();
  });

  $routes->get('/votelist/opAanestys', function() {
  HelloWorldController::esittelysivu();
  });

  $routes->get('/votelist/opAanestys/edit', function() {
  HelloWorldController::muokkaussivu();
  });

  $routes->get('/login', function(){
  	HelloWorldController::kirjautumissivu();
  });

  $routes->get('/register', function(){
  	HelloWorldController::rekisteröitymissivu();
  });

  $routes->get('/newVote', function(){
  	HelloWorldController::uusiÄänestys();
  });

  $routes->get('/', function() {
    HelloWorldController::etusivu();
  });

  $routes->post('/vote', function(){
    VoteController::store();
  });

  $routes->get('vote/new', function(){
    VoteController::create();
  });

  //esittelysivu
   $routes->get('/vote/:id', function($id){
    VoteController::findOne($id);
  });
//listaussivu
  $routes->get('/vote', function(){
    VoteController::index();
  });

  