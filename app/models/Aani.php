<?php

class Aani extends BaseModel {

    public $kayttaja_id, $vaihtoehto_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Aani');

        $query->execute();

        $rows = $query->fetchAll();
        $Aanet = Array();

        foreach ($rows as $row) {
            $Aanet[] = new Aani(array(
                'kayttaja_id' => $row['kayttaja_id'],
                'vaihtoehto_id' => $row['vaihtoehto_id']           
            ));
        }
        return $Aanet;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Aani WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $Aani = new Aani(array(
                'id' => $row['id'],
                'kayttaja_id' => $row['kayttaja_id'],
                'vaihtoehto_id' => $row['vaihtoehto_id'],            
            ));
            return $Aani;
        }
        return null;
    }
    
    public static function findVotesByUser($aanestys_id) {
        $kayttaja = BaseController::get_user_logged_in();
        $kayttaja_id = $kayttaja->id;
        $query = DB::connection()->prepare('SELECT COUNT (Aani.id) AS Lukumaara FROM Aani INNER JOIN Vaihtoehto ON Aani.vaihtoehto_id = Vaihtoehto.id WHERE Aani.kayttaja_id = :kayttaja_id AND Vaihtoehto.aanestys_id = :aanestys_id');
        $query->execute(array('kayttaja_id' => $kayttaja_id, 'aanestys_id' => $aanestys_id));
        $row = $query->fetch();
        return $row['lukumaara'];
    }
    


    public function save() {
        $query = DB::connection()->prepare('INSERT INTO aani (kayttaja_id, vaihtoehto_id) VALUES (:kayttaja_id, :vaihtoehto_id) RETURNING id');

        $query->execute(array('kayttaja_id' => $this->kayttaja_id, 'vaihtoehto_id' => $this->vaihtoehto_id));

        $row = $query->fetch();
 
        $this->id = $row['id'];
    }
    
}
