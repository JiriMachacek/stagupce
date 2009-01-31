<?php

/**
 * třída materiály spravuje studijní materiály
 * @version 0.8b
 */
class materialy
{
	public function __construct()
	{
	}
	
	/**
	 * zobrazuje všechny dostupné studijní materiály
	 *
	 * @param object $sl main
	 * @return void
	 *
	 */
	public function zobraz($sl)
	{
		$session	= $sl->getSession();
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$sql = "SELECT	ID_material,
						CONCAT(u.jmeno, ' ', u.prijmeni) AS jmeno,
						m.popis,
						m.nazev,
						m.upload,
						m.velikost,
						m.soubor
				FROM 	materialy m
				JOIN 	uzivatel u ON m.ID_uzivatel = u.ID_uzivatel";
		
		$zobraz['materialy'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
		$sl->zobraz($zobraz, 'materialy.tpl');
		
	}
	
	/**
	 * upravuvuje studijní materiál
	 *
	 * @param object $sl main
	 * @return void
	 * @todo all
	 */
	public function uprav($sl)
	{
		return 1;
	}
	
	/**
	 * vkládá nový studijní materiál
	 *
	 * @param object $sl main
	 * @return void
	 * @todo fix
	 */
	public function vloz($sl)
	{
		$session	= $sl->getSession();
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$zobraz['nazevchyba'] = false;
		$zobraz['souborchyba'] = false;
		
		if(empty($post))
		{
			$zobraz['nazev'] = '';
			$zobraz['soubor'] = '';
			$zobraz['popis'] = '';

			$formular = true;
		}
		else
		{
			$formular = false;
			$zobraz['nazev'] = $post['nazev'];
			$zobraz['popis'] = $post['popis'];
			
			

			if (isset($_FILES))
			{
				$files = $_FILES;
				
				//přepsání prom. pro ulehčení práce
			  	
				$soubor = $files["soubor"]["tmp_name"];
				$soubor_name = $files["soubor"]["name"];
				$uloziste = cestaMaterialy.$soubor_name; //tmp_uložení souboru
				
				$input['velikost'] = $files["soubor"]['size'];
				$input['soubor'] = $soubor_name;
				
				
				//------------------------
				
				if (move_uploaded_file($soubor, $uloziste))
				{
					chmod ($uloziste, 0646);
				}
				else
				{
					$formular = true;
					$zobraz['souborchyba'] = true;
				}
				

			}
			else
			{
				$formular = true;
			}

			if ($post['nazev'] == '')
			{
				$zobraz['nazevchyba'] = true;
				$formular = true;
			}
			else
			{
				$input['nazev'] = $post['nazev'];
			}
			
			
			if ($post['popis'] <> '')
			{
				$input['popis'] = $post['popis'];
			}
			
		}
		
		if ($formular)
		{
			$sql = "SELECT ID_predmet, nazev FROM predmet p ";
			/*
			 * @todo předměty
			 */
			if($session['typ'] = 'ucitel')
			{
				$ucitel_id = $session['ID_uzivatel'];
				$sql .= "JOIN hodina h ON p.ID_predmet = h.ID_predmet
						 WHERE ID_uzivatel_vyucujici = '$ucitel_id'";
			}

			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			$zobraz['predmety']['nic'] = '---';
			if ($result)
			{			
				foreach($result as $typ) // převede na pole vhodné pro zobrazení....
				{
					$key = $typ['ID_predmet'];
					$zobraz['predmety'][$key] = $typ['nazev'];
				}
			}
			
			
			$sl->zobraz($zobraz, 'materialy-formular.tpl');
		}
		else
		{
			try
			{
				$db->begintransaction(); //začátek transakce
				
				$input['ID_uzivatel'] = $session['ID_uzivatel'];
				$input['upload'] = date('Y-m-d H:i:s');
				
				$sql = $sl->ArrayToSql($input, 'materialy');
				
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
			
			
			
			header('location: ./?modul=materialy&metoda=zobraz');
		}
		
		//var_dump($session);
	}

	/**
	 * vymazává studijní materiál
	 *
	 * @param object $sl main
	 * @return void
	 * @todo all
	 */
	public function vymaz($sl)
	{
		return 1;
	}

}

?>
