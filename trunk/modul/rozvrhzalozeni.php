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
		
		$sql = "SELECT	h.ID_hodina,
						p.nazev,
						p.pocet_kreditu,
						p.zkouska,
						concat(DATE_FORMAT(h.zacatek, '%H:%i'), ' - ', DATE_FORMAT(h.konec, '%H:%i')) AS cas,
						h.den,
						h.tyden,
						h.kapacita
						
						
				FROM	predmet p
				JOIN hodina h ON h.ID_predmet = p.ID_predmet";
		
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
		
				
		$zobraz['chybapredmet'] = false;
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
			$zobraz['zacatek'] = '';
			$zobraz['konec'] = '';
			$zobraz['kapacita'] = '';
			$zobraz['den'] = 'nic';
			$zobraz['ucebna'] = 'nic';
			$zobraz['ucitel'] = 'nic';
			$zobraz['tyden'] = 'nic';
			$zobraz['predmet'] = 'nic';
		}
		else
		{
			$formular = false;
			
			$zobraz['zacatek'] = $post['zacatek'];
			$zobraz['konec'] = $post['konec'];
			$zobraz['kapacita'] = $post['kapacita'];
			$zobraz['den'] = $post['den'];
			$zobraz['ucebna'] = $post['ucebna'];
			$zobraz['ucitel'] = $post['ucitel'];
			$zobraz['tyden'] = $post['tyden'];
			$zobraz['predmet'] = $post['predmet'];

			if ($zobraz['predmet'] == 'nic')
			{
				$formular = true;
				$zobraz['chybapredmet'] = true;
			}
			else
			{
				$input['ID_predmet'] = $zobraz['predmet'];
			}
			
			if ($zobraz['zacatek'] == 'nic')
			{
				$formular = true;
				$zobraz['chybazacatek'] = true;
			}
			else
			{
				$input['zacatek'] = $zobraz['zacatek'] . ':00:00';
			}

			if ($zobraz['konec'] == 'nic')
			{
				$formular = true;
				$zobraz['chybakonec'] = true;
			}
			else
			{
				$input['konec'] = $zobraz['konec'] . ':00:00';
			}
			
			if (is_numeric($zobraz['den']))
			{
				switch($zobraz['den'])
				{
					case 0:
						$input['den'] = 'pondeli';
					break;
					case 1:
						$input['den'] = 'utery';
					break;
					case 2:
						$input['den'] = 'streda';
					break;
					case 3:
						$input['den'] = 'ctvrtek';
					break;
					case 4:
						$input['den'] = 'patek';
					break;
					case 5:
						$input['den'] = 'sobota';
					break;
					case 6:
						$input['den'] = 'nedele';
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
			$zobraz['dny'] = array('nic' => '---', 0 => 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota', 'neděle');
			$zobraz['tydny'] = array('nic' => '---', 0 => 'všechny', 'lichý', 'sudý');
			$zobraz['hodiny'] = array('nic' => '---', 0 => '00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
			
			$sql = "SELECT concat(jmeno, ' ',prijmeni) AS vyucujici, ID_uzivatel FROM uzivatel WHERE typ='ucitel'";

			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			$zobraz['vyucujici']['nic'] = '---';
			foreach($result as $typ) // převede na pole vhodné pro zobrazení....
			{
				$key = $typ['ID_uzivatel'];
				$zobraz['vyucujici'][$key] = $typ['vyucujici'];
			}
			
			$sql = "SELECT concat(ut.typ, ' - ', u.nazev, ' - ', u.kapacita) AS ucebna, ID_ucebna FROM ucebna u JOIN ucebna_typ ut ON u.ID_typ = ut.ID_typ";
			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			$zobraz['ucebny']['nic'] = '---';
			foreach($result as $typ) // převede na pole vhodné pro zobrazení....
			{
				$key = $typ['ID_ucebna'];
				$zobraz['ucebny'][$key] = $typ['ucebna'];
			}
					
			$sql = "SELECT ID_predmet, nazev FROM predmet";
			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			$zobraz['predmety']['nic'] = '---';
			foreach($result as $typ) // převede na pole vhodné pro zobrazení....
			{
				$key = $typ['ID_predmet'];
				$zobraz['predmety'][$key] = $typ['nazev'];
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
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		$get		= $sl->getGet();
		
		if (isset($get['hodina']))
		{
			$id = $get['hodina'];
		
			try
			{
				$db->begintransaction(); //začátek transakce

				$sql = "DELETE FROM hodina WHERE ID_hodina = '$id'";

				$db->query($sql);

				$db->commit(); //commitnutí tranaskce
			}
			catch (PDOException $e)
			{
				/**
				 * když byla zachycena vyjímka v SQL zobrazí se chyba a konec
				 */
				$pdo->rollBack();
				die($e);
			}
		
		}
		
		header('location: ./?modul=rozvrhzalozeni&metoda=zobraz');
	}

}

?>
	