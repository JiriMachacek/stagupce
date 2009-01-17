<?php

require ('smarty/Smarty.class.php');

class main
{
	private $smarty;
	private $pdo;
	private $session;
	private $post;
	private $nazev;
	private $modul;
	private $get;
	
    public function __construct($session, $post, $get)
    {
        $this->startSmarty();
        $this->startDb();
        
        $this->setSession($session);
        $this->post = $post;
        
        $this->setGet($get);

    }
	
	private function startSmarty()
	{
		/**
		 *@access public
		 *@category smarty
		 *
		 *startuje Smarty objekt
		 */		 		 		
		$this->smarty = new Smarty;
		$this->smarty->compile_check = true;
		$this->smarty->debugging = smartyDebug;
	}
	
	private function startDb()
	{
		//připojení k db
	
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
	
  public function getGet ()
	{
		return $this->get;
	}
	private function setGet ($value)
	{
		$this->get = $value;
	}
	
  
//začátek metody modulPovolit která ověřuje orpávnění uživatele pro volání modulu
   public function modulPovolit($modul, $metoda)
   {
   
      //předání ID uživatele ze session
      $ID_uzivatel = $this->session['ID_uzivatel'];
      //------------------------
      
      //nastavení počáteční hodnoty na false - v tomto případě se nám modul nezobrazí a nemusíme ke každé podmínce definovat metodu else
      $Povolit=false;
      //------------------------

      //načtení hodnot z databáze o přihlášeném uživateli
      $sqlUzivatel = "SELECT typ FROM `uzivatel` WHERE `ID_uzivatel`='$ID_uzivatel'";
      $dataUzivatel = $this->pdo->query($sqlUzivatel)->fetch();
      //------------------------

      //načtení hodnot z databáze o požadovaném modulu
      $sqlModul = "SELECT prava FROM `page` WHERE `modul`='$modul' and `typ`='$metoda'";
      $dataModul = $this->pdo->query($sqlUzivatel)->fetch();
      //------------------------

      //switch který porovnává typ uživatelů povolených pro načtení modulu
      switch($dataUzivatel["typ"])
      {
        //v případě že se jedná o admina, automaticky povolíme
        case "admin":
          $Povolit=true;
        break;
        //------------------------

        // v případě že se jedná o učitele zjistíme jestli je pro něj modul určen, nebo jestli je určen pro všechny
        case "ucitel":
          if($dataModul["prava"]="ucitel" && $dataModul["prava"]="vsichni")
            {
              $Povolit=true;
            }
        break;
        //------------------------

        // v případě že se jedná o žáka zjistíme jestli je pro něj modul určen, nebo jestli je určen pro všechny
        case "zak":
          if($dataModul["prava"]="zak" && $dataModul["prava"]="vsichni")
            {
              $Povolit=true;
            }
        break;
        //------------------------
      }
      //konec switche------------------------

      //vrácení hodnoty - true či false - zda se má uživateli zobrazit modul
      return $Povolit;
      //------------------------
   }
//konec metody modulPovolit která ověřuje orpávnění uživatele pro volání modulu
}

?>
