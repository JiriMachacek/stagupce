<?php

require ('smarty/Smarty.class.php');

class main
{
	public $smarty;
	public $pdo;
	
	public function __construct()
	{
		$this->startSmarty();
		$this->startDb();
	}
	
	private function startSmarty()
	{
		//vytvoøí a nastaví smarty
		$this->smarty = new Smarty;
		$this->smarty->compile_check = true;
		$this->smarty->debugging = true;
	}
	
	private function startDb()
	{
		//pøipojení k db
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
		
		$this->pdo = new PDO('mysql:host='.SQL_host.';dbname='.SQL_dbname, SQL_username, SQL_password);
	}
		
	public function zobraz ($promenne, $sablona)
	{
		//preda promenne smarty
		if (isset($promenne))
			foreach ($promenne as $key => $promena)
			{
				$this->smarty->assign($key, $promena);
			}
		// zobrazi sablonu
		$this->smarty->display($sablona);
	
	}

}

?>
