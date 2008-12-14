<?php
class CAuth
{
   //definice atriut�
   private $ID_uzivatel;
   //------------------------

//za��tek metody __construct
   public function __construct($ID_uzivatel)  //metoda kter� definuje atributy
   {
      //ulo�en� hodnoty p�edan� metodou do atributu
      $this->ID_uzivatel = $ID_uzivatel;
      //------------------------
   }
//konec metody __konstruct

//za��tek metody modulPovolit kter� ov��uje orp�vn�n� u�ivatele pro vol�n� modulu
   public function modulPovolit($seo) //metoda kter� upravuje t��dy
   {
      //nastaven� po��te�n� hodnoty na false - v tomto p��pad� se n�m modul nezobraz� a nemus�me ke ka�d� podm�nce definovat metodu else
      $Povolit=false;
      //------------------------

      //na�ten� hodnot z datab�ze o p�ihl�en�m u�ivateli
      $sqlUzivatel = "SELECT role FROM `uzivatele` WHERE `ID_uzivatel`='$this->$ID_uzivatel'";
      $dataUzivatel = $pdo->query($sqlUzivatel)->fetch();
      //------------------------

      //na�ten� hodnot z datab�ze o po�adovan�m modulu
      $sqlModul = "SELECT role FROM `page` WHERE `seo`='$seo'";
      $dataModul = $pdo->query($sqlUzivatel)->fetch();
      //------------------------

      //switch kter� porovn�v� typ u�ivatel� povolen�ch pro na�ten� modulu
      switch($dataUzivatel["role"])
      {
        //v p��pad� �e se jedn� o admina, automaticky povol�me
        case "admin":
          $Povolit=true;
        break;
        //------------------------

        // v p��pad� �e se jedn� o u�itele zjist�me jestli je pro n�j modul ur�en, nebo jestli je ur�en pro v�echny
        case "ucitel":
          if($data["role"]="ucitel" && $data["role"]="vsichni")
            {
              $Povolit=true;
            }
        break;
        //------------------------

        // v p��pad� �e se jedn� o ��ka zjist�me jestli je pro n�j modul ur�en, nebo jestli je ur�en pro v�echny
        case "zak":
          if($data["role"]="zak" && $data["role"]="vsichni")
            {
              $Povolit=true;
            }
        break;
        //------------------------
      }
      //konec switche------------------------

      //vr�cen� hodnoty - true �i false - zda se m� u�ivateli zobrazit modul
      return $Povolit;
      //------------------------
   }
//konec metody modulPovolit kter� ov��uje orp�vn�n� u�ivatele pro vol�n� modulu

}
?>