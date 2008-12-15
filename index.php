<?php
session_start();
include_once ('main.php');
if (isset($_POST))
	$post = $_POST;
else
	$post = '';

$main = new main($_SESSION, $post);

if (!isset($_SESSION['ID_user']))
{
	$modul = 'login';
	$metoda = 'zobraz';
}
else
{
	/*
	 * pouћije se zde stшнda Cseo + CAuth
	 */
	$modul = 'test';
}



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