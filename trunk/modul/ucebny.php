<?php
class ucebny
{
	public function __construct()
	{
	}
	
	public function zobraz($sl)
	{
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$sql = "SELECT	ID_ucebna, typ, nazev, kapacita
				FROM 	ucebna u
				JOIN 	ucebna_typ ut ON u.ID_typ = ut.ID_typ";
		
		$zobraz['ucebny'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
		$sl->zobraz($zobraz, 'ucebny.tpl');

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
		$zobraz['kapacitachyba'] = false;
		$zobraz['typchyba'] = false;
		
		$zobraz['nazev'] = '';
		$zobraz['typ'] = '';
		$zobraz['kapacita'] = '';
		
		if(empty($post))
		{
			$formular = true;
		}
		else
		{
			$formular = false;
			
			$zobraz['nazev'] = $post['nazev'];
			$zobraz['typ'] = $post['typ'];
			$zobraz['kapacita'] = $post['kapacita'];
			
			if (!is_numeric($post['typ']))
			{
				$zobraz['typchyba'] = true;
				$formular = true;
			}
			else
			{
				$input['ID_typ'] = $post['typ'];
			}
			
			if ($post['nazev'] == '') //pokud je typ prázdný zobrazí chybu
			{
				$zobraz['nazevchyba'] = true;
				$formular = true;
			}
			else
			{
				/**
				 * testování zda název učebny již nenexistuje...
				 */
				
				$sql = "SELECT nazev FROM ucebna WHERE nazev = '$zobraz[nazev]'";
				
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
			
			if ($post['kapacita'] == '' || $post['kapacita'] <= 0 || is_int($post['kapacita']))
			{
				$formular = true;
				$zobraz['kapacitachyba'] = true;
			}
			else
			{
				$input['kapacita'] = $post['kapacita'];
			}
			
		}
		
		if ($formular)
		{
			/*
			 * @todo předměty
			 */
			$sql = "SELECT ID_typ, typ FROM ucebna_typ ORDER BY typ";
			$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

			$zobraz['typy']['nic'] = '---';
			if ($result)
			{			
				foreach($result as $typ) // převede na pole vhodné pro zobrazení....
				{
					$key = $typ['ID_typ'];
					$zobraz['typy'][$key] = $typ['typ'];
				}
			}
			
			$sl->zobraz($zobraz, 'ucebny-formular.tpl');
		}
		else
		{
			try
			{
				$db->begintransaction(); //začátek transakce
				
				$sql = $sl->ArrayToSql($input, 'ucebna');

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
			
			
			
			header('location: ./?modul=ucebny&metoda=zobraz');
		}
		
		//var_dump($session);
	}
	
		
	public function vymaz($sl)
	{
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		$get		= $sl->getGet();
		
		if (isset($get['ucebna']))
		{
			$id = $get['ucebna'];
		
			try
			{
				$db->begintransaction(); //začátek transakce

				$sql = "DELETE FROM ucebna WHERE ID_ucebna = '$id'";

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
		
		header('location: ./?modul=ucebny&metoda=zobraz');
	}

}

?>
