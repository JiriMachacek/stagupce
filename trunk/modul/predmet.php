<?php
class predmet
{
	public function __construct()
	{
	}
	
	public function zobraz($sl)
	{
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$sql = "SELECT	prednaska, nazev, zkouska, pocet_kreditu
				FROM 	predmet u
				JOIN 	uzivatele ut ON u.ID_uzivatel_garant = ut.ID_uzivatel";
		
		$zobraz['predmet'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
		$sl->zobraz($zobraz, 'predmet.tpl');

	}
	
	public function uprav($sl)
	{
		return 1;
	}
	
	public function vloz($sl)
	{
		$session	= $sl->getSession();
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$zobraz['nazevchyba'] = false;
		$zobraz['nazevchybaexistuje'] = false;
		$zobraz['pocet_kredituchyba'] = false;
		
		$zobraz['nazev'] = '';
		$zobraz['pocet_kreditu'] = '';
		
		if(empty($post))
		{
			$formular = true;
		}
		else
		{
			$formular = false;
			
			$zobraz['nazev'] = $post['nazev'];
			$zobraz['pocet_kreditu'] = $post['pocet_kreditu'];
			
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
			
			if ($post['pocet_kreditu'] == '' || $post['pocet_kreditu'] <= 0 || is_int($post['pocet_kreditu']))
			{
				$formular = true;
				$zobraz['pocet_kreditu'] = true;
			}
			else
			{
				$input['pocet_kreditu'] = $post['pocet_kreditu'];
			}
			
		}
		
		if ($formular)
		{
			/*
			 * @todo předměty
			 */
			$sql = "SELECT ID_uzivatel_garant, typ FROM predmet ORDER BY typ";
			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

			
			foreach($result as $typ) // převede na pole vhodné pro zobrazení....
			{
				$key = $typ['ID_typ'];
				$zobraz['typy'][$key] = $typ['typ'];
			}
			
			$sl->zobraz($zobraz, 'predmet-formular.tpl');
		}
		else
		{
			try
			{
				$db->begintransaction(); //začátek transakce
				
				$sql = $sl->ArrayToSql($input, 'nazev');

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
	
		
	public function vymaz($sl)
	{
		return 1;
	}

}

?>
