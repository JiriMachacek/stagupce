{include file="hlavicka.tpl"}

<div id="levypanel">
<div id="levypanel-obsah">
<div id="menu">  
	
  {if $private_uzivatel_typ == 'admin'}
  <!-- uživatel admin -->
  Admin
  {elseif $private_uzivatel_typ == 'učitel'}
  <!-- uživatel učitel -->
  Učitel
  {elseif $private_uzivatel_typ == 'student'}
  <!-- uživatel student -->
  Student
  {/if}
  <a href="./?modul=ucebny&amp;metoda=zobraz">Ucebny</a>
	
	<a href="./?modul=materialy&amp;metoda=zobraz">Materiály</a>
	<a href="./?modul=materialy&amp;metoda=vloz">Materiály novy</a>
	<a href="./?modul=uzivatele&amp;metoda=zobraz">Uživatelé</a>
	<a href="./?modul=rozvrhzalozeni&amp;metoda=zobraz">Založení rozvrhu</a>
	<a href="./?modul=rozvrhprihlaseni&amp;metoda=zobraz">Přihlášení předmětu</a>
	<br />
	<a href="./?modul=predmet&amp;metoda=zobraz">Předměty</a>
	<a href="./?odhlaseni=1">Odhlášení</a>
</div>
</div>
</div>
<hr class="cleaner" />
