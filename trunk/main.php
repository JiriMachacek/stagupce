<?php

require ('smarty/Smarty.class.php');

class main
{
	private $smarty;
	private $pdo;
	private $session;
	private $post;
	private $nazev;
	
	public function __construct($session, $post)
	{
		$this->startSmarty();
		$this->startDb();
		
		$this->setSession($session);
		$this->post = $post;
	}
	
	private function startSmarty()
	{
		//vytvoří a nastaví smarty
		$this->smarty = new Smarty;
		$this->smarty->compile_check = true;
		$this->smarty->debugging = true;
	}
	
	private function startDb()
	{
		//připojení k db
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
		$this->pdo->query("SET CHARACTER SET utf8");
	}
		
	public function ArrayToSql($value, $table)
	{
		$keys = implode(",",array_keys($value));
		$hodnoty = "'".implode("','",array_values($value))."'";
		$sql = "INSERT INTO $table (".$keys.") VALUES (".$hodnoty.")";
	
		return $sql;
	}
	
	
	public function zobraz ($promenne, $sablona)
	{
		//preda promenne smarty
		if (isset($promenne))
			foreach ($promenne as $key => $promena)
			{
				$this->smarty->assign($key, $promena);
			}
		
		$this->smarty->assign('Titlenazev' , $this->nazev);
			
		// zobrazi sablonu
		$this->smarty->display($sablona);
	}
	
	public function getSession ()
	{
		return $this->session;
	}
	
	public function setSession ($value)
	{
		$this->session = $value;
	}
	
	public function getPost()
	{
		return $this->post;
	}

	public function getDb()
	{
		return $this->pdo;
	}
	
	public function setNazev($value)
	{
		/*
		 * @value nastaví název stránky
		 */
		$this->nazev = $value;
	}
}

?>
