<?php
class uzivatele
{
	public function __construct()
	{
	}
	
	public function zobraz($sl)
	{
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		$sql = "SELECT	jmeno, prijmeni, typ
				FROM 	uzivatel";
		
		$zobraz['uzivatele'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
		$sl->zobraz($zobraz, 'uzivatele.tpl');

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
			
			$zobraz['login'] = $post['login'];
			
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
				
				$sql = "SELECT login FROM ucebna_typ WHERE login = '$zobraz[login]'";
				
				$result = $db->query($sql)->fetch();
				if($result)
				{
					$formular = true;
					$zobraz['typchybaexistuje'] = true;
				}
				else
				{
					$input['loign'] = $post['login'];
				}
					
			}
			
		}
		
		if ($formular)
		{
			$zobraz['prava'] = array(
                                admin => 'Admin',
                                ucitel => 'ucitel',
                                zak => 'zak');
  			$zobraz['typ'] =  'zak';
			
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
			
			
			
			header('location: ./?modul=ucebnytypy&metoda=zobraz');
		}
		
		//var_dump($session);
	}
	
	public function vymaz($sl)
	{
		return 1;
	}

}

?>
