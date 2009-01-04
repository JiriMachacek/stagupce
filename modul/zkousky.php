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
      $polePredmetu=predmetyStudent();                   //metoda nám vrátí pøedmìty který student studuje
      $m = count($polePredmetu);                  //poèet hodnot pøenesených v poli pøedmìtù
      $i = 0;                                     //nastavení iteraèní prom. pro cyklus while
        //cyklus while, který vypisuje informace k zadaným pøedmìtùm
        while($i<=$m)//pojede tak dlouho dokud i nebude stejnì velké nebo menší jako poèet rozdìlených hodnot
          {
          //naètení hodnot z databáze o jednotlivých pøedmìtech
          $sqlZkouska = "SELECT ID_uzivatel_zkousejici,ID_zkouska,ID_predmet,ID_ucebna,zacatek,konec,kapacita FROM `zkouska_termin` WHERE `ID_predmet`='$polePredmetu[$i]'";
          $dataZkouska = $pdo->query($sqlZkouska)->fetch();
          //------------------------

          // pole hodnot pro smárty
          $zobraz["zkousejiciJmeno"][$i]=polozkaVdb("uzivatel","jmeno","WHERE ID_uzivatel = ".$dataZkouska["uzivatel_zkousejici"]);  //vyhledá v tabulce uživatelù podle ID jméno
          $zobraz["zkousejiciPrimeni"][$i]=polozkaVdb("uzivatel","primeni","WHERE ID_uzivatel = ".$dataZkouska["uzivatel_zkousejici"]); //vyhledá v tabulce uživatelù podle ID pøímìní
          $zobraz["ucebna"][$i]=polozkaVdb("ucebna","nazev","WHERE ID_ucebna = ".$dataZkouska["ID_ucebna"]); //název uèebny - voláme funkci, která nám vrátí hodnotu sloupce nazev v tabulce uèeben
          $zobraz["kapacita"][$i]=$dataZkouska["kapacita"];  //kpacita na zkoušku
          $zobraz["obsazeno"][$i]=count(obsazenostZkousky($dataZkouska["ID_zkouska"]));//poèet již pøihlášených lidí
          $zobraz["zacatek"][$i]=$dataZkouska["zacatek"]; //zaèátek zápisu
          $zobraz["konec"][$i]=$dataZkouska["konec"];     //konec zápisu
          $zobraz["zapsan"][$i]=(zjisteniDuplikace(obsazenostZkousky($dataZkouska["ID_zkouska"]),$this->ID_uzivatel));     /*do hodnoty uloží 1 - pokud je uživatel již zapsán, 0 pokud není.
          Volá to funkci zjisteniDuplikace, která zjistí zda v poli, kterou pøedá zpátky funkce obsazenost zkoušky je ID pøihlášeného uživatele
          -toto bude použivot na kontrolu zda se uživatel mùže pøihlásit nebo ne*/

          //------------------------
          $i++;                          //inkrementace iteraèní prom.
          }
        //konec cyklu------------------------
    return $zobraz;
    }
    //konec metody student

    //metoda která nám vrátí pøedmìty které daný uživatel studuje
    private function predmetyStudent();
    {
    //naètení hodnot z databáze o jednotlivých pøedmìtech - pøes funkci polozkaVdb
    $hodiny =polozkaVdb("hodina_student","ID_hodina","WHERE `ID_uzivatel_student`='".$this->ID_uzivatel."'");//vkládá se mysql_tabulka,sloupec,omezujici dotaz
    //------------------------
    $i=0;//iteraèní prom pro cyklus s jednotlivými hodinamy
    $j=0;//iteraèní prom pro cyklus s jednotlivými hodinamy - ale ukládání hodnot do cyklu
    $m = count($hodiny);
    while($i<$m)//prvni cyklus
      {
      $predmety[$j]=$hodiny[$i];
      if(zjisteniDuplikace($predmety,$hodiny[$i])==0)//metoda zjisti zda je v poli hodnota $hodiny[$i]
        {
        $j++;//v pøípadì že pole neobsahuje hodnotu, navýšíme hodnotu pro zapisování, jinak se bude hodnota pøepisovat $predmety[$j] - abysme mìli pouze jeden výskyt pøedmìtu
        }
      $++
      }

      return $predmety;//vrací ID na pøedmìty které student studuje
    }
    //konec metody predmety

    //modul který se zobrazí ucitelovi  - ovìøení pøes CAuth - pøístup má admin a uèitel
    public function ucitel()
    {
      $polePredmetu=predmetyUcitel();                   //metoda nám vrátí pøedmìty který uèitel uèí
      $m = count($polePredmetu);                  //poèet hodnot pøenesených v poli pøedmìtù
      $i = 0;                                     //nastavení iteraèní prom. pro cyklus while
        //cyklus while, který vypisuje informace k zadaným pøedmìtùm
        while($i<=$m)//pojede tak dlouho dokud i nebude stejnì velké nebo menší jako poèet rozdìlených hodnot
          {
          //naètení hodnot z databáze o jednotlivých pøedmìtech
          $sqlZkouska = "SELECT ID_zkouska,ID_predmet,ID_ucebna,zacatek,konec,kapacita FROM `zkouska_termin` WHERE `ID_predmet`='$polePredmetu[$i]' and ID_uzivatel_zkousejici='".$this->ID_uzivatel."'";
          $dataZkouska = $pdo->query($sqlZkouska)->fetch();
          //------------------------

          // pole hodnot pro smárty
          $zobraz["ucebna"][$i]=polozkaVdb("ucebna","nazev","WHERE ID_ucebna = ".$dataZkouska["ID_ucebna"]); //název uèebny - voláme funkci, která nám vrátí hodnotu sloupce nazev v tabulce uèeben
          $zobraz["kapacita"][$i]=$dataZkouska["kapacita"];  //kpacita na zkoušku
          $zobraz["obsazeno"][$i]=count(obsazenostZkousky($dataZkouska["ID_zkouska"]));//poèet již pøihlášených lidí
          $zobraz["zacatek"][$i]=$dataZkouska["zacatek"]; //zaèátek zápisu
          $zobraz["konec"][$i]=$dataZkouska["konec"];     //konec zápisu
          }
          return $zobraz;
    }
    //konec metody ucitel

    //metoda která pøidá zkoušku
    public function pridatTerminZkousky()
    {
    return 1;
    }
    //konec funkce pøidat zkoušku

    //metoda která upraví zkoušku
    public function upravitTerminZkousky()
    {
    return 1;
    }
    //konec funkce upravit zkoušku

    //metoda která zobrazí studentovi výsledky jeho zkoušek
    public function vysledkyZkousekStudent()
    {
    return 1;
    }
    //konec funkce zobrazit výsledky

    //metoda která zobrazení studenty kteøí sou pøihlášeni na zkoušku
    public function obsazeniZkousky($ID_zkouska);//pøedává se ID_zkoušky u které to chcem zjistit
    {
    $studenti = obsazenostZkousky($ID_zkouska); //uloží id studentù získané z funkce obsazenostZkousky do pole
    $i=0;//iteraèní prom pro cyklus 1 s jednotlivými studenty
    $m = count($studenti);//spoèítá studenty
    while($i<$m)//cyklus 1
      {
      $zobraz["jmeno"][$i]=polozkaVdb("uzivatel","jmeno","WHERE ID_uzivatel = ".$studenti[$i]);//naète v db studentovo jmeno a ulozi do noveho pole ktere se pak preda smartum
      $zobraz["primeni"][$i]=polozkaVdb("uzivatel","primeni","WHERE ID_uzivatel = ".$studenti[$i]); //naète v db studentovo primeni a ulozi do noveho pole ktere se pak preda smartum
      $i++;
      }
      return $zobraz;
    }
    //konec funkce upravit zkoušku

    //metoda která nám vrátí pøedmìty které daný uèitel uèí
    private function predmetyUcitel();
    {
    //naètení hodnot z databáze o jednotlivých pøedmìtech - pøes funkci polozkaVdb - vrátí ID_predmet v poli
    $hodiny =polozkaVdb("hodina","ID_predmet","WHERE `ID_uzivatel_vyucujici`='".$this->ID_uzivatel."'");//vkládá se mysql_tabulka,sloupec,omezujici dotaz
    //------------------------
    $i=0;//iteraèní prom pro cyklus s jednotlivými hodinamy
    $j=0;//iteraèní prom pro cyklus s jednotlivými hodinamy - ale ukládání hodnot do cyklu
    $m = count($hodiny);
    while($i<$m)//prvni cyklus
      {
      $predmety[$j]=$hodiny[$i];
      if(zjisteniDuplikace($predmety,$hodiny[$i])==0)//metoda zjisti zda je v poli hodnota $hodiny[$i]
        {
        $j++;//v pøípadì že pole neobsahuje hodnotu, navýšíme hodnotu pro zapisování, jinak se bude hodnota pøepisovat $predmety[$j] - abysme mìli pouze jeden výskyt pøedmìtu
        }
      $i++;
      }

      return $predmety;//vrací ID na pøedmìty které uèitel uèí
    }
    //konec metody predmety

    //metoda která nám zjišuje zda v daném poli je pøenášená hodnota již obsazena -pokud je, vrátí 0, pokud není, vrátí 1
    private function zjisteniDuplikace($pole,$hodnota);
    {
    $i=0;//iteraèní prom pro cyklus s jednotlivými záznamy
    $m = count($pole); //zjištìní poètu záznamù v poli
    $jeTam=0; //nastavení návratové hodnoty na 0 - tímto se vyhneme psali else vìtví v podmínce 1, pokud se záznamy rovnat nebudou, hodnota se nezmìní
      while($j<$m) //cyklus který projíždí záznamy v poli
          {
          if($pole[$i]==$hodnota) // podmínka 1 která porovnává zda v poli je pøedaná hodnota
            {
            $jeTam = 1;//v pøípadì že se hodnota se záznamem v poli rovná, vrátíme hodnotu
            }
          }
    return $jeTam; //vrácení hodnoty zda v pøedáném poli pedaná hodnota je
    }
    //konec metody zkouskyPokusyStudent

    //metoda která nám vypíše pokusy zkoušek - tedy výsledky
    private function zapsatNaZkousku($ID_zkouska);
    {
    return 1; //nevím jak se objektovì ukládá do DB.. ale staèí tady do databáze uložit $this->ID_uzivatel, id zkoušky se pøedává v hlavièce
    }
    //konec metody zkouskyPokusyStudent

    //metoda která nám vypíše pokusy zkoušek
    private function obsazenostZkousky($ID_zkouska);
    {
    //naètení studentù z databáze k urèení obsazenosti dané zkoušky
    $sqlZkouska = "SELECT uzivatel_zkousejici FROM `zkouska_student` WHERE `ID_zkouska`='$ID_zkouska'";
    $dataZkouska = $pdo->query($sqlZkouska)->fetch();
    //------------------------

    return  $dataZkouska["ID_uzivatel_zkouseny"]; // vrátí pole s uživateli, kteøí sou pøihlášeni na zoušku - tedy jejich id
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