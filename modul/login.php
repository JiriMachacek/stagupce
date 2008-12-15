<?php
class login
{
	public function __construct()
	{
	}
	
	public function zobraz($sl)
	{
		$session	= $sl->getSession();
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		
		if(empty($post))
		{
			$formular = true;
		}
		else
		{
			$formular = false;
			
			$login = $post['login'];
			$heslo = $post['heslo'];
			
			$sql = "SELECT ID_uzivatel, typ, jmeno, prijmeni FROM uzivatel WHERE login = '$login' AND heslo = '$heslo'";
			$vysledek = $db->query($sql)->fetch(PDO::FETCH_ASSOC);

			if ($vysledek)
			{
				$sl->setSession($vysledek);
			}
			else
			{
				$zobraz['chyba'] = true; 
				$formular = true;
			}
		}
		
		if ($formular)
		{
			$sl->zobraz($zobraz, 'login.tpl');
		}
		else
		{
			header('location: var_dump.php');
		}
		
		
		//var_dump($session);
	}
	
	public function uprav($sl)
	{
		return 1;
	}
	
	public function vloz($sl)
	{
		return 1;
	}
	
	public function vymaz($sl)
	{
		return 1;
	}

}

?>