<?php
class Aanestys extends BaseModel {
public $id, $kategoria_id, $nimi, $kuvaus, $kaynnissa, $yksityinen,$alkamispaiva, $sulkeutumispaiva;

public function _construct($attributes) {
		parent::_construct($attributes);		
	}

	

	public static function all() {
		$query = DB::connection()->prepare('SELECT * FROM Aanestys');

		$query->execute();

		$rows = $query->fetchAll();
		$Aanestykset = Array();

		foreach($rows as $row) {
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

		if($row) {
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

	public function save() {
		$query = DB::connection()->prepare('INSERT INTO aanestys(nimi, kategoria, alkamispaiva, sulkeutumispaiva, kuvaus, vastausvaihtoehto1, vastausvaihtoehto2, vastausvaihtoehto3) VALUES (:nimi, :kategoria, :alkamispaiva, :sulkeutumispaiva, :kuvaus, :vastausvaihtoehto1, :vastausvaihtoehto2, :vastausvaihtoehto3) RETURNING id');

		$query->execute(array('nimi' => $this->nimi, 'kategoria' => $this->kategoria, 'alkamispaiva' => $this->kategoria, 'sulkeutumispaiva' => $this->sulkeutumispaiva, 'kuvaus' => $this->sulkeutumispaiva, 'vastausvaihtoehto1' => $this->vastausvaihtoehto1, 'vastausvaihtoehto2' => $this->vastausvaihtoehto2, 'vastausvaihtoehto3' => $this->vastausvaihtoehto3));

		$row = $query->fetch();

		$this->id = $row['id'];
	}
}