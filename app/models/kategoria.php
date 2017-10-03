<?php

class Kategoria extends BaseModel {

    public $id, $nimi;

    public function _construct($attributes) {
        parent::_construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kategoria');

        $query->execute();

        $rows = $query->fetchAll();
        $Kategoriat = Array();

        foreach ($rows as $row) {
            $Kategoriat[] = new Kategoria(array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));
        }
        return $Kategoriat;
    }

    public static function findNimi($nimi) {
        $query = DB::connection()->prepare('SELECT * FROM Kategoria WHERE nimi = :nimi LIMIT 1');
        $query->execute(array('nimi' => $nimi));
        $row = $query->fetch();

        if ($row) {
            $kategoria = new Kategoria(array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));
            return $kategoria;
        }
//        else {
//
//            $query2 = DB::connection()->prepare('INSERT INTO kategoria nimi VALUES :nimi');
//            $query2->execute(array('nimi' => $nimi));
//
//            $query3 = DB::connection()->prepare('SELECT * FROM Kategoria WHERE nimi = :nimi');
//            $query3->execute(array('nimi' => $nimi));
//            $row2 = $query2->fetch();
//
//            $palautusKategoria = new Kategoria(Array(
//                'id' => $row['id'],
//                'nimi' => $row['nimi']
//            ));
//            
//            return $palautusKategoria;
//        }
        return null;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kategoria WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $Kategoria = new Kategoria(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
            ));
            return $Kategoria;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kategoria (nimi) VALUES (:nimi) RETURNING id');

        $query->execute(array('nimi' => $this->nimi));

        $row = $query->fetch();

        $this->id = $row['id'];
    }

}
