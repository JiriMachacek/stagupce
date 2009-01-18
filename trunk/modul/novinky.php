<?php
class novinky
{
	public function __construct()
	{
	}
	
	public function zobraz($sl)
	{
		$session	= $sl->getSession();
		$post		= $sl->getPost();
		$db			= $sl->getDb();
	
		
		$sql = "SELECT	CONCAT(u.jmeno, ' ', u.prijmeni) AS jmeno,
						n.datum,
						n.nazev,
						n.popis
				FROM	novinky n
				JOIN	uzivatel u ON n.ID_uzivatel = u.ID_uzivatel";
		
		$zobraz['novinky'] = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		echo '<pre>';
    print_r($zobraz['novinky']);
    echo '</pre>';
		$sl->zobraz($zobraz, 'novinky.tpl');
		
		
		//var_dump($session);
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
