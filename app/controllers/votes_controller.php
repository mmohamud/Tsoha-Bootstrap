<?php

class VotesController extends BaseController {

    public static function index() {

        $aanestykset = Aanestys::all();
        foreach ($aanestykset as $aanestys) {
            $aanestys->kategoria_id = Aanestys::getCategoryNames($aanestys->kategoria_id);
            $aanestys->kayttaja_id = Aanestys::getUserName($aanestys->kayttaja_id);          
            $today = date("Y-m-d H:i:s");
            $date = $aanestys->sulkeutumispaiva;

            if ($today < $date) {
                $aanestys->kaynnissa = true;
            }
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
        $today = date("Y-m-d H:i:s");
        $date = $aanestys->sulkeutumispaiva;

        if ($today < $date) {
            $aanestys->kaynnissa = true;
        }
//        $aanestys->kayttaja_id = Aanestys::getUserName($aanestys->kayttaja_id);
        $aanestys->kategoria_id = Aanestys::getCategoryNames($aanestys->kategoria_id);
        $vaihtoehdot = Vaihtoehto::haeVaihtoehdot($id);
        
        $taulukot = array();
        foreach ($vaihtoehdot as $vaihtoehto) {
            $vaihtoehto_id = $vaihtoehto->id;
            $aaniMaara = Vaihtoehto::findNUmberOfVotes($vaihtoehto_id);
            $taulukko2 = array();
            $taulukko2[] = $vaihtoehto_id;
            $taulukko2[] = $aaniMaara;
            $taulukot [] = $taulukko2;
        }
        View::make('Vote/show.html', array('aanestys' => $aanestys, 'vaihtoehdot' => $vaihtoehdot, 'taulukot' => $taulukot));
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
//            'kayttaja_id' => $aanestys->kayttaja_id,
            'sulkeutumispaiva' => $aanestys->sulkeutumispaiva,
            'kuvaus' => $aanestys->kuvaus,
            'id' => $id
        );

        View::make('Vote/editVote.html', array('attributes' => $aanestys));
    }

    public static function store() {

        $kayttaja = BaseController::get_user_logged_in();


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
            'kayttaja_id' => $kayttaja->id,
            'sulkeutumispaiva' => $params['sulkeutumispaiva'],
            'kuvaus' => $params['kuvaus']
        ));

        $aanestys = new Aanestys($attributes);
        $errors = $aanestys->errors();


        if (count($errors) == 0) {
            $aanestys->save();
            Redirect::to('/vote/options/' . $aanestys->id, array('message' => 'Lisää vielä vaihtoehdot', 'vote' => $aanestys));
        } else {
            View::make('/Vote/newVote.html', array('errors' => $errors, 'attributes' => $attributes));
        }
  
    }

    public static function update($id) {
        $params = $_POST;
        
        $aanestys = Aanestys::find($id);
        
        $attributes = (array(
            'nimi' => $params['nimi'],
            'sulkeutumispaiva' => $params['sulkeutumispaiva'],
            'kuvaus' => $params['kuvaus'],
            'kaynnissa' => $aanestys->kaynnissa,
            'id' => $id
        ));

        $aanestys = new Aanestys($attributes);
        $errors = $aanestys->errors();


        if (count($errors) == 0) {
            $aanestys->update();
            Redirect::to('/vote/' . $id, array('message' => 'Äänestystä muokattu!'));
        } else {
            View::make('/Vote/editVote.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function storeOptions($id) {

        $params = $_POST;

        foreach ($params['fields'] as $row) {
            $vaihtoehto = new Vaihtoehto(array(
                'aanestys_id' => $id,
                'vaihtoehto' => $row
            ));
            
            $vaihtoehto->save();
        }
        Redirect::to('/vote/' . $id, array('message' => 'Äänestys on nyt lisätty'));
    }

    public static function destroy($id) {
        $aanestys = new Aanestys(array('id' => $id));
        $aanestys->destroy();
        Redirect::to('/vote' , array('message' => 'Äänestys on poistettu'));
    }
    

}
