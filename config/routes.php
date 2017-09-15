<?php

  $routes->get('/', function() {
    HelloWorldController::etusivu();
  });

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