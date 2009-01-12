<?php
class rozvrhprihlaseni
{
	/**
	 * název třídy musí být stejný jako název 
	 *
	 */
	public function __construct()
	{
	}
	
	public function zobraz($sl)
	{
		$session	= $sl->getSession(); // zde je vytáhne obsah proměnné $_SESSION
		$post		= $sl->getPost(); // zde je vytáhne obsah proměnné $_POST
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		
		if (!empty($post))
		{
			try
			{
				$db->begintransaction(); //začátek transakce
				
				$db->query("DELETE FROM hodina_student WHERE ID_uzivatel_student = '$session[ID_uzivatel]'");
				
				if (isset($post['predmet']))
				{
					foreach ($post['predmet'] as $predmet)
					{
						$input['ID_uzivatel_student'] = $session['ID_uzivatel'];
						$input['ID_hodina'] = $predmet;
						
						$sql = $sl->ArrayToSql($input, 'hodina_student');

						$db->query($sql);
					}
				}

				$db->commit(); //commitnutí tranaskce
				
				header('location: ./?modul=rozvrh&metoda=zobraz');
			}
			catch (PDOException $e)
			{
				/*
				 * když byla zachycena vyjímka v SQL zobrazí se chyba a konec
				 */
				$pdo->rollBack();
				die($e);
			}
		}
		
		$sql = "SELECT	h.ID_hodina,
						p.nazev,
						p.prednaska,
						p.pocet_kreditu,
						p.zkouska,
						concat(h.zacatek, ' - ', h.konec) AS cas,
						h.den,
						h.tyden,
						h.kapacita - count(hs.ID_uzivatel_student) AS kapacita,
						p.ID_predmet
						
				FROM	hodina h
				LEFT JOIN predmet p ON h.ID_predmet = p.ID_predmet
				LEFT JOIN hodina_student hs ON h.ID_hodina = hs.ID_hodina
				GROUP BY ID_hodina
				
				";
		
	//	$sql = "SELECT ID_hodina FROM ID_hodina_student WHERE ID_uzivatel_student = '$session[ID_uzivatel]'";
		
		$zobraz['rozvrh'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC); // do proměnné result vytáhne všechny řádky DB ve formátu: 
		
		
		
		
		$sl->zobraz($zobraz, 'rozvrhprihlaseni.tpl'); // preda sablone hodnoty pole zobraz a zobrazi je v sablone ucebny.tpl
	}
	
	
	public function uprav($sl)
	{
		return 1;
	}
	
	public function vloz($sl)
	{
		return 1;
	}
	
	public function vymaz($sl)
	{
		return 1;
	}

}

?>
	