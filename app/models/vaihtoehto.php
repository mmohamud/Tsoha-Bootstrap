<?php


class vaihtoehto extends BaseModel {
    public $id, $aanestys_id, $vaihtoehto;
    
    public function _construct($attributes) {
        parent::construct($attributes);
        $this->validators = array(validate_vaihtoehto);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Vaihtoehto');
        
        $query->execute();
        
        $rows = $query->fetchAll();     
        $Vaihtoehdot = Array();
        
        foreach ($rows as $row) {
            $Vaihtoehdot[] = new Vaihtoehto (array(
                'id' => $row['id'],
                'aanestys_id' => $row['aanestys_id'],
                'vaihtoehto' => $row['vaihtoehto']
            ));
        }
        
        return $Vaihtoehdot;
    }
    
    public static function getVoteId($id) {
        $query = DB::connection()->prepare('SELECT * FROM Aanestys WHERE id = :id LIMIT1');
        $query->execute(array('id' => $id));
        
        $row = $query->fetch();
        
        if($row) {
            return $row['id'];
        }
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Vaihtoehto WHERE id = :id LIMIT 1');
        
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if ($row) {
            $Vaihtoehto = new Vaihtoehto(array(
                'id' => $row['id'],
                'aanestys_id' => $row['aanestys_id'],
                'vaihtoehto' => $row['vaihtoehto']
            ));
            return $Vaihtoehto;
        }
        return null;
        
        
    }
    
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO vaihtoehto (aanestys_id, vaihtoehto) VALUES (:aanestys_id, :vaihtoehto)');

        $query->execute(array('aanestys_id' => $this->aanestys_id, 'vaihtoehto' => $this->vaihtoehto));

       
    }
    
    public static function haeVaihtoehdot($aanestys_id) {
        $query = DB::connection()->prepare('SELECT * FROM Vaihtoehto WHERE aanestys_id = :aanestys_id');
        $query->execute(array('aanestys_id' => $aanestys_id));
        
        $rows = $query->fetchAll();     
        $Vaihtoehdot = Array();
        
        foreach ($rows as $row) {
            $Vaihtoehdot[] = new Vaihtoehto (array(
                'id' => $row['id'],
                'aanestys_id' => $row['aanestys_id'],
                'vaihtoehto' => $row['vaihtoehto']
            ));
        
        }
        
        return $Vaihtoehdot;
    }
    
//    public function validate_vaihtoehto() {
//        $errors = array();
//        if($this->vaihtoehto == '' || $this->vaihtoehto == null) {
//            $errors[] = 'Vaihtoehto ei voi olla tyhjä!';
//        }
//        if(strlen($this->vaihtoehto)> 100) {
//            $errors[] = 'Vaihtoehto saa olla enintään 100 merkkiä pitkä!';
//        }
//    }
}
