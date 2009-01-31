<?php
/**
 * Project:     Stag Upce
 * File:        index.php
 *
 * Školní projekt z předmětu OOP
 *
 * @link http://stag.hypnoticart.net/
 * @link http://code.google.com/p/stagupce/
 * @link http://code.google.com/p/stagupce/wiki/Uzivatelska_dokumentace
 * @copyright 2008-2009 Kolektiv autorů
 * @author Jiří Macháček
 * @author Lukáš Janda
 * @author Martin Kocourek
 * @author Vojtěch Vlkovský
 * @package stagupce
 * @version 0.9
 */

session_start();
/**
 * načte soubor s třídou main a configurační soubor
 */
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
	

$main = new main($_SESSION, $post, $get);
 
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
	 * zjišťuje se zda uživatel má právo používat daný modul
	 */
	if (isset($get['modul']))
	{

		$modul = $get['modul'];
		$metoda = $get['metoda'];
		$nazev = 'beta tests';
		
			if($main->modulPovolit($modul,$metoda)!=1)
			{
			
		    $modul = 'uzivatelinfo';
		    $metoda = 'zobraz';
		    $nazev = 'úvod';  
            
      }

	}
	else 
	{
		$modul = 'uzivatelinfo';
		$metoda = 'zobraz';
		$nazev = 'úvod';

	}
}

$main->setNazev($nazev);


/**
 * načtení souboru s modulem
 */
include_once('./modul/'.$modul.'.php');

$stranka = new $modul();

if (!isset($metoda))
	$metoda = 'zobraz';

else if ($metoda == 'zobraz')
  {
	  if($main->modulPovolit($modul,$metoda)==1)
	  {
    $stranka->zobraz($main);
    }
    else
    {
    echo "Pro přístup k tomuto modulu nemáte oprávnění.";
    }	
  }
else if ($metoda == 'uprav')
  {
	  if($main->modulPovolit($modul,$metoda)==1)
	  {
	    $stranka->uprav($main);
    }
    else
    {
      echo "Pro přístup k tomuto modulu nemáte oprávnění.";
    }	
  }
else if ($metoda == 'vloz')
  {
	  if($main->modulPovolit($modul,$metoda)==1)
	  {
	    $stranka->vloz($main);
    }
    else
    {
      echo "Pro přístup k tomuto modulu nemáte oprávnění.";
    }	
  }
else if ($metoda == 'vymaz')
  {
	  if($main->modulPovolit($modul,$metoda)==1)
	  {
	    $stranka->vymaz($main);
    }
    else
    {
      echo "Pro přístup k tomuto modulu nemáte oprávnění.";
    }	
  }

$_SESSION = $main->getSession();

//var_dump($_SESSION);
?>