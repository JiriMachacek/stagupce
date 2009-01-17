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
	

$main = new main($_SESSION, $post, $get);
$ID_uzivatel = $_SESSION['ID_uzivatel'];
 
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
		$nazev = 'beta tests';
		
			if($main->modulPovolit($modul,$metoda,$ID_uzivatel)!=1)
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
  {
	  if($main->modulPovolit($modul,$metoda,$ID_uzivatel)==1)
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
	  if($main->modulPovolit($modul,$metoda,$ID_uzivatel)==1)
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
	  if($main->modulPovolit($modul,$metoda,$ID_uzivatel)==1)
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
	  if($main->modulPovolit($modul,$metoda,$ID_uzivatel)==1)
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