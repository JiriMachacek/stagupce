{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<h2>Předmět</h2>

<form action="./?modul=rozvrhzalozeni&amp;metoda=vloz" method="post">

  <label for="predmet">Předmět</label>
  {html_options name=predmet options=$predmety selected=$predmet}
	{if $chybapredmet}<span>Chyba! nebyl vybrán předmět</span>{/if}
	

  <label for="zacatek">Začátek</label>
  {html_options name=zacatek options=$hodiny selected=$zacatek}
  {if $chybazacatek}<span>Chyba! nebyl vyplněn začátek hodiny</span>{/if}
  
  <label for="konec">Konec</label>
  {html_options name=konec options=$hodiny selected=$konec}
  {if $chybakonec}<span>Chyba! nebyl vyplněn konec hodiny</span>{/if}
  
  <label for="typ">Den</label>
  {html_options name=den options=$dny selected=$den}
	{if $chybaden}<span>Chyba! nebyl vybrán den...</span>{/if}
  
  <label for="tyden">Týden</label>
  {html_options name=tyden options=$tydny selected=$tyden}
	{if $chybatyden}<span>Chyba! nebyl vybrán týden...</span>{/if}
  
  <label for="ucebna">Učebna</label>
  {html_options name=ucebna options=$ucebny selected=$ucebna}
	{if $chybaucebna}<span>Chyba! nebyla vybrána učebna...</span>{/if}
  
  <label for="ucitel">Vyučující</label>
  {html_options name=ucitel options=$vyucujici selected=$ucitel}
	{if $chybaucitel}<span>Chyba! nebyl vybrán vyučující...</span>{/if}

  <label for="kapacita">Kapacita</label>
  <input type="text" name="kapacita" id="kapacita" value="{$kapacita}" />
	{if $chybakapacita}<span>Chyba! Kapacita byla špatně zadaná...</span>{/if}

  <input type="submit" name="ok" value="Vlož" />
   
</form>
</div>
</div>
{include file="paticka.tpl"}
