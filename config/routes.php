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

$routes->get('/newVote', function() {
    HelloWorldController::uusiÄänestys();
});

$routes->get('/', function() {
    HelloWorldController::etusivu();
});

$routes->post('/vote/options/:id', function($id) {
    VoteController::storeOptions($id);
});

$routes->post('/vote', function() {
    VoteController::store();
});

$routes->get('/vote/new', function() {
    VoteController::create();
});

$routes->get('/vote/options/:id', function ($id) {
    VoteController::addOptions();
});

$routes->get('/vote/:id', function($id) {
    VoteController::findOne($id);
});


$routes->get('/vote', function() {
    VoteController::index();
});

$routes->post('/vote/:id/destroy', function($id) {
    // Äänestyksen poisto
    VoteController::destroy($id);
    Redirect::to('/vote', array('message' => 'Äänestys on poistettu!'));
});
$routes->get('/vote/:id/edit', function($id) {
    //muokkaussivu
    VoteController::edit($id);
});

$routes->post('/vote/:id/edit', function($id) {
    //Äänestyksen muokkaus
    VoteController::update($id);
});

$routes ->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function(){
    UserController::handle_login();
});

$routes->get('/logout', function(){
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

