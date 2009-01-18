{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<h2>Předmět</h2>

<form action="./?modul=rozvrhzalozeni&amp;metoda=vloz" method="post">

  <label for="predmet">Předmět</label>
  {html_options name=predmet options=$predmety selected=$predmet}
	{if $chybapredmet}Chyba! nebyl vybrán předmět{/if}
	

  <label for="zacatek">Začátek</label>
  {html_options name=zacatek options=$hodiny selected=$zacatek}
  {if $chybazacatek}Chyba! nebyl vyplněn začátek hodiny{/if}
  
  <label for="konec">Konec</label>
  {html_options name=konec options=$hodiny selected=$konec}
  {if $chybakonec}Chyba! nebyl vyplněn konec hodiny{/if}
  
  <label for="typ">Den</label>
  {html_options name=den options=$dny selected=$den}
	{if $chybaden}Chyba! nebyl vybrán den...{/if}
  
  <label for="tyden">Týden</label>
  {html_options name=tyden options=$tydny selected=$tyden}
	{if $chybatyden}Chyba! nebyl vybrán týden...{/if}
  
  <label for="ucebna">Učebna</label>
  {html_options name=ucebna options=$ucebny selected=$ucebna}
	{if $chybaucebna}Chyba! nebyla vybrána učebna...{/if}
  
  <label for="ucitel">Vyučující</label>
  {html_options name=ucitel options=$vyucujici selected=$ucitel}
	{if $chybaucitel}Chyba! nebyl vybrán vyučující...{/if}

  <label for="kapacita">Kapacita</label>
  <input type="text" name="kapacita" id="kapacita" value="{$kapacita}" />
	{if $chybakapacita}Chyba! Kapacita byla špatně zadaná...{/if}

  <input type="submit" name="ok" value="Vlož" />
   
</form>
</div>
</div>
{include file="paticka.tpl"}