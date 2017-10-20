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

//$routes->get('/login', function() {
//    HelloWorldController::kirjautumissivu();
//});
//$routes->get('/register', function() {
//    HelloWorldController::rekisteröitymissivu();
//});

//$routes->get('/newVote', function() {
//    HelloWorldController::uusiÄänestys();
//});

$routes->get('/', function() {
    HelloWorldController::etusivu();
});

$routes->post('/vote/options/:id', function($id) {
    VotesController::storeOptions($id);
});

$routes->post('/vote', function() {
    VotesController::store();
});

$routes->get('/vote/new', function() {
    VotesController::create();
});

$routes->get('/vote/options/:id', function ($id) {
    VotesController::addOptions();
});

$routes->get('/vote/:id', function($id) {
    VotesController::findOne($id);
});


$routes->get('/vote', function() {
    VotesController::index();
});

$routes->post('/vote/:id/destroy', function($id) {
    // Äänestyksen poisto
    VotesController::destroy($id);
});
$routes->get('/vote/:id/edit', function($id) {
    //muokkaussivu
    VotesController::edit($id);
});

$routes->post('/vote/:id/edit', function($id) {
    //Äänestyksen muokkaus
    VotesController::update($id);
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->get('/logout', function() {
    UserController::logout();
});

$routes->get('/register', function() {
    UserController::register();
});
$routes->post('/register', function() {
    UserController::store();
});

$routes->get('/user/:id', function($id) {
    UserController::findOne($id);
});

$routes->get('/user/:id/edit', function($id) {
    //Käyttäjän muokkaussivu
    UserController::edit($id);
});

$routes->post('/user/:id/edit', function($id) {
    //Käyttäjän muokkaus
    UserController::update($id);
});

$routes->post('/user/:id/destroy', function($id) {
    // Käyttäjän poisto
    UserController::destroy($id);
});

$routes->get('/users/', function() {
    UserController::userShowAdmin();
});

$routes->post('/vote/:id/add', function($id) {   
    VoteController::store($id);
});
