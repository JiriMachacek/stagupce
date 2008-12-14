<?php
class CAuth
{
   //definice atriutù
   private $ID_uzivatel;
   //------------------------

//zaèátek metody __construct
   public function __construct($ID_uzivatel)  //metoda která definuje atributy
   {
      //uložení hodnoty pøedané metodou do atributu
      $this->ID_uzivatel = $ID_uzivatel;
      //------------------------
   }
//konec metody __konstruct

//zaèátek metody modulPovolit která ovìøuje orpávnìní uživatele pro volání modulu
   public function modulPovolit($seo) //metoda která upravuje tøídy
   {
      //nastavení poèáteèní hodnoty na false - v tomto pøípadì se nám modul nezobrazí a nemusíme ke každé podmínce definovat metodu else
      $Povolit=false;
      //------------------------

      //naètení hodnot z databáze o pøihlášeném uživateli
      $sqlUzivatel = "SELECT role FROM `uzivatele` WHERE `ID_uzivatel`='$this->$ID_uzivatel'";
      $dataUzivatel = $pdo->query($sqlUzivatel)->fetch();
      //------------------------

      //naètení hodnot z databáze o požadovaném modulu
      $sqlModul = "SELECT role FROM `page` WHERE `seo`='$seo'";
      $dataModul = $pdo->query($sqlUzivatel)->fetch();
      //------------------------

      //switch který porovnává typ uživatelù povolených pro naètení modulu
      switch($dataUzivatel["role"])
      {
        //v pøípadì že se jedná o admina, automaticky povolíme
        case "admin":
          $Povolit=true;
        break;
        //------------------------

        // v pøípadì že se jedná o uèitele zjistíme jestli je pro nìj modul urèen, nebo jestli je urèen pro všechny
        case "ucitel":
          if($data["role"]="ucitel" && $data["role"]="vsichni")
            {
              $Povolit=true;
            }
        break;
        //------------------------

        // v pøípadì že se jedná o žáka zjistíme jestli je pro nìj modul urèen, nebo jestli je urèen pro všechny
        case "zak":
          if($data["role"]="zak" && $data["role"]="vsichni")
            {
              $Povolit=true;
            }
        break;
        //------------------------
      }
      //konec switche------------------------

      //vrácení hodnoty - true èi false - zda se má uživateli zobrazit modul
      return $Povolit;
      //------------------------
   }
//konec metody modulPovolit která ovìøuje orpávnìní uživatele pro volání modulu

}
?>