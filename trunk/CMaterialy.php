<?php
class CMaterialy
{
   //definice atriutù
   private $cesta;
   //------------------------

//zaèátek metody __construct
   public function __construct($cesta)  //metoda která definuje atributy
   {
      //uložení hodnoty pøedané metodou do atributu
      $this->cesta = $cesta; //cesta ke složce s materiálama
      //------------------------
   }
//konec metody __construct

//zaèátek metody pridat která pøidává studijní materiály
   public function pridat()
   {

   //pøepsání prom. pro ulehèení práce
   $soubor_name = ($_FILES["soubor"]["name"]);
   $soubor = ($_FILES["soubor"]["tmp_name"]);
   $ok = ($_POST["ok"]);
   //------------------------

    //ovìøení zda byl odeslán soubor
    if ($soubor_name!="")
    {
      if (move_uploaded_file($soubor, $this->cesta.$soubor_name))
        {
        chmod ($this->cesta.$soubor_name, 0646);
        echo "<b>Soubor $soubor_name byl nahran na server</b><BR>";
        $stav=true;
        }
      else
        {
        echo "<b>Chyba - soubor nebyl nahran</b><BR>";
        $stav=false;
        }
    }
    //------------------------

      //vrácení hodnoty - true èi false - zda se operace povedla nebo ne
      return $stav;
      //------------------------
   }
//konec metody pridat která pøidává studijní materiály

//zaèátek metody odesli která pøidává studijní materiály
   public function odesli($ID_predmet,$ID_uzivatel)
   {
    echo "
   <FORM ACTION=\"upload.php\" METHOD=\"post\" ENCTYPE=\"multipart/form-data\">
   <INPUT TYPE=\"file\" NAME=\"soubor\" SIZE=\"40\">
   <INPUT TYPE=\"submit\" NAME=\"ok\" VALUE=\"Upload\">
   <input type=\"hidden\" name=\"ID_predmet\" value=\"$ID_predmet\" />
   <input type=\"hidden\" name=\"ID_uzivatel\" value=\"$ID_uzivatel\" />
   </FORM> ";

   }
//konec metody odesli která pøidává studijní materiály

}
?>