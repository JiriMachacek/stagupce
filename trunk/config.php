<?php
define('cestaMaterialy', './soubory/');

if ($_SERVER['SERVER_ADDR'] == '127.0.0.1')
{
	define ('SQL_host', 'localhost');
	define ('SQL_username', 'root');
	define ('SQL_password', '');
	define ('SQL_dbname', 'stagupce');
}
else
{
	define ('SQL_host', 'localhost');
	define ('SQL_username', '');
	define ('SQL_password', '');
	define ('SQL_dbname', '');
}

?>