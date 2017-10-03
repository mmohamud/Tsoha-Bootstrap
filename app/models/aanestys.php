<?php

class Aanestys extends BaseModel {

    public $id, $kategoria_id, $nimi, $kuvaus, $kaynnissa, $yksityinen, $alkamispaiva, $sulkeutumispaiva;

    public function _construct($attributes) {
        parent::_construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Aanestys');

        $query->execute();

        $rows = $query->fetchAll();
        $Aanestykset = Array();

        foreach ($rows as $row) {
            $Aanestykset[] = new Aanestys(array(
                'id' => $row['id'],
                'kategoria_id' => $row['kategoria_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'kaynnissa' => $row['kaynnissa'],
                'yksityinen' => $row['yksityinen'],
                'alkamispaiva' => $row['alkamispaiva'],
                'sulkeutumispaiva' => $row['sulkeutumispaiva']
            ));
        }
        return $Aanestykset;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Aanestys WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $Aanestys = new Aanestys(array(
                'id' => $row['id'],
                'kategoria_id' => $row['kategoria_id'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'kaynnissa' => $row['kaynnissa'],
                'yksityinen' => $row['yksityinen'],
                'alkamispaiva' => $row['alkamispaiva'],
                'sulkeutumispaiva' => $row['sulkeutumispaiva']
            ));
            return $Aanestys;
        }
        return null;
    }
    
    public static function getCategoryNames($id) {
        $query = DB::connection()->prepare('SELECT nimi FROM kategoria WHERE id = :id');
        $query->execute(array('id' => $id));
        
        $row = $query->fetch();
        
        if($row) {
            return $row['nimi'];
        }
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO aanestys (nimi, kategoria_id, alkamispaiva, sulkeutumispaiva, kuvaus) VALUES (:nimi, :kategoria_id, :alkamispaiva, :sulkeutumispaiva, :kuvaus) RETURNING id');

        $query->execute(array('nimi' => $this->nimi, 'kategoria_id' => $this->kategoria_id, 'alkamispaiva' => $this->alkamispaiva, 'sulkeutumispaiva' => $this->sulkeutumispaiva, 'kuvaus' => $this->kuvaus));

        $row = $query->fetch();
 
        $this->id = $row['id'];
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
        } else {

            $kategoria = new Kategoria(array(
                'nimi' => $nimi
            ));

            $kategoria::save();

            $query2 = DB::connection()->prepare('SELECT * FROM Kategoria WHERE nimi = :nimi');
            $query2->execute(array('nimi' => $nimi));
            $palautusKategoria = $query2->fetch();

            return $palautusKategoria;
        }
    }
    
    
}
