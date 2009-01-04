<?php
class zkousky
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
    
    //modul který se zobrazí studentovi - ovìøení pøes CAuth - pøístup má admin a student
    public function student()
    {
      $polePredmetu=predmety();                   //metoda nám vrátí pøedmìty který student studuje
      $m = count($polePredmetu);                  //poèet hodnot pøenesených v poli pøedmìtù
      $i = 0;                                     //nastavení iteraèní prom. pro cyklus while
        //cyklus while, který vypisuje informace k zadaným pøedmìtùm
        while($i<=$m)//pojede tak dlouho dokud i nebude stejnì velké nebo menší jako poèet rozdìlených hodnot
          {
          //naètení hodnot z databáze o jednotlivých pøedmìtech
          $sqlZkouska = "SELECT uzivatel_zkousejici,ID_zkouska,ID_predmet,ID_ucebna,zacatek,konec,kapacita FROM `zkouska_termin` WHERE `ID_predmet`='$polePredmetu[$i]'";
          $dataZkouska = $pdo->query($sqlZkouska)->fetch();
          //------------------------

          // pole hodnot pro smárty
          $zobraz["zkousejiciJmeno"][$i]=polozkaVdb("uzivatel","jmeno","WHERE ID_uzivatel = ".$dataZkouska["uzivatel_zkousejici"]);  //vyhledá v tabulce uživatelù podle ID jméno
          $zobraz["zkousejiciPrimeni"][$i]=polozkaVdb("uzivatel","primeni","WHERE ID_uzivatel = ".$dataZkouska["uzivatel_zkousejici"]); //vyhledá v tabulce uživatelù podle ID pøímìní
          $zobraz["ucebna"][$i]=polozkaVdb("ucebna","nazev","WHERE ID_ucebna = ".$dataZkouska["ID_ucebna"]); //název uèebny - voláme funkci, která nám vrátí hodnotu sloupce nazev v tabulce uèeben
          $zobraz["kapacita"][$i]=$dataZkouska["kapacita"];  //kpacita na zkoušku
          $zobraz["obsazeno"][$i]=obsazenostZkousky($dataZkouska["ID_zkouska"]);//poèet již pøihlášených lidí
          $zobraz["zacatek"][$i]=$dataZkouska["zacatek"]; //zaèátek zápisu
          $zobraz["konec"][$i]=$dataZkouska["konec"];     //konec zápisu
          //------------------------
          $i++;                          //inkrementace iteraèní prom.
          }
        //konec cyklu------------------------

        //vypsání výsledkù a pokusù zkoušek
        zkouskyPokusyStudent();
        //------------------------
    }
    //konec metody student

    //modul který se zobrazí ucitelovi  - ovìøení pøes CAuth - pøístup má admin a uèitel
    public function ucitel()
    {
    return 1;
    }
    //konec metody ucitel



    //metoda která nám vrátí pøedmìty které daný uživatel studuje
    private function predmetyStudent();
    {
    //naètení hodnot z databáze o jednotlivých pøedmìtech - pøes funkci polozkaVdb
    $hodiny =polozkaVdb("hodina_student","hodina_student","WHERE `ID_uzivatel_student`='".$this->ID_uzivatel."'");//vkládá se mysql_tabulka,sloupec,omezujici dotaz
    //------------------------
    $i=0;//iteraèní prom pro cyklus s jednotlivými hodinamy
    $j=0;//iteraèní prom pro cyklus s jednotlivými hodinamy - ale ukládání hodnot do cyklu
    $m = count($hodiny);
    while($i<$m)//prvni cyklus
      {
      $predmety[$j]=$hodiny[$i];
      if(zjisteniDuplikace($predmety,$hodiny[$i])==1)//metoda zjisti zda je v poli hodnota $hodiny[$i]
        {
        $j++;//v pøípadì že pole neobsahuje hodnotu, navýšíme hodnotu pro zapisování, jinak se bude hodnota pøepisovat $predmety[$j] - abysme mìli pouze jeden výskyt pøedmìtu
        }
      }

      return $predmety;//vrací ID na pøedmìty které student studuje
    }
    //konec metody predmety

    //metoda která nám zjišuje zda v daném poli je pøenášená hodnota již obsazena -pokud je, vrátí 0, pokud není, vrátí 1
    private function zjisteniDuplikace($pole,$hodnota);
    {
    $i=0;//iteraèní prom pro cyklus s jednotlivými záznamy
    $m = count($pole); //zjištìní poètu záznamù v poli
    $jeTam=1; //nastavení návratové hodnoty na 1 - tímto se vyhneme psali else vìtví v podmínce 1, pokud se záznamy rovnat nebudou, hodnota se nezmìní
      while($j<$m) //cyklus který projíždí záznamy v poli
          {
          if($pole[$i]==$hodnota) // podmínka 1 která porovnává zda v poli je pøedaná hodnota
            {
            $jeTam = 0;//v pøípadì že se hodnota se záznamem v poli rovná, vrátíme hodnotu
            }
          }
    return $jeTam; //vrácení hodnoty zda v pøedáném poli pedaná hodnota je
    }
    //konec metody zkouskyPokusyStudent

    //metoda která nám vypíše pokusy zkoušek
    private function zapsatNaZkousku($ID_predmet);
    {
    return 1;
    }
    //konec metody zkouskyPokusyStudent

    //metoda která nám vypíše pokusy zkoušek
    private function zkouskyPokusyStudent();
    {
    return 1;
    }
    //konec metody zkouskyPokusyStudent

    //metoda která nám vypíše pokusy zkoušek
    private function obsazenostZkousky($ID_zkouska);
    {
    //naètení studentù z databáze k urèení obsazenosti dané zkoušky
    $sqlZkouska = "SELECT uzivatel_zkousejici FROM `zkouska_student` WHERE `ID_zkouska`='$ID_zkouska'";
    $dataZkouska = $pdo->query($sqlZkouska)->fetch();
    //------------------------

    $m = count($dataZkouska["ID_uzivatel_zkouseny"]); // spoèítání poètu položek vytažené z databáze - tedy obsazení u zkoušky
    return $m;
    }
    //konec metody zkouskyPokusyStudent

    //metoda která nám vypíše položku v db
    private function polozkaVdb($tabulka,$sloupec,$omezeni);
    {
    //naètení hodnoty z databáze podle pøedaných parametrù
    $sqlPolozka = "SELECT $soupev FROM $tabulka $omezeni";
    $dataPolozka = $pdo->query($sqlPolozka)->fetch();
    //------------------------
    return $dataPolozka[$sloupec]; //vrácení nalezené hodnoty;
    }
    //konec metody zkouskyPokusyStudent
}