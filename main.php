<?php
/**
 * připojuje soubor se smarty třídou
 */
require ('smarty/Smarty.class.php');

/**
 * hlavní třída, která zajišťuje komunikaci všeho se vším
 */
class main
{


	/**
	 * @var object $smarty smarty objekt
	 */
	private $smarty;
	/**
	 * @var object $pdo PDO objekt obsluhuje databázi
	 */
	private $pdo;
	/**
	 * @var array $session pole předávané přez $_SESSION
	 */
	private $session;
	/**
	 * @var array $post pole předáváné přez $_POST ve formulářích
	 */
	private $post;
	/**
	 * @var string $nazev název zobrazený v title stránky
	 */
	private $nazev;
	/**
	 * @var string $modul název použitého modulu
	 */
	private $modul;
	/**
	 * @var array $get pole předáváné přez $_GET - parametry stránky
	 */
	private $get;
	
    
	/**
	 * @param array $session globální proměnná $_SESSION
	 * @param array $post globální proměnná $_POST
	 * @param array $get globální proměnná $_GET
	 * 
	 * @return void
	 */
	
	public function __construct($session, $post, $get)
    {
        $this->startSmarty();
        $this->startDb();
        
        $this->setSession($session);
        $this->post = $post;
        
        $this->setGet($get);

    }
	/**
	 * inicializuje smarty objekt do proměnné $this->smarty
	 * @param void
	 * @return void 
	 */			
	private function startSmarty()
	{
 		 		
		$this->smarty = new Smarty;
		$this->smarty->compile_check = true;
		$this->smarty->debugging = smartyDebug;
	}
	
	/**
	 * připojí se k db
	 * @param void
	 * @return void
	 */
	private function startDb()
	{
		$this->pdo = new PDO('mysql:host='.SQL_host.';dbname='.SQL_dbname, SQL_username, SQL_password);
		$this->pdo->query("SET CHARACTER SET utf8");
	}
		
	
	/**
	 * převede pole na sql dotaz
	 *
	 * @param array $value klíč = název sloupce, hodnota = hodnota
	 * @param string $table název tabulky do které se mají vložit hodnoty pole
	 * @return string sql dotaz
	 *
	 */
	public function ArrayToSql($value, $table)
	{
		$keys = implode(",",array_keys($value));
		$hodnoty = "'".implode("','",array_values($value))."'";
		$sql = "INSERT INTO $table (".$keys.") VALUES (".$hodnoty.")";
	
		return $sql;
	}
	
	
	/**
	 * Zobrazí stránku
	 *
	 * @param array $promenne klíč = název smarty proměnné, hodnota = hodnota
	 * @param string $sablona název šablony, která se má použít pro zobrazení stránky
	 * @return void zobrazní stránku
	 *
	 */
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
	
	
	/**
	 * vrátí pole session
	 *
	 * @return array pole session
	 *
	 */
	public function getSession ()
	{
		return $this->session;
	}
	
	
	/**
	 * Uloží hodnoty do proměnné session
	 *
	 * @param array $value hodnota $_SESSION
	 * @return void 
	 *
	 */
	public function setSession ($value)
	{
		$this->session = $value;
	}
	
	
	/**
	 * vrátí pole post
	 *
	 * @return array pole Post
	 *
	 */
	public function getPost()
	{
		return $this->post;
	}

	
	/**
	 * Vrátí databázový objekt
	 *
	 * @return object PDO objekt
	 *
	 */
	public function getDb()
	{
		return $this->pdo;
	}
	
	
	/**
	 * Nataví název stránky
	 *
	 * @param string $value název stránky
	 * @return void 
	 *
	 */
	public function setNazev($value)
	{
		$this->nazev = $value;
	}
	
	  
	/**
	 * Vráti prarametry Get
	 *
	 * @return array Vrátí pole s parametry Get
	 *
	 */
	public function getGet ()
	{
		return $this->get;
	}

	
	/**
	 * Nataví proměnou get
	 *
	 * @param array $value hodnota proměnné get
	 * @return void
	 *
	 */
	private function setGet ($value)
	{
		$this->get = $value;
	}
	
  

   
	/**
	 * Ověruje oprávnění uživatele pro volání modulu
	 *
	 * @param string $modul nazev modulu
	 * @param string $metoda vloz, uprav, smaz, zobraz
	 * @return bool true - povolí, false nepovolí
	 *
	 */
	public function modulPovolit($modul,$metoda)
   {
      if(IsSet($this->session['ID_uzivatel']))
      {
      $ID_uzivatel=$this->session['ID_uzivatel'];
      }
      else
      {
      $ID_uzivatel=0;
      }
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
      
      $this->smarty->assign('private_uzivatel_typ' , $dataUzivatel["typ"]); //posílá typ uživatele do šablony
      
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
        
        default:
          if($dataModul["prava"]="vsichni")
            {
              $Povolit=true;
            }
        break;        
      }
      //konec switche------------------------

      //vrácení hodnoty - true či false - zda se má uživateli zobrazit modul
      return $Povolit;
      //------------------------
   }
//konec metody modulPovolit která ověřuje orpávnění uživatele pro volání modulu
}

?>
