<?php
class CSeo
{
   //definice atriut�
   private $seo;
   //------------------------

//za��tek metody __construct
   public function __construct($seo)  //metoda kter� definuje atributy
   {
      //ulo�en� hodnoty p�edan� metodou do atributu
      $this->seo = $seo;
      //------------------------
   }
//konec metody __konstruct

//za��tek metody rozeberSeo, kter� odd�l� jednotliv� informace o modulu, funkci a n�zvu jednotliv�ch z�znam�
   public function rozeberSeo($seo)
   {

      //rozebr�n� hodnot p�edan� v prom. seo
      $hodnoty = explode("-",$this->seo,3);
      $seo["modul"] = $hodnoty[0];
      $seo["metoda"] = $hodnoty[1];
      $seo["nazev"] = $hodnoty[2];
      //------------------------

      //vr�cen� pole kter� obsahuje rozebran� hodnoty z prom. seo
      return $seo;
      //------------------------
   }
//konec metody rozeberSeo, kter� odd�l� jednotliv� informace o modulu, funkci a n�zvu jednotliv�ch z�znam�

//za��tek metody slozSeo, kter� slo�� jednotliv� informace o modulu, funkci a n�zvu jednotliv�ch z�znam�
   public function slozSeo($modul,$metoda,$nazev)
   {
      //zavol�n� metody kter� n�m uprav� n�zev pro seo
      $nazev = upravProSeo($nazev);
      //------------------------

      //slo�en� hodnot
      $seo = $modul."-".$metoda."-".$nazev;
      //------------------------

      //vr�cen� hodnota obsahuje url adresu optimalizovanou pro seo
      return $seo;
      //------------------------
   }
//konec metody slozSeo, kter� slo�� jednotliv� informace o modulu, funkci a n�zvu jednotliv�ch z�znam�

//za��tek metody upravProSeo, kter� odstran� diakritiku a uprav� v�echna p�smena na mal� a m�sto mezer pou�ije -
   private function upravProSeo($prom)
   {
      //odstran�n� velk�ch p�smen v�etn� odstran�n� diakritiky
      $prom = str_replace("A","a",$prom);
      $prom = str_replace("�","c",$prom);
      $prom = str_replace("B","b",$prom);
      $prom = str_replace("C","c",$prom);
      $prom = str_replace("�","c",$prom);
      $prom = str_replace("D","d",$prom);
      $prom = str_replace("�","d",$prom);
      $prom = str_replace("E","e",$prom);
      $prom = str_replace("�","e",$prom);
      $prom = str_replace("�","e",$prom);
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
      $prom = str_replace("�","n",$prom);
      $prom = str_replace("O","o",$prom);
      $prom = str_replace("�","o",$prom);
      $prom = str_replace("P","p",$prom);
      $prom = str_replace("Q","q",$prom);
      $prom = str_replace("R","r",$prom);
      $prom = str_replace("�","r",$prom);
      $prom = str_replace("S","s",$prom);
      $prom = str_replace("�","s",$prom);
      $prom = str_replace("T","t",$prom);
      $prom = str_replace("�","t",$prom);
      $prom = str_replace("U","u",$prom);
      $prom = str_replace("�","u",$prom);
      $prom = str_replace("V","v",$prom);
      $prom = str_replace("W","w",$prom);
      $prom = str_replace("X","x",$prom);
      $prom = str_replace("Y","y",$prom);
      $prom = str_replace("�","y",$prom);
      $prom = str_replace("Z","z",$prom);
      $prom = str_replace("�","z",$prom);
      //------------------------

      //odstran�n� diakritiky u mal�ch p�smen
      $prom = str_replace("�","a",$prom);
      $prom = str_replace("�","c",$prom);
      $prom = str_replace("�","d",$prom);
      $prom = str_replace("�","e",$prom);
      $prom = str_replace("�","e",$prom);
      $prom = str_replace("�","i",$prom);
      $prom = str_replace("�","n",$prom);
      $prom = str_replace("�","o",$prom);
      $prom = str_replace("�","r",$prom);
      $prom = str_replace("�","s",$prom);
      $prom = str_replace("�","t",$prom);
      $prom = str_replace("�","u",$prom);
      $prom = str_replace("�","u",$prom);
      $prom = str_replace("�","y",$prom);
      $prom = str_replace("�","z",$prom);
      //------------------------

      //ostatn� �pravy
      $prom = str_replace(" ","-",$prom);
      //------------------------

      //vr�cen� upraven�ho textu pro seo
      return $prom;
      //------------------------
   }
//za��tek metody upravProSeo, kter� odstran� diakritiku a uprav� v�echna p�smena na mal� a m�sto mezer pou�ije -

}
?>