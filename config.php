<?php
define('cestaMaterialy', './soubory/');

/**
 *@param bool smartyDebug nastavuje debugování smarty šablo
 */

if ($_SERVER['SERVER_ADDR'] == '127.0.0.1')
{
	define ('SQL_host', 'localhost');
	define ('SQL_username', 'root');
	define ('SQL_password', '');
	define ('SQL_dbname', 'stagupce');

	define('smartyDebug', true);

}
else
{
	define ('SQL_host', 'localhost');
	define ('SQL_username', 'wearewe1_stag');
	define ('SQL_password', '~$G,VY5k3UAs');
	define ('SQL_dbname', 'wearewe1_stag');

	define('smartyDebug', false);

}

?>