<?php
class zkousky
{
   //definice atriutù
   private $ID_uzivatel;
   //------------------------

//zaèátek metody __construct
   public function __construct($ID_uzivatel)  //metoda která definuje atributy
   {
      //uložení hodnoty pøedané metodou do atributu
      $this->ID_uzivatel = $ID_uzivatel;
      //------------------------
   }
//konec metody __konstruct
	public function uprav($sl)
	{
	//známkování zkoušky
		return 1;
	}
	
	public function vloz($sl)
	{
		$session	= $sl->getSession();
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$zobraz['typchyba'] = false;
		$zobraz['typchybaexistuje'] = false;
		$zobraz['typ'] = '';
		
		if(empty($post))
		{
			$formular = true;
		}
		else
		{
			$formular = false;
			
			$zobraz['typ'] = $post['typ'];
			
			if ($post['typ'] == '') //pokud je typ prázdný zobrazí chybu
			{
				$zobraz['nazevchyba'] = true;
				$formular = true;
			}
			else
			{
				/**
				 * testování zda typ uèebny již nenexistuje...
				 */
				
				$sql = "SELECT typ FROM ucebna_typ WHERE typ = '$zobraz[typ]'";
				
				$result = $db->query($sql)->fetch();
				if($result)
				{
					$formular = true;
					$zobraz['typchybaexistuje'] = true;
				}
				else
				{
					$input['typ'] = $post['typ'];
				}
					
			}
			
		}
		
		if ($formular)
		{
			$sl->zobraz($zobraz, 'zkousky-formular.tpl');
		}
		else
		{
			try
			{
				$db->begintransaction(); //zaèátek transakce
				
				$sql = $sl->ArrayToSql($input, 'ucebna_typ');

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
			
			
			
			header('location: ./?modul=ucebnytypy&metoda=zobraz');
		}
		
		//var_dump($session);
	}
	
	public function zobraz($sl)
	{
		$session	= $sl->getSession(); // zde je vytáhne obsah promìnné $_SESSION
		$post		= $sl->getPost(); // zde je vytáhne obsah promìnné $_POST
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		
		if (!empty($post))
		{
			try
			{
				$db->begintransaction(); //zaèátek transakce
				
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
				
				header('location: ./?modul=zk&metoda=zobraz');
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
		
		$sql = "SELECT	zt.ID_zkouska,
						concat(h.jmeno, ' ',h.primeni) AS zkousejici,
						u.nazev AS ucebna_nazev,
						p.nazev AS predmet_nazev,
						concat(zt.zacatek, ' - ', zt.konec) AS cas,
						zt.kapacita - count(zs.ID_uzivatel_zkouseny) AS kapacita
						
				FROM	zkouska_termin zt
				LEFT JOIN uzivatel u ON zt.ID_uzivatel_zkousejici = h.ID_uzivatel
				LEFT JOIN predmet p ON zt.ID_predmet = p.ID_predmet
				LEFT JOIN zkouska_student p ON zt.ID_zkouska = zs.ID_zkouska
				LEFT JOIN ucebna p ON zt.ID_ucebna = u.ID_ucebna
				GROUP BY ID_zkouska
				
				";
		
	//	$sql = "SELECT ID_hodina FROM ID_hodina_student WHERE ID_uzivatel_student = '$session[ID_uzivatel]'";
		
		$zobraz['rozvrh'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC); // do promìnné result vytáhne všechny øádky DB ve formátu: 
		
		
		
		
		$sl->zobraz($zobraz, 'zkouskaprihlaseni.tpl'); // preda sablone hodnoty pole zobraz a zobrazi je v sablone ucebny.tpl
	}
	
	public function vymaz($sl)
	{
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		$get		= $sl->getGet();
		
		if (isset($get['zkouska']))
		{
			$id = $get['zkouska'];
		
			try
			{
				$db->begintransaction(); //zaèátek transakce

				$sql = "DELETE FROM zkouska WHERE ID_zkouska = '$id'";

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
		
		header('location: ./?modul=zkousky&metoda=zobraz');
	}
	
}
?>
