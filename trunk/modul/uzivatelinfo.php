<?php

/**
 * Zobrazuje informace o pøihlášeném uživateli
 * @version 1.1
 * @final
 */
class uzivatelinfo
{
   //definice atriutù
   //private $ID_uzivatel;
   //------------------------

//zaèátek metody __construct
   public function __construct()  //metoda která definuje atributy
   {
   }
//konec metody __konstruct
	/**
	 * nepoužívá se, "aplikaèní jádro" vyžaduje
	 *
	 * @param object $sl main
	 * @return bool true
	 */	
	public function uprav($sl)
	{
		return 1;
	}
	/**
	* nepoužívá se, "aplikaèní jádro" vyžaduje
	*
	* @param object $sl main
	* @return bool true
	*/	
	public function vloz($sl)
	{
		return 1;
	}
	
	/**
	 * Zobrazuje informacve o pøihlášeném uživateli
	 *
	 * @param object $sl main
	 * @return void
	 *
	 */
	public function zobraz($sl)
	{
		$session	= $sl->getSession(); // zde je vytáhne obsah promìnné $_SESSION
		$post		= $sl->getPost(); // zde je vytáhne obsah promìnné $_POST
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		
		$id = $session['ID_uzivatel'];
		
		$sql = "SELECT	typ,
						concat(jmeno, ' ',prijmeni) AS jmeno,
						login
				FROM	uzivatel
				WHERE	ID_uzivatel = '$id'
				";

		$zobraz = $db->query($sql)->fetch(PDO::FETCH_ASSOC); // do promìnné result vytáhne všechny øádky DB ve formátu: 
		
		$sl->zobraz($zobraz, 'uzivatelinfo.tpl'); // preda sablone hodnoty pole zobraz a zobrazi je v sablone ucebny.tpl
	}
	/**
	 * nepoužívá se, "aplikaèní jádro" vyžaduje
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
