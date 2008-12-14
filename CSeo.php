<?php
class CSeo
{
   //definice atriutщ
   private $seo;
   //------------------------

//zaибtek metody __construct
   public function __construct($seo)  //metoda kterб definuje atributy
   {
      //uloћenн hodnoty pшedanй metodou do atributu
      $this->seo = $seo;
      //------------------------
   }
//konec metody __konstruct

//zaибtek metody rozeberSeo, kterб oddмlн jednotlivй informace o modulu, funkci a nбzvu jednotlivэch zбznamщ
   public function rozeberSeo($seo)
   {

      //rozebrбnн hodnot pшedanй v prom. seo
      $hodnoty = explode("-",$this->seo,3);
      $seo["modul"] = $hodnoty[0];
      $seo["metoda"] = $hodnoty[1];
      $seo["nazev"] = $hodnoty[2];
      //------------------------

      //vrбcenн pole kterй obsahuje rozebranй hodnoty z prom. seo
      return $seo;
      //------------------------
   }
//konec metody rozeberSeo, kterб oddмlн jednotlivй informace o modulu, funkci a nбzvu jednotlivэch zбznamщ

//zaибtek metody slozSeo, kterб sloћн jednotlivй informace o modulu, funkci a nбzvu jednotlivэch zбznamщ
   public function slozSeo($modul,$metoda,$nazev)
   {
      //zavolбnн metody kterб nбm upravн nбzev pro seo
      $nazev = upravProSeo($nazev);
      //------------------------

      //sloћenн hodnot
      $seo = $modul."-".$metoda."-".$nazev;
      //------------------------

      //vrбcenб hodnota obsahuje url adresu optimalizovanou pro seo
      return $seo;
      //------------------------
   }
//konec metody slozSeo, kterб sloћн jednotlivй informace o modulu, funkci a nбzvu jednotlivэch zбznamщ

//zaибtek metody upravProSeo, kterб odstranн diakritiku a upravн vљechna pнsmena na malб a mнsto mezer pouћije -
   private function upravProSeo($prom)
   {
      //odstranмnн velkэch pнsmen vиetnм odstranмnн diakritiky
      $prom = str_replace("A","a",$prom);
      $prom = str_replace("Б","c",$prom);
      $prom = str_replace("B","b",$prom);
      $prom = str_replace("C","c",$prom);
      $prom = str_replace("И","c",$prom);
      $prom = str_replace("D","d",$prom);
      $prom = str_replace("П","d",$prom);
      $prom = str_replace("E","e",$prom);
      $prom = str_replace("Й","e",$prom);
      $prom = str_replace("М","e",$prom);
      $prom = str_replace("F","f",$prom);
      $prom = str_replace("G","g",$prom);
      $prom = str_replace("H","h",$prom);
      $prom = str_replace("CH","ch",$prom);
      $prom = str_replace("Ch","ch",$prom);
      $prom = str_replace("I","i",$prom);
      $prom = str_replace("J","j",$prom);
      $prom = str_replace("K","k",$prom);
      $prom = str_replace("L","l",$prom);
      $prom = str_replace("M","m",$prom);
      $prom = str_replace("N","n",$prom);
      $prom = str_replace("Т","n",$prom);
      $prom = str_replace("O","o",$prom);
      $prom = str_replace("У","o",$prom);
      $prom = str_replace("P","p",$prom);
      $prom = str_replace("Q","q",$prom);
      $prom = str_replace("R","r",$prom);
      $prom = str_replace("Ш","r",$prom);
      $prom = str_replace("S","s",$prom);
      $prom = str_replace("Љ","s",$prom);
      $prom = str_replace("T","t",$prom);
      $prom = str_replace("Ќ","t",$prom);
      $prom = str_replace("U","u",$prom);
      $prom = str_replace("Ъ","u",$prom);
      $prom = str_replace("V","v",$prom);
      $prom = str_replace("W","w",$prom);
      $prom = str_replace("X","x",$prom);
      $prom = str_replace("Y","y",$prom);
      $prom = str_replace("Э","y",$prom);
      $prom = str_replace("Z","z",$prom);
      $prom = str_replace("Ћ","z",$prom);
      //------------------------

      //odstranмnн diakritiky u malэch pнsmen
      $prom = str_replace("б","a",$prom);
      $prom = str_replace("и","c",$prom);
      $prom = str_replace("п","d",$prom);
      $prom = str_replace("й","e",$prom);
      $prom = str_replace("м","e",$prom);
      $prom = str_replace("н","i",$prom);
      $prom = str_replace("т","n",$prom);
      $prom = str_replace("у","o",$prom);
      $prom = str_replace("ш","r",$prom);
      $prom = str_replace("љ","s",$prom);
      $prom = str_replace("ќ","t",$prom);
      $prom = str_replace("ъ","u",$prom);
      $prom = str_replace("щ","u",$prom);
      $prom = str_replace("э","y",$prom);
      $prom = str_replace("ћ","z",$prom);
      //------------------------

      //ostatnн ъpravy
      $prom = str_replace(" ","-",$prom);
      //------------------------

      //vrбcenн upravenйho textu pro seo
      return $prom;
      //------------------------
   }
//zaибtek metody upravProSeo, kterб odstranн diakritiku a upravн vљechna pнsmena na malб a mнsto mezer pouћije -

}
?>