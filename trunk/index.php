<?php
session_start();
include_once ('main.php');
include_once ('config.php');

if (isset($_POST))
	$post = $_POST;
else
	$post = '';


if (isset($_GET))
	$get = $_GET;
else
	$get = '';
	
	
$main = new main($_SESSION, $post);

if (!isset($_SESSION['ID_uzivatel']))
{
	$modul = 'login';
	$metoda = 'zobraz';
	$nazev = 'Login';
}
else if (isset($get['odhlaseni']))
{
	session_unset();
	header('location: ./');
}
else
{
	/*
	 * @todo použije se zde střída Cseo + CAuth
	 */
	if (isset($get['modul']))
	{

		$modul = $get['modul'];
		$metoda = $get['metoda'];
		$nazev = 'Baf';
		
			if(!$main->modulPovolit($modul,$metoda))
			{
			
		    $modul = 'novinky';
		    $metoda = 'zobraz';
		    $nazev = 'Novinky';  
            
      }
	}
	else 
	{
		$modul = 'novinky';
		$metoda = 'zobraz';
		$nazev = 'Novinky';

	}
}

$main->setNazev($nazev);



include_once('./modul/'.$modul.'.php');

$stranka = new $modul();

if (!isset($metoda))
	$metoda = 'zobraz';

else if ($metoda == 'zobraz')
	$stranka->zobraz($main);
else if ($metoda == 'uprav')
	$stranka->uprav($main);
else if ($metoda == 'vloz')
	$stranka->vloz($main);
else if ($metoda == 'vymaz')
	$stranka->vymaz($main);

$_SESSION = $main->getSession();

var_dump($_SESSION);
?>