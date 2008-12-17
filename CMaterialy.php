<?php
class CMaterialy
{
   //definice atriut�
   private $cesta;
   //------------------------

//za��tek metody __construct
   public function __construct($cesta)  //metoda kter� definuje atributy
   {
      //ulo�en� hodnoty p�edan� metodou do atributu
      $this->cesta = $cesta; //cesta ke slo�ce s materi�lama
      //------------------------
   }
//konec metody __construct

//za��tek metody pridat kter� p�id�v� studijn� materi�ly
   public function pridat()
   {

   //p�eps�n� prom. pro uleh�en� pr�ce
   $soubor_name = ($_FILES["soubor"]["name"]);
   $soubor = ($_FILES["soubor"]["tmp_name"]);
   $ok = ($_POST["ok"]);
   //------------------------

    //ov��en� zda byl odesl�n soubor
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

      //vr�cen� hodnoty - true �i false - zda se operace povedla nebo ne
      return $stav;
      //------------------------
   }
//konec metody pridat kter� p�id�v� studijn� materi�ly

//za��tek metody odesli kter� p�id�v� studijn� materi�ly
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
//konec metody odesli kter� p�id�v� studijn� materi�ly

}
?>