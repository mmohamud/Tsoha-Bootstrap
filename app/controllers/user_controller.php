<?php

class UserController extends BaseController {
    
    public static function login(){
      View::make('User/login.html');
  }
  
  public static function register() {
      View::make('User/register.html');
  }
  
  public static function findOne($id) {
      self::check_logged_in();
      $kayttaja = Kayttaja::find($id);
      View::make('User/userShow.html', array ('kayttaja' => $kayttaja));
  }
  
  public static function store() {
      $params = $_POST;
      
//      if ($params['admin'] == 1) {
//          
//            $attributes = array(
//            'kayttajatunnus' =>$params['kayttajatunnus'],
//            'nimi' => $params['nimi'],
//            'salasana' => $params['salasana'],
//            'admin' => $params['admin']      
//        );
//      } else {
          $attributes = array(
            'kayttajatunnus' =>$params['kayttajatunnus'],
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana'],
            'admin' => null
          );
//      }
      
      $kayttaja = new Kayttaja($attributes);
      $errors = $kayttaja->errors();
      $uusiTunnus = $kayttaja->validate_uusi_tunnus();
      
      $errors = array_merge($errors, $uusiTunnus);
      
      if (count($errors) == 0) {
            $kayttaja->save();
            $_SESSION['kayttajatunnus'] = $kayttaja->kayttajatunnus;
            Redirect::to('/vote', array('message' => 'Tunnus luotu!'));
        } else {
            View::make('/User/register.html',  array('errors' => $errors, 'attributes' => $attributes));
        }
  }
  
//  public static function update($id) {
//      
//  }


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

