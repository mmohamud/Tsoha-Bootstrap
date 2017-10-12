<?php

class VoteController extends BaseController {

    public static function index() {
        
        $aanestykset = Aanestys::all();
        foreach ($aanestykset as $aanestys) {
            $aanestys->kategoria_id = Aanestys::getCategoryNames($aanestys->kategoria_id);
        }
        View::make('Vote/index.html', array('aanestykset' => $aanestykset));
    }

    public static function create() {
        self::check_logged_in();
        View::make('Vote/newVote.html');
    }

    public static function findOne($id) {
        self::check_logged_in();
        $aanestys = Aanestys::find($id);
        $aanestys->kategoria_id = Aanestys::getCategoryNames($aanestys->kategoria_id);
        $vaihtoehdot = Vaihtoehto::haeVaihtoehdot($id);       
        View::make('Vote/show.html', array('aanestys' => $aanestys, 'vaihtoehdot' => $vaihtoehdot));
    }

    public static function addOptions() {
        self::check_logged_in();
        View::make('Vote/vastausvaihtoehdot.html');
    }

    public static function edit($id) {  
//        self::check_logged_in();
        $aanestys = Aanestys::find($id);
        
        $attributes = array(
            'nimi' => $aanestys->nimi,
            'sulkeutumispaiva' => $aanestys->sulkeutumispaiva,
            'kuvaus' => $aanestys->kuvaus,
            'id' => $id
        );
        
        View::make('Vote/editVote.html', array('attributes' => $aanestys));
    }

    public static function store() {
        
        $params = $_POST;

        $kategoria;

        if (isset($params['kategoria'])) {
            $nimi = $params['kategoria'];

            $kategoria = Kategoria::findNimi($nimi);
        }

        if ($kategoria == null) {
            $kategoria = new Kategoria(array(
                'nimi' => $params['kategoria']
            ));
            $kategoria->save();
        }


        $attributes = (array(
            'nimi' => $params['nimi'],
            'kategoria_id' => $kategoria->id,
            'sulkeutumispaiva' => $params['sulkeutumispaiva'],
            'kuvaus' => $params['kuvaus']
        ));

//        Kint::dump($params);
        $vote = new Aanestys($attributes);
        $errors = $vote->errors();
        
        if(count($errors) == 0) {
            $vote->save();
            Redirect::to('/vote/options/' . $vote->id, array('message' => 'Lisää vielä vaihtoehdot', 'vote' => $vote));
        } else {
            View::make('/Vote/newVote.html', array('errors' => $errors, 'attributes' => $attributes));
        }
        

        

        //View::make('Vote/vastausvaihtoehdot.html');
        
//        View::make('Vote/vastausvaihtoehdot.html', array('message' => 'Lisää vielä vaihtoehdot', 'vote' => $vote));
    }
    
    public static function update($id) {
        $params = $_POST;

//        $kategoria;
//
//        if (isset($params['kategoria'])) {
//            $nimi = $params['kategoria'];
//
//            $kategoria = Kategoria::findNimi($nimi);
//        }
//
//        if ($kategoria == null) {
//            $kategoria = new Kategoria(array(
//                'nimi' => $params['kategoria']
//            ));
//            $kategoria->save();
//        }


        $attributes = (array(          
            'nimi' => $params['nimi'],
//            'kategoria_id' => $kategoria->id,
            'sulkeutumispaiva' => $params['sulkeutumispaiva'],
            'kuvaus' => $params['kuvaus'],
            'id' => $id
        ));

        $vote = new Aanestys($attributes);
        $errors = $vote->errors();
        
        if(count($errors) == 0) {
            $vote->update();
//            Redirect::to('/vote/:id/' . $vote->id, array('message' => 'Äänestystä muokattu!', 'vote' => $vote));
            Redirect::to('/vote/'. $id, array('message' =>  'Äänestystä muokattu!'));
        } else {
//            $vote->update();
            View::make('/Vote/editVote.html', array('errors' => $errors, 'attributes' => $attributes));
//            Redirect::to('/vote/:id/' . $vote->id, array('message' => 'Äänestystä muokattu!', 'vote' => $vote));
        }
    }

    public static function storeOptions($id) {
        
        $params = $_POST;

        foreach ($params['fields'] as $row) {
            $vaihtoehto = new vaihtoehto(array(
                'aanestys_id' => $id,
                'vaihtoehto' => $row
            ));

            $vaihtoehto->save();
        }

        Redirect::to('/vote/' . $id, array('message' => 'Äänestys on nyt lisätty'));
    }
    
    public static function destroy($id) {       
        $aanestys = new Aanestys (array('id' => $id));
        $aanestys->destroy();

    }

}
