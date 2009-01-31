<?php

/**
 * Spravuje typy učeben
 * @version 1.0
 */
class ucebnytypy
{
	public function __construct()
	{
	}
	/**
	 * Zobrazuje všechny typy učeben školy
	 *
	 * @param object $sl main
	 * @return void
	 *
	 */	
	public function zobraz($sl)
	{
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$sql = "SELECT	ID_typ, typ
				FROM 	ucebna_typ";
		
		$zobraz['ucebny'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
		$sl->zobraz($zobraz, 'ucebnytypy.tpl');

	}
	/**
	 * Upravuje název typu učebny
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
	 * vloží nový typ učebny
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
				 * testování zda typ učebny již nenexistuje...
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
			$sl->zobraz($zobraz, 'ucebnytypy-formular.tpl');
		}
		else
		{
			try
			{
				$db->begintransaction(); //začátek transakce
				
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
	/**
	 * vymaže typ školní učebny
	 *
	 * @param object $sl main
	 * @return void
	 *
	 */	
	public function vymaz($sl)
	{
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		$get		= $sl->getGet();
		
		if (isset($get['ucebnatyp']))
		{
			$id = $get['ucebnatyp'];
		
			try
			{
				$db->begintransaction(); //začátek transakce

				$sql = "DELETE FROM ucebna_typ WHERE ID_typ = '$id'";

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
		
		header('location: ./?modul=ucebnytypy&metoda=zobraz');
	}

}

?>
