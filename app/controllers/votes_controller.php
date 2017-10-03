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
        View::make('Vote/newVote.html');
    }

    public static function findOne($id) {
        $aanestys = Aanestys::find($id);
        $aanestys->kategoria_id = Aanestys::getCategoryNames($aanestys->kategoria_id);
        View::make('Vote/show.html', array('aanestys' => $aanestys));
    }

    public static function addOptions() {
        View::make('Vote/vastausvaihtoehdot.html');
    }

    public static function edit($id) {
        $aanestys = Aanestys::find($id);
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


        $vote = new Aanestys(array(
            'nimi' => $params['nimi'],
            'kategoria_id' => $kategoria->id,
            'alkamispaiva' => $params['alkamispaiva'],
            'sulkeutumispaiva' => $params['sulkeutumispaiva'],
            'kuvaus' => $params['kuvaus']
        ));

        Kint::dump($params);

        $vote->save();

        //View::make('Vote/vastausvaihtoehdot.html');
        Redirect::to('/vote/options/' . $vote->id, array('message' => 'Lisää vielä vaihtoehdot', 'vote' => $vote));
//        View::make('Vote/vastausvaihtoehdot.html', array('message' => 'Lisää vielä vaihtoehdot', 'vote' => $vote));
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

}
