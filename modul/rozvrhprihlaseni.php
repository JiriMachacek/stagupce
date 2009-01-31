<?php

/**
 * řeší přihlašování studentů na jednotlivé předměty, které se předtím definují v modulu rozvrh zalozeni
 * @version 0.9
 */
class rozvrhprihlaseni
{
	public function __construct()
	{
	}
	
	/**
	 * zobrazí předměty na které se lze přihlásit
	 *
	 * @param object $sl main
	 * @return void
	 *
	 */
	public function zobraz($sl)
	{
		$session	= $sl->getSession(); // zde je vytáhne obsah proměnné $_SESSION
		$post		= $sl->getPost(); // zde je vytáhne obsah proměnné $_POST
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO

		if ($session['typ'] == 'admin')
		{
			$admin = TRUE;
		/**
		 *	když je uživatel admin, může upravovat rozvrh studentům
		 */ 
			$sql = "SELECT	ID_uzivatel,
							concat(jmeno, '', prijmeni) AS jmeno
					FROM	uzivatel
					WHERE	typ = 'student'
							";

			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			$zobraz['uzivatele']['nic'] = '---';
			if ($result)
			{			
				foreach($result as $typ) // převede na pole vhodné pro zobrazení....
				{
					$key = $typ['ID_uzivatel'];
					$zobraz['uzivatele'][$key] = $typ['jmeno'];
				}
			}
			
			if(isset($post['uzivatel']))
			{
				$zobraz['uzivatel'] = $post['uzivatel'];
				
				$uzivatelID = $post['uzivatel'];	
			}
			else
			{
				$zobraz['uzivatel'] = '';
				
				$uzivatelID = '0';
			}
		}
		else
		{
			$zobraz['uzivatele'] = FALSE;
			$zobraz['uzivatel'] = '';
			$uzivatelID = $session['ID_uzivatel'];
			$admin = FALSE;
		}
		
		
		if (!empty($post))
		{
			if(!$admin || isset($post['ok']))
			{
				//ADMIN NEMŮŽE MĚNIT ROZVRUH SÁM SOBĚ -> ŽÁDNÝ NEMÁ
				try
				{
					$db->begintransaction(); //začátek transakce
					
					$db->query("DELETE FROM hodina_student WHERE ID_uzivatel_student = '$uzivatelID'");
					
					if (isset($post['predmet']))
					{
						foreach ($post['predmet'] as $predmet)
						{
							$input['ID_uzivatel_student'] = $uzivatelID;
							$input['ID_hodina'] = $predmet;
							
							$sql = $sl->ArrayToSql($input, 'hodina_student');
	
							$db->query($sql);
						}
					}
	
					$db->commit(); //commitnutí tranaskce
					
					if (!$admin)
					{
						header('location: ./?modul=rozvrh&metoda=zobraz');
					}
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
		}
		else
		{
			/**
			 *	formulář neni odeslán
			 */			 			
		}
		

	
		$sql = "SELECT	h.ID_hodina,
						p.nazev,
						p.prednaska,
						p.pocet_kreditu,
						p.zkouska,
						concat(DATE_FORMAT(h.zacatek, '%H:%i'), ' - ', DATE_FORMAT(h.konec, '%H:%i')) AS cas,
						h.den,
						h.tyden,
						h.kapacita - count(hs.ID_uzivatel_student) AS kapacita,
						p.ID_predmet,
						IF
						(
							hs.ID_uzivatel_student = $uzivatelID,
						1, 0
						) AS zapsano,
						ID_uzivatel_student
						
				FROM	hodina h
				JOIN predmet p ON h.ID_predmet = p.ID_predmet
				LEFT JOIN hodina_student hs ON h.ID_hodina = hs.ID_hodina
				
				";
		
//		$sql .= "WHERE ID_uzivatel_student = '$uzivatelID' OR ID_uzivatel_student IS NULL ";
		$sql .= "GROUP BY ID_hodina";
		echo $sql;
		$zobraz['rozvrh'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC); // do proměnné result vytáhne všechny řádky DB ve formátu: 
		
		
		
		
		$sl->zobraz($zobraz, 'rozvrhprihlaseni.tpl'); // preda sablone hodnoty pole zobraz a zobrazi je v sablone ucebny.tpl
	}
	
	/**
	 * nepoužívá se, "aplikační jádro" vyžaduje
	 *
	 * @param object $sl main
	 * @return bool true
	 */	
	public function uprav($sl)
	{
		return 1;
	}
	/**
	* nepoužívá se, "aplikační jádro" vyžaduje
	*
	* @param object $sl main
	* @return bool true
	*/
	public function vloz($sl)
	{
		return 1;
	}
	/**
	* nepoužívá se, "aplikační jádro" vyžaduje
	*
	* @param object $sl main
	* @return bool true
	*/
	public function vymaz($sl)
	{
		return 1;
	}

}

?>