<?php


class VoteController extends BaseController {
	
	public static function index(){
		$aanestykset = Aanestys::all();
		View::make('Vote/index.html', array('aanestykset' => $aanestykset));
}

	public static function findOne(){
		$aanestys = Aanestys::find(1);
		View::make('Vote/show.html', array('aanestys'=> $aanestys));
	}

	public static function store(){
		$params = $_POST;
		$vote = new vote(array(
			'nimi' => $params['name'],
			'kategoria' => $params['kategoria'],
			'alkamispaiva' => $params['alkamispaiva'],
			'sulkeutumispaiva' => $params['sulkeutumispaiva'],
			'kuvaus' => $params['kuvaus'],
			'vastausvaihtoehto1' => $params['vastausvaihtoehto1'],
			'vastausvaihtoehto2' => $params['vastausvaihtoehto2'],
			'vastausvaihtoehto3' => $params['vastausvaihtoehto3']
		));

		Kint::dump($params);

		$vote->save();

		Redirect::to('/vote' . $vote->id, array('message' => 'Äänestys on lisätty!'));
	}
}