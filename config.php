<?php
/**
 * adresář do kterého se budou ukládat studujní materiály
 */
define('cestaMaterialy', './soubory/');

/**
 * testuje se zda projekt se testuje na localhoste
 */
if ($_SERVER['SERVER_ADDR'] == '127.0.0.1')
{
	/**
	* adresa DB serveru
	*/
	define ('SQL_host', 'localhost');
	/**
	* uživatelské jméno uživatele DB
	*/
	define ('SQL_username', 'root');
	/**
	* heslo k DB serveru
	*/
	define ('SQL_password', '');
	/**
	 * název DB
	 */
	define ('SQL_dbname', 'stagupce');
	/**
	* nastavuje debugování smarty šablony
	*/
	define('smartyDebug', true);

}
else
{
	/**
	* adresa DB serveru
	*/
	define ('SQL_host', 'localhost');
	/**
	* uživatelské jméno uživatele DB
	*/
	define ('SQL_username', 'wearewe1_stag');
	/**
	* heslo k DB serveru
	*/
	define ('SQL_password', '~$G,VY5k3UAs');
	/**
	 * název DB
	 */
	define ('SQL_dbname', 'wearewe1_stag');
	/**
	* nastavuje debugování smarty šablony
	*/
	define('smartyDebug', false);

}

?>