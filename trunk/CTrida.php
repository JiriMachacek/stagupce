<?php
class CTrida
{
   //definice atriutù
   private $ID_trida;
   //------------------------

//zaèátek metody __construct
   public function __construct($ID_trida)  //metoda která definuje atributy
   {
      //uloení hodnoty pøedané metodou do atributu
      $this->$ID_trida = $ID_trida;
      //------------------------
   }
//konec metody __konstruct

//zaèátek metody vypsat
   public function vypsat() //metoda která upravuje tøídy
   {
      //naètení hodnot z databáze
      $sql_uprava = "SELECT * FROM `trida` WHERE `ID_trida`='$this->$ID_trida'";
      $sql_query_uprava = mysql_query($sql_uprava) or die (mysql_error());
      $data_uprava = mysql_fetch_array($sql_uprava);
      //------------------------

      //vypsání naètenıch hodnot
      echo "
      ID tøídy: ".$this->$ID_trida."
      Název: ".$data_uprava['nazev']."
      Kapacita: ".$data_uprava['kapacita']."
      </form>
      ";
      //------------------------
   }
//konec metody vypsat

//zaèátek metody nastavení
   public function nastaveni() //metoda která upravuje tøídy
   {
      //naètení hodnot z databáze
      $sql_uprava = "SELECT * FROM `trida` WHERE `ID_trida`='$this->$ID_trida'";
      $sql_query_uprava = mysql_query($sql_uprava) or die (mysql_error());
      $data_uprava = mysql_fetch_array($sql_uprava);
      //------------------------

      //formuláøe pro úpravu tøíd
      echo "
      <form action=\"/OOP/semestralka/nastaveni-trida\" name=\"uprava_css\" method=\"post\" enctype=\"multipart/form-data\">
      <input type=\"hidden\" name=\"ID_trida\" value=\"".$this->$ID_trida."\" />
      Název: <input type=\"text\" name=\"odkazy_barva\" value=\"".$data_uprava['nazev']."\" size=\"20\" class=\"formular\" />
      Kapacita: <input type=\"text\" name=\"odkazy_barva\" value=\"".$data_uprava['kapacita']."\" size=\"20\" class=\"formular\" />
      </form>
      ";
      //------------------------
   }
//konec metody nastavení

//zaèátek metody nastavit
   public function nastavit($nazev,$kapacita) //metoda která upravuje tøídy
   {
       //SQL dotaz pro zmìnu hodnot v databázi
       $Vypis  = mysql_query("UPDATE trida SET
          nazev='$nazev',
          kapacita='$kapacita',
       WHERE ID_trida='$this->$ID_trida'");
       //------------------------

       //kontrola zda nenastala chyba
       if(!$Vypis)
          {
          echo mysql_error(); //v pøípadì e nastane chyba v pøipojení k mysql, hodí to chybovou hlášku
          }
       //------------------------
   }
//konec metody nastavit
}
?>