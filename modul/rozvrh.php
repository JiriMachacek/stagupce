<?php
class rozvrh
{
	/**
	 * název třídy musí být stejný jako název 
	 *
	 */
	public function __construct()
	{
	}
	
	public function zobraz($sl)
	{
		$session	= $sl->getSession(); // zde je vytáhne obsah proměnné $_SESSION
		$post		= $sl->getPost(); // zde je vytáhne obsah proměnné $_POST
		$db			= $sl->getDb(); // // zde je vytáhne databázový objekt PDO
		
		$sql = "SELECT	u.nazev AS ucebna,
						p.nazev AS predmet,
						h.zacatek,
						h.konec,
						h.den,
						h.tyden
						
				FROM	hodina_student hs
				JOIN hodina h ON h.ID_hodina = hs.ID_hodina
				JOIN predmet p ON h.ID_predmet = p.ID_predmet
				JOIN ucebna u ON u.ID_ucebna = h.ID_ucebna
				WHERE hs.ID_uzivatel_student = '$session[ID_uzivatel]'
				";
		

		
		$zobraz['rozvrh'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC); // do proměnné result vytáhne všechny řádky DB ve formátu:

		$sl->zobraz($zobraz, 'rozvrh.tpl'); // preda sablone hodnoty pole zobraz a zobrazi je v sablone ucebny.tpl
		
		
		
	}
	
	
	public function uprav($sl)
	{
		return 1;
	}
	
	public function vloz($sl)
	{
		return 1;
	}
	
	public function vymaz($sl)
	{
		return 1;
	}

}

?>
	