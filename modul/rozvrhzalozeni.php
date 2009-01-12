<?php
class rozvrhzalozeni
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
		
		$sql = "SELECT	p.nazev,
						p.prednaska,
						p.pocet_kreditu,
						p.zkouska,
						concat(h.zacatek, ' - ', h.konec) AS cas,
						h.den,
						h.tyden,
						h.kapacita,
						p.ID_predmet
						
						
				FROM	predmet p
				LEFT JOIN hodina h ON h.ID_predmet = p.ID_predmet";
		
		$zobraz['rozvrh'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC); // do proměnné result vytáhne všechny řádky DB ve formátu: 
		/*
		 * $result [cislo_radku(0-xxx][nazev sloupce] = hodnota;
		 */
		
		$sl->zobraz($zobraz, 'rozvrhzalozeni.tpl'); // preda sablone hodnoty pole zobraz a zobrazi je v sablone ucebny.tpl
		
		
		
	}
	
	
	public function uprav($sl)
	{
		return 1;
	}
	
	public function vloz($sl)
	{
		$session	= $sl->getSession(); // zde je vytáhne obsah proměnné $_SESSION
		$post		= $sl->getPost(); // zde je vytáhne obsah proměnné $_POST
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		$get		= $sl->getGet();
		
		$input['ID_predmet'] = $zobraz['ID_predmet'] = $get['predmet'];
		$input['ID_semestr'] = 1;
		
		$zobraz['zacatek'] = '';
		$zobraz['konec'] = '';
		$zobraz['den'] = 'nic';
		$zobraz['ucebna'] = 'nic';
		$zobraz['ucitel'] = 'nic';
		$zobraz['tyden'] = 'nic';
		$zobraz['kapacita'] = '';
		$zobraz['chybazacatek'] = false;
		$zobraz['chybakonec'] = false;
		$zobraz['chybaden'] = false;
		$zobraz['chybatyden'] = false;
		$zobraz['chybaucebna'] = false;
		$zobraz['chybaucitel'] = false;
		$zobraz['chybakapacita'] = false;
		
		
		if(empty($post))
		{
			$formular = true;
		}
		else
		{
			$formular = false;
			
			$zobraz = array_merge($zobraz, $post); // predani post na zobraz;
			
			if (ereg('[0-9]{1,2}:[0-9]{2}',$zobraz['zacatek']))
			{
				$input['zacatek'] = $zobraz['zacatek'];
			}
			else
			{
				$formular = true;
				$zobraz['chybazacatek'] = true;
			}

			if (ereg('[0-9]{1,2}:[0-9]{2}',$zobraz['konec']))
			{
				$input['konec'] = $zobraz['konec'];
			}
			else
			{
				$formular = true;
				$zobraz['chybakonec'] = true;
			}
			
			if (is_numeric($zobraz['den']))
			{
				switch($zobraz['den'])
				{
					case 0:
						$input['den'] = 'pondělí';
					break;
					case 1:
						$input['den'] = 'úterý';
					break;
					case 2:
						$input['den'] = 'středa';
					break;
					case 3:
						$input['den'] = 'čtvrtek';
					break;
					case 4:
						$input['den'] = 'pátek';
					break;
					case 5:
						$input['den'] = 'sobota';
					break;
					case 6:
						$input['den'] = 'neděle';
					break;
				}
			}
			else
			{
				$formular = true;
				$zobraz['chybaden'] = true;
			}
			
			if (is_numeric($zobraz['tyden']))
			{
				switch ($zobraz['tyden'])
				{
					case 0:
						$input['tyden'] = 'všechny';
					break;
					case 1:
						$input['tyden'] = 'lichý';
					break;
					case 2:
						$input['tyden'] = 'sudý';
					break;
				}
				 
			}
			else
			{
				$formular = true;
				$zobraz['chybatyden'] = true;
			}
			
			if (is_numeric($zobraz['ucebna']))
			{
				$input['ID_ucebna'] = $zobraz['ucebna'];
			}
			else
			{
				$formular = true;
				$zobraz['chybaucebna'] = true;
			}			

			if (is_numeric($zobraz['ucitel']))
			{
				$input['ID_uzivatel_vyucujici'] = $zobraz['ucitel'];
			}
			else
			{
				$formular = true;
				$zobraz['chybaucitel'] = true;
			}
			
			if (is_numeric($zobraz['kapacita']))
			{
				$input['kapacita'] = $zobraz['kapacita'];
			}
			else
			{
				$formular = true;
				$zobraz['chybakapacita'] = true;
			}
			
		}
		
		if ($formular)
		{
			$sql = "SELECT nazev FROM predmet WHERE ID_predmet = '$input[ID_predmet]'";
			$result = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
			
			$zobraz['predmet'] = $result['nazev'];
			$zobraz['dny'] = array('nic' => '-', 0 => 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota', 'neděle');
			$zobraz['tydny'] = array('nic' => '-', 0 => 'všechny', 'lichý', 'sudý');
			
			$sql = "SELECT concat(jmeno, ' ',prijmeni) AS vyucujici, ID_uzivatel FROM uzivatel WHERE typ='učitel'";

			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			$zobraz['vyucujici']['nic'] = '-';
			foreach($result as $typ) // převede na pole vhodné pro zobrazení....
			{
				$key = $typ['ID_uzivatel'];
				$zobraz['vyucujici'][$key] = $typ['vyucujici'];
			}
			
			$sql = "SELECT concat(ut.typ, ' - ', u.nazev, ' - ', u.kapacita) AS ucebna, ID_ucebna FROM ucebna u JOIN ucebna_typ ut ON u.ID_typ = ut.ID_typ";
			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			$zobraz['ucebny']['nic'] = '-';
			foreach($result as $typ) // převede na pole vhodné pro zobrazení....
			{
				$key = $typ['ID_ucebna'];
				$zobraz['ucebny'][$key] = $typ['ucebna'];
			}
					
			$sl->zobraz($zobraz, 'rozvrh-zalozeni-formular.tpl');
		}
		else
		{
			try
			{
				$db->begintransaction(); //začátek transakce
				
				$sql = $sl->ArrayToSql($input, 'hodina');

				$db->query($sql);

				$db->commit(); //commitnutí tranaskce
			}
			catch (PDOException $e)
			{
				/*
				 * když byla zachycena vyjímka v SQL zobrazí se chyba a konec
				 */
				$pdo->rollBack();
				die($e);
			}
			
			
			
			header('location: ./?modul=rozvrhzalozeni&metoda=zobraz');
		}
	}
	
	public function vymaz($sl)
	{
		return 1;
	}

}

?>
	