<?php
class uzivatelinfo
{
   //definice atriut�
   //private $ID_uzivatel;
   //------------------------

//za��tek metody __construct
   public function __construct()  //metoda kter� definuje atributy
   {
   }
//konec metody __konstruct
	public function uprav($sl)
	{
		return 1;
	}
	
	public function vloz($sl)
	{
		return 1;
	}
	
	public function zobraz($sl)
	{
		$session	= $sl->getSession(); // zde je vyt�hne obsah prom�nn� $_SESSION
		$post		= $sl->getPost(); // zde je vyt�hne obsah prom�nn� $_POST
		$db			= $sl->getDb(); // // zde je vyt�hne datab�zov� objekt PDO
		
		$id = $session['ID_uzivatel'];
		
		$sql = "SELECT	typ,
						concat(jmeno, ' ',prijmeni) AS jmeno,
						login
				FROM	uzivatel
				WHERE	ID_uzivatel = '$id'
				";

		$zobraz = $db->query($sql)->fetch(PDO::FETCH_ASSOC); // do prom�nn� result vyt�hne v�echny ��dky DB ve form�tu: 
		
		$sl->zobraz($zobraz, 'uzivatelinfo.tpl'); // preda sablone hodnoty pole zobraz a zobrazi je v sablone ucebny.tpl
	}
	
	public function vymaz($sl)
	{
		return 1;
	}
}
?>
