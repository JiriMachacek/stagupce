<?php

/**
 * Zobrazuje informace o přihlášeném uživateli
 * @version 1.1
 * @final
 */
class uzivatelinfo
{
   //definice atriutů
   //private $ID_uzivatel;
   //------------------------

//začátek metody __construct
   public function __construct()  //metoda která definuje atributy
   {
   }
//konec metody __konstruct
	/**
	 * nepoužívá se, "aplikační jádro" vyžaduje
	 *
	 * @param object $sl main
	 * @return bool true
	 */	
	public function uprav($sl)
	{
		return 1;
	}
	/**
	* nepoužívá se, "aplikační jádro" vyžaduje
	*
	* @param object $sl main
	* @return bool true
	*/	
	public function vloz($sl)
	{
		return 1;
	}
	
	/**
	 * Zobrazuje informacve o přihlášeném uživateli
	 *
	 * @param object $sl main
	 * @return void
	 *
	 */
	public function zobraz($sl)
	{
		$session	= $sl->getSession(); // zde je vytáhne obsah proměnné $_SESSION
		$post		= $sl->getPost(); // zde je vytáhne obsah proměnné $_POST
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		
		$id = $session['ID_uzivatel'];
		
		$sql = "SELECT	typ,
						concat(jmeno, ' ',prijmeni) AS jmeno,
						login
				FROM	uzivatel
				WHERE	ID_uzivatel = '$id'
				";

		$zobraz = $db->query($sql)->fetch(PDO::FETCH_ASSOC); // do proměnné result vytáhne všechny řádky DB ve formátu: 
		
		$sl->zobraz($zobraz, 'uzivatelinfo.tpl'); // preda sablone hodnoty pole zobraz a zobrazi je v sablone ucebny.tpl
	}
	/**
	 * nepoužívá se, "aplikační jádro" vyžaduje
	 *
	 * @param object $sl main
	 * @return bool true
	 */		
	public function vymaz($sl)
	{
		return 1;
	}
}
?>
