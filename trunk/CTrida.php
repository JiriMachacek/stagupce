<?php
class CTrida
{
   //definice atriut�
   private $ID_trida;
   //------------------------

//za��tek metody __construct
   public function __construct($ID_trida)  //metoda kter� definuje atributy
   {
      //ulo�en� hodnoty p�edan� metodou do atributu
      $this->$ID_trida = $ID_trida;
      //------------------------
   }
//konec metody __konstruct

//za��tek metody vypsat
   public function vypsat() //metoda kter� upravuje t��dy
   {
      //na�ten� hodnot z datab�ze
      $sql_uprava = "SELECT * FROM `trida` WHERE `ID_trida`='$this->$ID_trida'";
      $sql_query_uprava = mysql_query($sql_uprava) or die (mysql_error());
      $data_uprava = mysql_fetch_array($sql_uprava);
      //------------------------

      //vyps�n� na�ten�ch hodnot
      echo "
      ID t��dy: ".$this->$ID_trida."
      N�zev: ".$data_uprava['nazev']."
      Kapacita: ".$data_uprava['kapacita']."
      </form>
      ";
      //------------------------
   }
//konec metody vypsat

//za��tek metody nastaven�
   public function nastaveni() //metoda kter� upravuje t��dy
   {
      //na�ten� hodnot z datab�ze
      $sql_uprava = "SELECT * FROM `trida` WHERE `ID_trida`='$this->$ID_trida'";
      $sql_query_uprava = mysql_query($sql_uprava) or die (mysql_error());
      $data_uprava = mysql_fetch_array($sql_uprava);
      //------------------------

      //formul��e pro �pravu t��d
      echo "
      <form action=\"/OOP/semestralka/nastaveni-trida\" name=\"uprava_css\" method=\"post\" enctype=\"multipart/form-data\">
      <input type=\"hidden\" name=\"ID_trida\" value=\"".$this->$ID_trida."\" />
      N�zev: <input type=\"text\" name=\"odkazy_barva\" value=\"".$data_uprava['nazev']."\" size=\"20\" class=\"formular\" />
      Kapacita: <input type=\"text\" name=\"odkazy_barva\" value=\"".$data_uprava['kapacita']."\" size=\"20\" class=\"formular\" />
      </form>
      ";
      //------------------------
   }
//konec metody nastaven�

//za��tek metody nastavit
   public function nastavit($nazev,$kapacita) //metoda kter� upravuje t��dy
   {
       //SQL dotaz pro zm�nu hodnot v datab�zi
       $Vypis  = mysql_query("UPDATE trida SET
          nazev='$nazev',
          kapacita='$kapacita',
       WHERE ID_trida='$this->$ID_trida'");
       //------------------------

       //kontrola zda nenastala chyba
       if(!$Vypis)
          {
          echo mysql_error(); //v p��pad� �e nastane chyba v p�ipojen� k mysql, hod� to chybovou hl�ku
          }
       //------------------------
   }
//konec metody nastavit
}
?>