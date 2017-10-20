<?php

class UserController extends BaseController {

    public static function login() {
        View::make('User/login.html');
    }

    public static function register() {
        View::make('User/register.html');
    }
    
    public static function userShowAdmin() {   
        $kayttajat = Kayttaja::all();
        foreach ($kayttajat as $kayttaja) {       
        }
        View::make('User/userShowAdmin.html', array('kayttajat' => $kayttajat));
    }

    public static function findOne($id) {
        self::check_logged_in();
        $kayttaja = Kayttaja::find($id);
        View::make('User/userShow.html', array('kayttaja' => $kayttaja));
    }

    public static function edit($id) {
        $kayttaja = Kayttaja::find($id);

        $attributes = array(
            'nimi' => $kayttaja->nimi,
            'salasana' => $kayttaja->salasana,
            'id' => $id
        );

        View::make('User/editUser.html', array('attributes' => $kayttaja));
    }

    public static function store() {
        $params = $_POST;

      if ($params['admin'] == 1) {
          
            $attributes = array(
            'kayttajatunnus' =>$params['kayttajatunnus'],
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana'],
            'admin' => $params['admin']      
        );
      } else {
        $attributes = array(
            'kayttajatunnus' => $params['kayttajatunnus'],
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana'],
            'admin' => null
        );
      }

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();
        $uusiTunnus = $kayttaja->validate_uusi_tunnus();
        $errors = array_merge($errors, $uusiTunnus);
//        $errors = array_merge($errors);

        if (count($errors) == 0) {
            $kayttaja = $kayttaja->save();

            $_SESSION['kayttaja'] = $kayttaja->id;

            Redirect::to('/vote', array('message' => 'Tunnus luotu!'));
        } else {
            View::make('/User/register.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function update($id) {
        $params = $_POST;
        
        $kayttaja = Kayttaja::find($id);

        $attributes = (array(
            'kayttajatunnus' => $kayttaja->kayttajatunnus,
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana'],
            'admin' => $kayttaja->admin,
            'id' => $id
        ));

        $kayttaja = new Kayttaja($attributes);
        $errors = $kayttaja->errors();

        if (count($errors) == 0) {
            $kayttaja->update();
            Redirect::to('/user/' . $id, array('message' => 'Käyttäjätiedot päivitetty'));
        } else {
            View::make('/User/editUser.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function destroy($id) {        
        $kayttaja = new Kayttaja(array('id' => $id));      
        $kayttaja->destroy();   
        Redirect::to('/vote' , array('message' => 'Käyttäjä poistettu'));
        } 


    public static function handle_login() {
        $params = $_POST;

        $kayttaja = Kayttaja::authenticate($params['kayttajatunnus'], $params['salasana']);

        if (!$kayttaja) {
            View::make('User/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'kayttajatunnus' => $params['kayttajatunnus']));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->id;

            Redirect::to('/vote', array('message' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '!'));
        }
    }

    public static function logout() {
        $_SESSION['kayttaja'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
