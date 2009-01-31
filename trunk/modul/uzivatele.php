<?php

/**
 * Třída spravuje uživatele
 * @version 1.0
 */
class uzivatele
{
	public function __construct()
	{
	}
	/**
	* zobrazuje všechny uživatele systému
	*
	* @param object $sl main
	* @return void
	*
	*/
	public function zobraz($sl)
	{
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$sql = "SELECT	ID_uzivatel, jmeno, prijmeni, typ, login
				FROM 	uzivatel";
		
		$zobraz['uzivatele'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
		$sl->zobraz($zobraz, 'uzivatele.tpl');

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
	 * zobrazí formulář na vložení nového uživatele
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
	
	  	$zobraz['heslochyba'] = false;
		$zobraz['loginchyba'] = false;
		$zobraz['loginchybaexistuje'] = false;
		$zobraz['jmenochyba'] = false;
		$zobraz['prijmenichyba'] = false;
		$zobraz['typchyba'] = false;
		
		
		if(empty($post))
		{
			/**
			 *	když nebyl formulář odeslán, tak se do formulář nastaví na prázdný
			 */			 			
			$formular = true;
			$zobraz['login'] = '';
			$zobraz['heslo'] = '';
			$zobraz['jmeno'] = '';
			$zobraz['prijmeni'] = '';
			$zobraz['vybrano'] =  'nic';
		}
		else
		{
			$formular = false;

			$zobraz['login'] = $post['login'];
			$zobraz['heslo'] = $post['heslo'];
			$zobraz['jmeno'] = $post['jmeno'];
			$zobraz['prijmeni'] = $post['prijmeni'];
			$zobraz['vybrano'] =  $post['typ'];
			
			
			if ($post['login'] == '') //pokud je login prázdný zobrazí chybu
			{
				$zobraz['loginchyba'] = true;
				$formular = true;
			}
			else
			{
				/**
				 * testování zda uživatel již nenexistuje...
				 */
				
				$sql = "SELECT login FROM uzivatel WHERE login = '$zobraz[login]'";

				$result = $db->query($sql)->fetch();
				if($result)
				{
					$formular = true;
					$zobraz['loginchybaexistuje'] = true;
				}
				else
				{
					$input['login'] = $post['login'];
				}			
			}
			
			
			if ($post['heslo'] == '') //pokud je heslo prázdný zobrazí chybu
			{
				$zobraz['heslochyba'] = true;
				$formular = true;
			}
			else
			{
				$input['heslo'] = $post['heslo'];
			}
			
			if($post['typ'] == 'nic')
			{
				$zobraz['typchyba'] = true;
			}
			else
			{
				$input['typ'] = $post['typ'];
			}
			
			if($post['jmeno'] == '')
			{
				$zobraz['jmenochyba'] = true;
			}
			else
			{
				$input['jmeno'] = $post['jmeno'];
			}

			if($post['prijmeni'] == '')
			{
				$zobraz['prijmenichyba'] = true;
			}
			else
			{
				$input['prijmeni'] = $post['prijmeni'];
			}
			
		}
		
		if ($formular)
		{
			$zobraz['prava'] = array( 'nic' => '---', 'admin' => 'Admin', 'ucitel' => 'Učitel', 'student' => 'Student');
			$sl->zobraz($zobraz, 'uzivatele-formular.tpl');
		}
		else
		{
			try
			{
				$db->begintransaction(); //začátek transakce
				
				$sql = $sl->ArrayToSql($input, 'uzivatel');


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
			
			
			
			header('location: ./?modul=uzivatele&metoda=zobraz');
		}
		
		//var_dump($session);
	}
	/**
	* vymaže uživatele
	*
	* @param object $sl main
	* @return void
	*
	*/
	public function vymaz($sl)
	{
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		$get		= $sl->getGet();
		
		if (isset($get['uzivatel']))
		{
			$id = $get['uzivatel'];
		
			try
			{
				$db->begintransaction(); //začátek transakce

				$sql = "DELETE FROM uzivatel WHERE ID_uzivatel = '$id'";

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
		
		header('location: ./?modul=uzivatele&metoda=zobraz');

	}

}

?>
