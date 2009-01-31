<?php

/**
 * Spravuje vyučované předměty
 *
 * @version 1.0
 */
class predmet
{
	public function __construct()
	{
	}

	/**
	 * zobrazuje všechny dostupné předměty
	 *
	 * @param object $sl main
	 * @return void
	 *
	 */	
	public function zobraz($sl)
	{
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$sql = "SELECT	ID_predmet,
						nazev,
						zkouska,
						pocet_kreditu,
						concat(jmeno, ' ', prijmeni) AS jmeno
				FROM 	predmet p
				JOIN 	uzivatel u ON p.ID_uzivatel_garant = u.ID_uzivatel";
		
		$zobraz['predmety'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
		$sl->zobraz($zobraz, 'predmet.tpl');

	}

	/**
	 * upravuje studijní předmět
	 *
	 * @param object $sl main
	 * @return bool true
	 * @todo all
	 *
	 */	
	public function uprav($sl)
	{
		return 1;
	}
	
	/**
	 * Vkládá nový studijní předmět
	 *
	 * @param object $sl main
	 * @return void
	 *
	 */
	public function vloz($sl)
	{
		$session	= $sl->getSession();
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$zobraz['nazevchyba'] = false;
		$zobraz['nazevchybaexistuje'] = false;
		$zobraz['pocet_kredituchyba'] = false;
		$zobraz['chybagarant'] = false;
		
			$zobraz['nazev'] = '';
			$zobraz['pocet_kreditu'] = '';
			$zobraz['garant'] = 'nikdo';
			$zobraz['zkouska'] = 'ne';
			$zobraz['kredit'] = '';
		
		if(empty($post))
		{

			
			$formular = true;
		}
		else
		{
			$formular = false;
			
			$zobraz['nazev'] = $post['nazev'];
			
			$zobraz['pocet_kreditu'] = $post['pocet_kreditu'];
			$zobraz['garant'] = $post['garant'];
			$input['zkouska'] = $zobraz['zkouska'] = $post['zkouska'];

			
			if ($post['nazev'] == '') //pokud je nazev prázdný zobrazí chybu
			{
				$zobraz['nazevchyba'] = true;
				$formular = true;
			}
			else
			{
				/**
				 * testování zda název předmětu již nenexistuje...
				 */
				
				$sql = "SELECT nazev FROM predmet WHERE nazev = '$zobraz[nazev]'";
				
				$result = $db->query($sql)->fetch();
				if($result)
				{
					$formular = true;
					$zobraz['nazevchybaexistuje'] = true;
				}
				else
				{
					$input['nazev'] = $post['nazev'];
				}
			}
			
			if ($post['pocet_kreditu'] == '' || $post['pocet_kreditu'] <= 0 || !is_numeric($post['pocet_kreditu']))
			{
				$formular = true;
				$zobraz['pocet_kredituchyba'] = true;
			}
			else
			{
				$input['pocet_kreditu'] = $post['pocet_kreditu'];
			}
			if(!is_numeric($post['garant']))
			{
				$formular = true;
				$zobraz['chybagarant'] = true;
			}
			else
			{
				$input['ID_uzivatel_garant'] = $post['garant'];
			}
		}
		
		if ($formular)
		{
			/*
			 * @todo předměty
			 */
			$sql = "SELECT	ID_uzivatel,
							concat(jmeno, ' ', prijmeni) AS ucitel
					FROM	uzivatel
					WHERE	typ = 2
					ORDER BY prijmeni";

					
			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

			$zobraz['ucitele']['nikdo'] = '---';
			foreach($result as $typ) // převede na pole vhodné pro zobrazení....
			{
				$key = $typ['ID_uzivatel'];
				$zobraz['ucitele'][$key] = $typ['ucitel'];
			}
			
			$zobraz['anoNe']['ne'] = 'ne';
			$zobraz['anoNe']['ano'] = 'ano';
			
			$sl->zobraz($zobraz, 'predmet-formular.tpl');
		}
		else
		{
			try
			{
				$db->begintransaction(); //začátek transakce
				
				$sql = $sl->ArrayToSql($input, 'predmet');

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
			
			
			
			header('location: ./?modul=predmet&metoda=zobraz');
		}
		
		//var_dump($session);
	}
	
	/**
	 * vymaže předmět
	 *
	 * @param object $sl main
	 * @return void
	 *
	 */
	public function vymaz($sl)
	{
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		$get		= $sl->getGet();
		
		if (isset($get['predmet']))
		{
			$id = $get['predmet'];
		
			try
			{
				$db->begintransaction(); //začátek transakce

				$sql = "DELETE FROM predmet WHERE ID_predmet = '$id'";

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
		
		header('location: ./?modul=predmet&metoda=zobraz');
	}


}

?>
