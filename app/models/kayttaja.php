<?php


class Kayttaja extends BaseModel {
    public $id, $kayttajatunnus, $nimi, $salasana, $admin;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_kayttajatunnus', 'validate_nimi', 'validate_salasana');       
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $Kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'nimi' => $row['nimi'],
                'salasana' => $row['salasana'],
                'admin' => $row['admin']
            ));
            return $Kayttaja;
        }
        return null;
    }
    
    public static function authenticate($kayttajatunnus, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1');
        $query->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));
        $row = $query->fetch();
        
        if ($row) {
            $kayttaja = new Kayttaja(array(
                'id' => $row['id'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'nimi' => $row['nimi'],
                'salasana' => $row['salasana'],
                'admin' => $row['admin']
            ));
            return $kayttaja;
        } 
            return null;
        
    }
        
    
        public function validate_kayttajatunnus() {
        $errors = array();
        if($this->kayttajatunnus == '' || $this->kayttajatunnus == null) {
            $errors[] = 'Käyttäjätunnus ei voi olla tyhjä!';
        }
        if (strlen($this->kayttajatunnus) > 50) {
            $errors[] = 'Nimi saa olla enintään 50 merkkiä pitkä!';
        }
        if (strlen($this->kayttajatunnus) < 5) {
            $errors[] = 'Käyttäjätunnuksen pituuden tulee olla vähintään 5 merkkiä pitkä!';
        }
        return $errors;
    }
    
    public function validate_salasana() {
        $errors = array();
        if($this->salasana == '' || $this->kayttajatunnus == null) {
            $errors[] = 'Käyttäjätunnus ei voi olla tyhjä!';
        }
        if (strlen($this->salasana) > 50) {
            $errors[] = 'Nimi saa olla enintään 50 merkkiä pitkä!';
        }
        if (strlen($this->salasana) < 5) {
            $errors[] = 'Käyttäjätunnuksen pituuden tulee olla vähintään 5 merkkiä pitkä!';
        }
        return $errors;
    }
}




/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

