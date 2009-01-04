<?php
class zkousky
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
    
    //modul kter� se zobraz� studentovi - ov��en� p�es CAuth - p��stup m� admin a student
    public function student()
    {
      $polePredmetu=predmety();                   //metoda n�m vr�t� p�edm�ty kter� student studuje
      $m = count($polePredmetu);                  //po�et hodnot p�enesen�ch v poli p�edm�t�
      $i = 0;                                     //nastaven� itera�n� prom. pro cyklus while
        //cyklus while, kter� vypisuje informace k zadan�m p�edm�t�m
        while($i<=$m)//pojede tak dlouho dokud i nebude stejn� velk� nebo men�� jako po�et rozd�len�ch hodnot
          {
          //na�ten� hodnot z datab�ze o jednotliv�ch p�edm�tech
          $sqlZkouska = "SELECT uzivatel_zkousejici,ID_zkouska,ID_predmet,ID_ucebna,zacatek,konec,kapacita FROM `zkouska_termin` WHERE `ID_predmet`='$polePredmetu[$i]'";
          $dataZkouska = $pdo->query($sqlZkouska)->fetch();
          //------------------------

          // pole hodnot pro sm�rty
          $zobraz["zkousejiciJmeno"][$i]=polozkaVdb("uzivatel","jmeno","WHERE ID_uzivatel = ".$dataZkouska["uzivatel_zkousejici"]);  //vyhled� v tabulce u�ivatel� podle ID jm�no
          $zobraz["zkousejiciPrimeni"][$i]=polozkaVdb("uzivatel","primeni","WHERE ID_uzivatel = ".$dataZkouska["uzivatel_zkousejici"]); //vyhled� v tabulce u�ivatel� podle ID p��m�n�
          $zobraz["ucebna"][$i]=polozkaVdb("ucebna","nazev","WHERE ID_ucebna = ".$dataZkouska["ID_ucebna"]); //n�zev u�ebny - vol�me funkci, kter� n�m vr�t� hodnotu sloupce nazev v tabulce u�eben
          $zobraz["kapacita"][$i]=$dataZkouska["kapacita"];  //kpacita na zkou�ku
          $zobraz["obsazeno"][$i]=count(obsazenostZkousky($dataZkouska["ID_zkouska"]));//po�et ji� p�ihl�en�ch lid�
          $zobraz["zacatek"][$i]=$dataZkouska["zacatek"]; //za��tek z�pisu
          $zobraz["konec"][$i]=$dataZkouska["konec"];     //konec z�pisu
          $zobraz["zapsan"][$i]=(zjisteniDuplikace(obsazenostZkousky($dataZkouska["ID_zkouska"]),$this->ID_uzivatel));     /*do hodnoty ulo�� 1 - pokud je u�ivatel ji� zaps�n, 0 pokud nen�.
          Vol� to funkci zjisteniDuplikace, kter� zjist� zda v poli, kterou p�ed� zp�tky funkce obsazenost zkou�ky je ID p�ihl�en�ho u�ivatele
          -toto bude pou�ivot na kontrolu zda se u�ivatel m��e p�ihl�sit nebo ne*/

          //------------------------
          $i++;                          //inkrementace itera�n� prom.
          }
        //konec cyklu------------------------

        //vyps�n� v�sledk� a pokus� zkou�ek
        zkouskyPokusyStudent();
        //------------------------
    }
    //konec metody student

    //modul kter� se zobraz� ucitelovi  - ov��en� p�es CAuth - p��stup m� admin a u�itel
    public function ucitel()
    {
    return 1;
    }
    //konec metody ucitel



    //metoda kter� n�m vr�t� p�edm�ty kter� dan� u�ivatel studuje
    private function predmetyStudent();
    {
    //na�ten� hodnot z datab�ze o jednotliv�ch p�edm�tech - p�es funkci polozkaVdb
    $hodiny =polozkaVdb("hodina_student","hodina_student","WHERE `ID_uzivatel_student`='".$this->ID_uzivatel."'");//vkl�d� se mysql_tabulka,sloupec,omezujici dotaz
    //------------------------
    $i=0;//itera�n� prom pro cyklus s jednotliv�mi hodinamy
    $j=0;//itera�n� prom pro cyklus s jednotliv�mi hodinamy - ale ukl�d�n� hodnot do cyklu
    $m = count($hodiny);
    while($i<$m)//prvni cyklus
      {
      $predmety[$j]=$hodiny[$i];
      if(zjisteniDuplikace($predmety,$hodiny[$i])==0)//metoda zjisti zda je v poli hodnota $hodiny[$i]
        {
        $j++;//v p��pad� �e pole neobsahuje hodnotu, nav���me hodnotu pro zapisov�n�, jinak se bude hodnota p�episovat $predmety[$j] - abysme m�li pouze jeden v�skyt p�edm�tu
        }
      }

      return $predmety;//vrac� ID na p�edm�ty kter� student studuje
    }
    //konec metody predmety

    //metoda kter� n�m zji��uje zda v dan�m poli je p�en�en� hodnota ji� obsazena -pokud je, vr�t� 0, pokud nen�, vr�t� 1
    private function zjisteniDuplikace($pole,$hodnota);
    {
    $i=0;//itera�n� prom pro cyklus s jednotliv�mi z�znamy
    $m = count($pole); //zji�t�n� po�tu z�znam� v poli
    $jeTam=0; //nastaven� n�vratov� hodnoty na 0 - t�mto se vyhneme psali else v�tv� v podm�nce 1, pokud se z�znamy rovnat nebudou, hodnota se nezm�n�
      while($j<$m) //cyklus kter� proj�d� z�znamy v poli
          {
          if($pole[$i]==$hodnota) // podm�nka 1 kter� porovn�v� zda v poli je p�edan� hodnota
            {
            $jeTam = 1;//v p��pad� �e se hodnota se z�znamem v poli rovn�, vr�t�me hodnotu
            }
          }
    return $jeTam; //vr�cen� hodnoty zda v p�ed�n�m poli pedan� hodnota je
    }
    //konec metody zkouskyPokusyStudent

    //metoda kter� n�m vyp�e pokusy zkou�ek - tedy v�sledky
    private function zapsatNaZkousku($ID_zkouska);
    {
    return 1; //nev�m jak se objektov� ukl�d� do DB.. ale sta�� tady do datab�ze ulo�it $this->ID_uzivatel, id zkou�ky se p�ed�v� v hlavi�ce
    }
    //konec metody zkouskyPokusyStudent

    //metoda kter� n�m vyp�e pokusy zkou�ek
    private function obsazenostZkousky($ID_zkouska);
    {
    //na�ten� student� z datab�ze k ur�en� obsazenosti dan� zkou�ky
    $sqlZkouska = "SELECT uzivatel_zkousejici FROM `zkouska_student` WHERE `ID_zkouska`='$ID_zkouska'";
    $dataZkouska = $pdo->query($sqlZkouska)->fetch();
    //------------------------

    return  $dataZkouska["ID_uzivatel_zkouseny"]; // vr�t� pole s u�ivateli, kte�� sou p�ihl�eni na zou�ku - tedy jejich id
    }
    //konec metody zkouskyPokusyStudent

    //metoda kter� n�m vyp�e polo�ku v db
    private function polozkaVdb($tabulka,$sloupec,$omezeni);
    {
    //na�ten� hodnoty z datab�ze podle p�edan�ch parametr�
    $sqlPolozka = "SELECT $soupev FROM $tabulka $omezeni";
    $dataPolozka = $pdo->query($sqlPolozka)->fetch();
    //------------------------
    return $dataPolozka[$sloupec]; //vr�cen� nalezen� hodnoty;
    }
    //konec metody zkouskyPokusyStudent
}