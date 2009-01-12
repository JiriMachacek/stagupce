{include file="hlavicka-menu.tpl"}
<div id="hlavnipanel">
<div id="hlavnipanel-obsah">

<h2>Předmět: {$predmet}</h2>

<form action="./?modul=rozvrhzalozeni&amp;metoda=vloz&amp;predmet={$ID_predmet}" method="post">

  <label for="zacatek">Začátek</label>
  <input type="text" name="zacatek" id="zacatek" value="{$zacatek}" />
  {if $chybazacatek}Chyba! nebyl vyplněn začátek hodiny nebo formát neodpovídá HH:MM{/if}
  <label for="konec">Konec</label>
  <input type="text" name="konec" id="konec" value="{$konec}" />
  {if $chybakonec}Chyba! nebyl vyplněn konec hodiny nebo formát neodpovídá HH:MM{/if}
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