<?php

class UserController extends BaseController {
    
    public static function login(){
      View::make('User/login.html');
  }
  
  public static function handle_login() {
      $params = $_POST;

      $kayttaja = Kayttaja::authenticate($params['kayttajatunnus'], $params['salasana']);
      Kint::dump($params);
      Kint::dump($kayttaja);
      if(!$kayttaja) {
          View::make('User/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'kayttajatunnus' => $params['kayttajatunnus']));
      }else{
          $_SESSION['kayttaja'] = $kayttaja->id;
          
          Redirect::to('/vote', array('message' => 'Tervetuloa takaisin'. $kayttaja->nimi . '!'));
      }
      
      
      }
      
      public static function logout() {
          $_SESSION['kayttaja'] = null;
          Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
      }
  }

