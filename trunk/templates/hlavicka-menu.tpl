{include file="hlavicka.tpl"}

<div id="levypanel">
<div id="levypanel-obsah">
<div id="menu">  
    <ul>
  {if $private_uzivatel_typ == 'admin'}
  <!-- uživatel admin -->
	<li><a href="./?modul=ucebny&amp;metoda=zobraz">Učebny</a></li>
	<li class="odsad"><a href="./?modul=ucebnytypy&amp;metoda=zobraz">Typy učeben</a></li>
	<li><a href="./?modul=materialy&amp;metoda=zobraz">Materiály</a></li>
	<li class="odsad"><a href="./?modul=materialy&amp;metoda=vloz">Materiály novy</a></li>
	<li><a href="./?modul=uzivatele&amp;metoda=zobraz">Uživatelé</a></li>
	<li><a href="./?modul=rozvrhzalozeni&amp;metoda=zobraz">Založení rozvrhu</a></li>
	<li><a href="./?modul=rozvrhprihlaseni&amp;metoda=zobraz">Přihlášení předmětu</a></li>
	<li><a href="./?modul=predmet&amp;metoda=zobraz">Předměty</a></li>
	<li><a href="./?odhlaseni=1">Odhlášení</a>
	</ul>
  {elseif $private_uzivatel_typ == 'učitel'}
  <!-- uživatel učitel -->
    <li><a href="./?modul=ucebny&amp;metoda=zobraz">Ucebny</a></li>
	<li><a href="./?modul=materialy&amp;metoda=zobraz">Materiály</a></li>
	<li><a href="./?modul=materialy&amp;metoda=vloz">Materiály novy</a></li>
	<li><a href="./?modul=uzivatele&amp;metoda=zobraz">Uživatelé</a></li>
	<li><a href="./?modul=rozvrhzalozeni&amp;metoda=zobraz">Založení rozvrhu</a></li>
	<li><a href="./?modul=predmet&amp;metoda=zobraz">Předměty</a></li>
	<li><a href="./?odhlaseni=1">Odhlášení</a></li>
  {elseif $private_uzivatel_typ == 'student'}
  <!-- uživatel student -->
  Student
	<li><a href="./?modul=materialy&amp;metoda=zobraz">Materiály</a></li>
	<li><a href="./?modul=rozvrhprihlaseni&amp;metoda=zobraz">Přihlášení předmětu</a></li>
	<li><a href="./?modul=rozvrh&amp;metoda=zobraz">Rozvrh</a></li>
	<li><a href="./?odhlaseni=1">Odhlášení</a></li>
  {/if}
</div>
</div>
</div>
<hr class="cleaner" />
