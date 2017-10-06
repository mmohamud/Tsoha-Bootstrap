<?php

class Aanestys extends BaseModel {

    public $id, $kategoria_id, $nimi, $kuvaus, $kaynnissa, $sulkeutumispaiva;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_kuvaus');
        
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
        $query = DB::connection()->prepare('INSERT INTO aanestys (nimi, kategoria_id, sulkeutumispaiva, kuvaus) VALUES (:nimi, :kategoria_id, :sulkeutumispaiva, :kuvaus) RETURNING id');

        $query->execute(array('nimi' => $this->nimi, 'kategoria_id' => $this->kategoria_id, 'sulkeutumispaiva' => $this->sulkeutumispaiva, 'kuvaus' => $this->kuvaus));

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
    
    public function validate_nimi() {
        $errors = array();
        if($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Äänestyksen nimi ei voi olla tyhjä!';
        }
        if (strlen($this->nimi) > 50) {
            $errors[] = 'Nimi saa olla enintään 50 merkkiä pitkä!';
        }
        if (strlen($this->nimi) < 5) {
            $errors[] = 'Nimen pituuden tulee olla vähintään 5 merkkiä pitkä!';
        }
        return $errors;
    }
    
    public function validate_kuvaus() {
        $errors = array();
        if($this->kuvaus == '' || $this->kuvaus == null) {
            $errors[] = 'Lisää kuvaus!';
        }
        if (strlen($this->kuvaus) > 400) {
            $errors[] = 'Kuvaus saa olla enintään 400 merkkiä pitkä!';
        }
        return $errors;
    }
    
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Vaihtoehto WHERE aanestys_id = :aanestys_id');
        $query->execute(array('aanestys_id' => $this->id));
        
        $query = DB::connection()->prepare('DELETE FROM Aanestys WHERE id = :id');
        $query->execute(array('id' => $this->id));
        
    }
    
}
