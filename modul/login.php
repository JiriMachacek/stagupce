<?php

/**
 * t��da login slou�� k p�ihla�ov�n� u�ivatel�
 * @version 1.0
 */
class login
{
	public function __construct()
	{
	}
	
	/**
	 * zobrazn� p�ila�ovac� formul��
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
	
		$zobraz['chyba'] = false;
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
			header('location: ./');
		}
		
		
		//var_dump($session);
	}

	/**
	 * nepou��v� se, "aplika�n� j�dro" vy�aduje
	 *
	 * @param object $sl main
	 * @return bool true
	 */
	public function uprav($sl)
	{
		return 1;
	}

	/**
	 * nepou��v� se, "aplika�n� j�dro" vy�aduje
	 *
	 * @param object $sl main
	 * @return bool true
	 */
	public function vloz($sl)
	{
		return 1;
	}

	/**
	 * nepou��v� se, "aplika�n� j�dro" vy�aduje
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
