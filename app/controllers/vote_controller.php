<?php

class VoteController extends BaseController {

    
    public static function store($aanestys_id) {
        $kayttaja = BaseController::get_user_logged_in();
        $params = $_POST;
        
        $attributes = (array(           
            'kayttaja_id' => $kayttaja->id,
            'vaihtoehto_id' => $params['vaihtoehto_id']          
        ));
        
        $aani = new Aani($attributes);
        $aanienmaara = Aani::findVotesByUser($aanestys_id);       
        
        if ($aanienmaara < 1) {
        $aani->save();        
        Redirect::to('/vote' ,  array('message' => 'Ääni lisätty'));
        } else {
//            array('message' => 'Olet jo äänestänyt!');
            Redirect::to('/vote' ,  array('message' => 'Olet jo äänestänyt'));
        }
    }
    
}

